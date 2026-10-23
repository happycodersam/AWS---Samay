<?php
require_once '../includes/bootstrap.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: ../index.php'); exit; }
verify_csrf();
$id = (int)($_POST['product_id'] ?? 0);
$p = find_product($conn, $id);
if (!$p) { header('Location: index.php'); exit; }
$key = (string)$p['id'];
if (isset($_SESSION['cart'][$key])) {
    $_SESSION['cart'][$key]['quantity'] = min(99, (int)$_SESSION['cart'][$key]['quantity'] + 1);
} else {
    $_SESSION['cart'][$key] = ['product_id'=>(int)$p['id'], 'name'=>$p['name'], 'price'=>(float)$p['price'], 'image'=>$p['image'], 'quantity'=>1];
}
$return = trim($_POST['return_to'] ?? 'cart.php');
if (str_contains($return, '://') || str_starts_with($return, '//') || str_contains($return, "\\")) $return = 'cart.php';
// Root-relative same-site URLs are allowed; protocol-relative/external URLs are rejected above.
header('Location: ' . $return); exit;
