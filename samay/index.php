<?php require_once 'includes/bootstrap.php';
$pageTitle = 'Samay — Time, beautifully told';
$activeNav = 'home';
$all = get_products($conn);
$savedIds = wishlist_ids($conn);
$featured = array_slice($all, 0, 8);
require 'includes/header.php'; ?>
<section class="hero">
    <div class="hero-copy"><span class="eyebrow">The art of keeping time</span>
        <h1>Every second,<br><em>your signature.</em></h1>
        <p>Discover considered timepieces that feel less like an accessory and more like a part of your story. Modern icons, timeless classics, and pieces made to be kept.</p><a class="button" href="session/index.php">Explore the collection <span>↗</span></a>
    </div>
    <div class="hero-visual" role="img" aria-label="Luxury wristwatch close-up"></div>
</section>
<section class="section">
    <div class="section-heading">
        <div>
            <div class="kicker">Find your feeling</div>
            <h2>A watch for every you.</h2>
        </div><a class="text-link" href="session/index.php">Explore all watches ↗</a>
    </div>
    <div class="category-grid"><a class="category-tile" href="men.php"><img loading="lazy" src="https://images.unsplash.com/photo-1524805444758-089113d48a6d?auto=format&fit=crop&w=800&q=85" alt="Classic men's watch">
            <div>
                <h3>For him</h3><span>Confident classics ↗</span>
            </div>
        </a><a class="category-tile" href="women.php"><img loading="lazy" src="https://images.unsplash.com/photo-1547996160-81dfa63595aa?auto=format&fit=crop&w=800&q=85" alt="Elegant watch">
            <div>
                <h3>For her</h3><span>Quiet statements ↗</span>
            </div>
        </a><a class="category-tile" href="luxury.php"><img loading="lazy" src="https://images.unsplash.com/photo-1523170335258-f5ed11844a49?auto=format&fit=crop&w=800&q=85" alt="Luxury timepiece">
            <div>
                <h3>The luxury edit</h3><span>Exceptional by design ↗</span>
            </div>
        </a><a class="category-tile" href="smart.php"><img loading="lazy" src="https://images.unsplash.com/photo-1508685096489-7aacd43bd3b1?auto=format&fit=crop&w=800&q=85" alt="Smart watch">
            <div>
                <h3>Smart living</h3><span>Life in sync ↗</span>
            </div>
        </a></div>
</section>
<section class="section" style="padding-top:15px">
    <div class="section-heading">
        <div>
            <div class="kicker">Chosen with intention</div>
            <h2>Pieces worth a second look.</h2>
        </div><a class="text-link" href="session/index.php">Shop the collection ↗</a>
    </div><?php if ($featured): ?><div class="product-grid"><?php foreach ($featured as $p) require 'includes/product-card.php'; ?></div><?php else: ?><div class="empty-state">
            <h2>Your collection starts here.</h2>
            <p>Import database.sql to create the catalog, then add your products in MySQL.</p>
        </div><?php endif; ?>
</section>
<section class="story-band">
    <div class="story-image"></div>
    <div class="story-copy">
        <div class="kicker">Made to mean something</div>
        <h2>Not just how you spend time.<br>How you make it count.</h2>
        <p>From the first big moment to the everyday rituals, find a piece that becomes part of your own story.</p><a class="button outline" href="search.php">Find your timepiece ↗</a>
    </div>
</section>
<?php require 'includes/footer.php'; ?>