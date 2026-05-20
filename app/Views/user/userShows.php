<?php

use App\Helpers\FlashMessage;

require_once __DIR__ . '/../common/header.php';

$posters = $data ?? [];
?>
<div class="mb-4">
    <?= FlashMessage::render() ?>
</div>

<h1 class="modal-header"><?= hs(t('shows.title')) ?></h1>

<div class="gallery">
    <div class="row mt-4">
        <div class="input-group">
            <input type="text" class="form-control" id="searchInput"
                placeholder="<?= hs(t('shows.search_placeholder')) ?>"
                aria-label="<?= hs(t('shows.search_placeholder')) ?>">
            <select class="form-select" id="typeFilter" aria-label="<?= hs(t('shows.filter_all')) ?>">
                <option value=""><?= hs(t('shows.filter_all')) ?></option>
                <option value="Show"><?= hs(t('shows.filter_show')) ?></option>
                <option value="Danse"><?= hs(t('shows.filter_dance')) ?></option>
                <option value="Théâtre"><?= hs(t('shows.filter_theater')) ?></option>
                <option value="Concert"><?= hs(t('shows.filter_concert')) ?></option>
            </select>
        </div>
        <div class="col-md-1">
            <div id="loadingSpinner" class="spinner-border text-primary" role="status" style="display: none;">
                <span class="visually-hidden"><?= hs(t('shows.loading')) ?></span>
            </div>
        </div>
    </div>
    <br>
    <div id="searchResults" class="row"></div>
    <div class="row mt-4" id="defaultShows">
        <?php foreach ($posters as $poster): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100" style="width: 100%;">
                    <img src="<?= APP_BASE_URL ?>/uploads/images/<?= htmlspecialchars($poster['poster_image']) ?>" alt="">
                    <div class="card-body">
                        <h5 class="card-title"><?= hs($poster['title']) ?></h5>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><?= hs(t('shows.genre')) ?>: <?= hs($poster['genre']) ?></li>
                        <li class="list-group-item"><?= hs(t('shows.language')) ?>: <?= hs($poster['language']) ?></li>
                        <li class="list-group-item">
                            <?= hs(t('shows.duration')) ?>:
                            <?= hs(t('shows.duration_minutes', ['%minutes%' => (string) $poster['duration']])) ?>
                        </li>
                    </ul>
                    <div class="card-body">
                        <a href="<?= APP_BASE_URL ?>/user/show_details/<?= (int) $poster['show_id'] ?>" class="btn btn-primary btn-lg">
                            <?= hs(t('shows.details')) ?>
                        </a>
                        <a href="<?= APP_BASE_URL ?>/user/booking/<?= (int) $poster['show_id'] ?>" class="btn btn-success btn-lg">
                            <?= hs(t('shows.book_ticket')) ?>
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
    window.APP_BASE_URL = '<?= APP_BASE_URL ?>';
    window.i18n = <?= json_encode([
        'noResults' => t('shows.no_results'),
        'loadError' => t('shows.load_error'),
        'genre' => t('shows.genre'),
        'language' => t('shows.language'),
        'duration' => t('shows.duration'),
        'details' => t('shows.details'),
        'bookTicket' => t('shows.book_ticket'),
    ], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>;
</script>
<script src="<?= APP_BASE_URL ?>/public/assets/js/show-search.js"></script>

<?php require_once __DIR__ . '/../common/footer.php'; ?>
