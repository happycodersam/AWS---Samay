<?php
// Payment initiation is intentionally disabled until real sandbox credentials and server-side verification are configured.
http_response_code(503);
header('Content-Type: text/html; charset=utf-8');
echo '<!doctype html><meta charset="utf-8"><title>Sandbox payment not configured</title><p>PayPal sandbox is not configured yet. No payment was taken. Configure credentials and verified return handling before enabling payment.</p><p><a href="checkout.php">Return to checkout</a></p>';
