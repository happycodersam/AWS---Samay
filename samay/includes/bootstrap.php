<?php
if (session_status() !== PHP_SESSION_ACTIVE) { session_set_cookie_params(['httponly'=>true,'samesite'=>'Lax','secure'=>!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS']!=='off']); session_start(); }
require_once __DIR__.'/../db.php';
if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(32));
function h($v){ return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
function money($v){ return '₹'.number_format((float)$v, 0); }
function csrf_field(){ echo '<input type="hidden" name="csrf" value="'.h($_SESSION['csrf']).'">'; }
function verify_csrf(){ if($_SERVER['REQUEST_METHOD']==='POST' && !hash_equals($_SESSION['csrf'] ?? '', $_POST['csrf'] ?? '')) { http_response_code(403); exit('This form expired. Go back, refresh the page, and try again.'); } }
function current_user(){ return $_SESSION['user'] ?? null; }
function product_columns($conn){ static $cols=null; if($cols!==null)return $cols; $cols=[]; try{$q=$conn->query('SHOW COLUMNS FROM products');while($x=$q->fetch_assoc())$cols[]=$x['Field'];}catch(Throwable $e){} return $cols; }


function get_products($conn, $category = null, $search = '') {
    $sql = "
        SELECT
            p.id AS id,
            p.name AS name,
            p.price AS price,
            COALESCE(b.name, '') AS brand,
            COALESCE(c.name, '') AS category,
            COALESCE(p.image_url, '') AS image
        FROM products p
        LEFT JOIN brands b ON b.id = p.brand_id
        LEFT JOIN categories c ON c.id = p.category_id
        WHERE p.is_active = 1
    ";

    $types = '';
    $args = [];

    if ($category !== null && $category !== '') {
        $sql .= " AND LOWER(c.name) = LOWER(?)";
        $types .= 's';
        $args[] = $category;
    }

    if ($search !== '') {
        $sql .= " AND (
            p.name LIKE ?
            OR b.name LIKE ?
            OR c.name LIKE ?
            OR p.sku LIKE ?
        )";

        $types .= 'ssss';
        $term = '%' . $search . '%';
        array_push($args, $term, $term, $term, $term);
    }

    $sql .= " ORDER BY p.id DESC";

    $stmt = $conn->prepare($sql);

    if ($types !== '') {
        $stmt->bind_param($types, ...$args);
    }

    $stmt->execute();

    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

function find_product($conn,$id){ foreach(get_products($conn) as $p)if((string)$p['id']===(string)$id)return $p;return null; }
function wishlist_ids($conn){$out=[];if(!current_user())return $out;try{$st=$conn->prepare('SELECT product_id FROM wishlist WHERE username=?');$st->bind_param('s',$_SESSION['user']);$st->execute();$res=$st->get_result();while($x=$res->fetch_assoc())$out[]=(string)$x['product_id'];}catch(Throwable $e){}return $out;}
function cart_count(){ $n=0;foreach($_SESSION['cart']??[] as $it)$n+=(int)($it['quantity']??1);return $n; }
