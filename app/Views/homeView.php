<?php

use App\Helpers\ViewHelper;

$page_title = t('nav.home');
ViewHelper::loadHeader($page_title);
$topRatedShows = $data['topRatedShows'] ?? [];
?>
<h1><?= hs(t('home.welcome')) ?></h1>
<p><?= hs(t('home.intro')) ?></p>

<div id="topShowsCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
    <div class="carousel-inner">
        <?php foreach ($topRatedShows as $index => $show): ?>
            <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                <div class="featured-review-card">
                    <img
                        class="featured-bg"
                        src="/theater-app/<?= hs($show['poster_image']) ?>"
                        alt="<?= hs($show['title']) ?>">
                    <div class="featured-overlay"></div>
                    <div class="featured-content">
                        <h2 class="featured-title"><?= hs($show['title']) ?></h2>
                        <blockquote class="featured-review">
                            “<?= hs($show['featured_comment']) ?>”
                        </blockquote>
                        <div class="featured-stars">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <i class="bi bi-star<?= $i <= round($show['average_rating']) ? '-fill' : '' ?>"></i>
                            <?php endfor; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php
ViewHelper::loadJsScripts();
ViewHelper::loadFooter();
