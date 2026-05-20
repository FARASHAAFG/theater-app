<?php

use App\Helpers\ViewHelper;
//TODO: set the page title dynamically based on the view being rendered in the controller.
$page_title = 'Home';
ViewHelper::loadHeader($page_title);
$topRatedShows = $data['topRatedShows'] ?? [];
//dd($topRatedShows);
?>
<h1>Welcome to LivePlay!</h1>
</br>
<p>Discover the magic of all theater with LivePlay! Explore our curated selection of shows, read reviews from fellow theater enthusiasts, and book your tickets for an unforgettable experience. Whether you're a fan of drama, comedy, or musicals, LivePlay has something for everyone. Dive into the world of live performances and let the show begin!</p>
<div id="topShowsCarousel"
    class="carousel slide carousel-fade"
    data-bs-ride="carousel">

    <div class="carousel-inner">

        <?php foreach ($topRatedShows as $index => $show): ?>

            <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">

                <div class="featured-review-card">

                    <!-- BACKGROUND IMAGE -->
                    <img
                        class="featured-bg"
                        src="/theater-app/<?= hs($show['poster_image']) ?>"
                        alt="<?= hs($show['title']) ?>">

                    <!-- DARK OVERLAY -->
                    <div class="featured-overlay"></div>

                    <!-- CONTENT -->
                    <div class="featured-content">

                        <!-- TITLE -->
                        <h2 class="featured-title">
                            <?= hs($show['title']) ?>
                        </h2>

                        <!-- REVIEW -->
                        <blockquote class="featured-review">
                            “<?= hs($show['featured_comment']) ?>”
                        </blockquote>

                        <!-- STARS -->
                        <div class="featured-stars">

                            <?php for ($i = 1; $i <= 5; $i++): ?>

                                <?= $i <= $show['featured_rating']
                                    ? '★'
                                    : '☆' ?>

                            <?php endfor; ?>
                        </div>

                        <!-- USER -->
                        <div class="featured-user">
                            <?= hs($show['featured_user']) ?>
                        </div>

                    </div>

                </div>

            </div>

        <?php endforeach; ?>

    </div>

    <!-- CONTROLS -->
    <button class="carousel-control-prev"
        type="button"
        data-bs-target="#topShowsCarousel"
        data-bs-slide="prev">

        <span class="carousel-control-prev-icon"></span>

    </button>

    <button class="carousel-control-next"
        type="button"
        data-bs-target="#topShowsCarousel"
        data-bs-slide="next">

        <span class="carousel-control-next-icon"></span>

    </button>

</div>
<?php
ViewHelper::loadJsScripts();
ViewHelper::loadFooter();
?>
