<?php require_once 'includes/bootstrap.php';
$pageTitle = 'Watches for her | Samay';
$activeNav = 'women';
$products = get_products($conn, 'Women');
$savedIds = wishlist_ids($conn);
require 'includes/header.php'; ?>
<section class="page-intro">
    <div class="kicker">Samay selection</div>
    <h1>Watches for her.</h1>
    <p>Thoughtfully selected timepieces for the moments that make you, you.</p>
</section>
<section class="section">
    <div class="section-heading">
        <div>
            <div class="kicker">The collection</div>
            <h2>Women watches</h2>
        </div><span class="text-link"><?= count($products) ?> styles to explore</span>
    </div><?php if ($products): ?><div class="product-grid"><?php foreach ($products as $p) require 'includes/product-card.php'; ?></div><?php else: ?><div class="empty-state">
            <h2>Curating this collection.</h2>
            <p>No active products are currently assigned to this category in your database.</p><a class="button" href="session/index.php">Browse all watches</a>
        </div><?php endif; ?>
</section><?php require 'includes/footer.php'; ?>