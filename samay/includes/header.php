<?php $pageTitle = $pageTitle ?? 'Samay — Time, beautifully told';
$activeNav = $activeNav ?? '';
$base = (strpos($_SERVER['SCRIPT_NAME'] ?? '', '/session/') !== false ? '../' : ''); ?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#f5f1e9">
    <title><?= h($pageTitle) ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= $base ?>assets/samay.css">
</head>

<body>
    <div class="announcement">A little more time for what matters <span>✦</span> Discover your signature timepiece</div>
    <header class="site-header"><a class="wordmark" href="<?= $base ?>index.php">samay<span>.</span><small>TIME, BEAUTIFULLY TOLD</small></a><button class="menu-toggle" aria-label="Toggle navigation" onclick="document.body.classList.toggle('nav-open')">☰</button>
        <nav class="main-nav"><a class="<?= $activeNav === 'home' ? 'active' : '' ?>" href="<?= $base ?>index.php">Home</a><a class="<?= $activeNav === 'men' ? 'active' : '' ?>" href="<?= $base ?>men.php">Men</a><a class="<?= $activeNav === 'women' ? 'active' : '' ?>" href="<?= $base ?>women.php">Women</a><a class="<?= $activeNav === 'luxury' ? 'active' : '' ?>" href="<?= $base ?>luxury.php">Luxury</a><a class="<?= $activeNav === 'smart' ? 'active' : '' ?>" href="<?= $base ?>smart.php">Smart</a></nav>
        <div class="header-actions"><a class="icon-link" href="<?= $base ?>search.php" aria-label="Search">⌕ <span>Search</span></a><a class="icon-link" href="<?= $base ?>wishlist.php" aria-label="Saved items">♡ <span>Saved</span></a><a class="icon-link" href="<?= $base ?>session/cart.php" aria-label="Shopping bag">♧ <span>Bag</span><b class="count"><?= cart_count() ?></b></a><?php if (current_user()): ?><div class="account-menu"><span class="welcome">Hi, <?= h($_SESSION['user']) ?></span><a href="<?= $base ?>account.php">Account</a><a href="<?= $base ?>logout.php">Log out</a></div><?php else: ?><a class="login-link" href="<?= $base ?>login.php">Sign in</a><?php endif; ?></div>
    </header>
    <main>