<?php
require_once '../includes/bootstrap.php';

$cart = $_SESSION['cart'] ?? [];
$total = 0.0;

foreach ($cart as $item) {
    $price = max(0, (float)($item['price'] ?? 0));
    $quantity = max(0, (int)($item['quantity'] ?? 0));
    $total += $price * $quantity;
}

$pageTitle = 'Checkout | Samay';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($cart)) {
    verify_csrf();

    $details = [
        'name' => trim((string)($_POST['name'] ?? '')),
        'email' => trim((string)($_POST['email'] ?? '')),
        'address' => trim((string)($_POST['address'] ?? '')),
        'city' => trim((string)($_POST['city'] ?? '')),
        'pin' => trim((string)($_POST['pin'] ?? '')),
    ];
    $_SESSION['checkout_details'] = $details;

    $valid = $details['name'] !== ''
        && mb_strlen($details['name']) <= 100
        && filter_var($details['email'], FILTER_VALIDATE_EMAIL)
        && strlen($details['email']) <= 254
        && $details['address'] !== ''
        && mb_strlen($details['address']) <= 255
        && $details['city'] !== ''
        && mb_strlen($details['city']) <= 100
        && preg_match('/^[0-9]{6}$/', $details['pin']);

    if ($valid) {
        header('Location: paypal/checkout.php');
        exit;
    }

    $_SESSION['checkout_error'] = 'Please check all fields. Enter a valid email and a 6-digit PIN code.';
}

require '../includes/header.php';
?>
<section class="page-intro">
    <div class="kicker">Almost yours</div>
    <h1>Checkout.</h1>
    <p>Just a few details before your timepiece begins its next chapter.</p>
</section>

<section class="section">
    <div class="cart-layout">
        <div class="account-content">
            <h2>Delivery details</h2>

            <?php if (!empty($_SESSION['checkout_error'])): ?>
                <div class="form-error" role="alert">
                    <?= h($_SESSION['checkout_error']) ?>
                </div>
                <?php unset($_SESSION['checkout_error']); ?>
            <?php endif; ?>

            <?php if (!empty($cart)): ?>
                <?php $details = $_SESSION['checkout_details'] ?? []; ?>
                <form method="post" action="">
                    <?php csrf_field(); ?>

                    <div class="form-field">
                        <label for="checkout-name">Full name</label>
                        <input id="checkout-name" name="name" type="text"
                               autocomplete="name" maxlength="100" required
                               value="<?= h($details['name'] ?? '') ?>">
                    </div>

                    <div class="form-field">
                        <label for="checkout-email">Email address</label>
                        <input id="checkout-email" name="email" type="email"
                               autocomplete="email" maxlength="254" required
                               value="<?= h($details['email'] ?? '') ?>">
                    </div>

                    <div class="form-field">
                        <label for="checkout-address">Delivery address</label>
                        <input id="checkout-address" name="address" type="text"
                               autocomplete="street-address" maxlength="255" required
                               value="<?= h($details['address'] ?? '') ?>">
                    </div>

                    <div class="form-field">
                        <label for="checkout-city">City</label>
                        <input id="checkout-city" name="city" type="text"
                               autocomplete="address-level2" maxlength="100" required
                               value="<?= h($details['city'] ?? '') ?>">
                    </div>

                    <div class="form-field">
                        <label for="checkout-pin">PIN code</label>
                        <input id="checkout-pin" name="pin" type="text"
                               inputmode="numeric" autocomplete="postal-code"
                               pattern="[0-9]{6}" minlength="6" maxlength="6"
                               title="Enter a 6-digit PIN code" required
                               value="<?= h($details['pin'] ?? '') ?>">
                    </div>

                    <button class="button" type="submit">Continue to payment ↗</button>
                </form>
            <?php else: ?>
                <div class="empty-state">
                    <h2>Your bag is empty.</h2>
                    <a class="button" href="index.php">Shop watches</a>
                </div>
            <?php endif; ?>
        </div>

        <aside class="cart-summary" aria-label="Order summary">
            <div class="kicker">Order summary</div>
            <h2><?= count($cart) ?> item type(s)</h2>

            <?php foreach ($cart as $item): ?>
                <?php
                $itemName = (string)($item['name'] ?? 'Watch');
                $quantity = max(0, (int)($item['quantity'] ?? 0));
                $price = max(0, (float)($item['price'] ?? 0));
                ?>
                <div class="summary-line">
                    <span><?= h($itemName) ?> × <?= $quantity ?></span>
                    <strong><?= money($price * $quantity) ?></strong>
                </div>
            <?php endforeach; ?>

            <div class="summary-line">
                <strong>Total</strong>
                <strong><?= money($total) ?></strong>
            </div>

            <div class="notice">
                PayPal sandbox payments are not enabled until credentials and server-side verification are configured. This demo does not collect real payments.
            </div>
        </aside>
    </div>
</section>
<?php require '../includes/footer.php'; ?>
