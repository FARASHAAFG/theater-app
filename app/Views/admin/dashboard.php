<?php

require_once __DIR__ . '/../common/adminHeader.php';
$data = $data ?? [];
?>

<?= App\Helpers\FlashMessage::render() ?>

<div class="row mb-4">
    <div class="col-xl-4 col-md-6 mb-3">
        <div class="card stat-card border-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1"><?= hs(t('admin.stats.total_shows')) ?></h6>
                        <h3 class="mb-0"><?= hs((string) ($data['totalShows'] ?? 0)) ?></h3>
                    </div>
                    <div class="text-primary fs-1">&#127917;</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6 mb-3">
        <div class="card stat-card border-warning">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1"><?= hs(t('admin.stats.total_posters')) ?></h6>
                        <h3 class="mb-0"><?= hs((string) ($data['totalPosters'] ?? 0)) ?></h3>
                    </div>
                    <div class="text-warning fs-1">&#128193;</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6 mb-3">
        <div class="card stat-card border-info">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1"><?= hs(t('admin.stats.total_showings')) ?></h6>
                        <h3 class="mb-0"><?= hs((string) ($data['totalShowings'] ?? 0)) ?></h3>
                    </div>
                    <div class="text-info fs-1">&#128197;</div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if (($data['showsWithoutPoster'] ?? 0) > 0): ?>
    <div class="alert alert-warning">
        <?= hs(t('admin.dashboard.missing_posters', ['%count%' => (string) $data['showsWithoutPoster']])) ?>
        <a href="<?= APP_BASE_URL ?>/admin/shows" class="alert-link"><?= hs(t('admin.shows.all_title')) ?></a>
    </div>
<?php endif; ?>

<div class="row mb-4">
    <div class="col-12">
        <h5 class="mb-3"><?= hs(t('admin.dashboard.quick_links')) ?></h5>
        <div class="d-flex flex-wrap gap-2">
            <a href="<?= APP_BASE_URL ?>/admin/shows" class="btn btn-primary"><?= hs(t('admin.shows.all_title')) ?></a>
            <a href="<?= APP_BASE_URL ?>/admin/posters" class="btn btn-outline-primary"><?= hs(t('admin.posters.all_title')) ?></a>
            <a href="<?= APP_BASE_URL ?>/admin/add_show" class="btn btn-success"><?= hs(t('admin.shows.add_new')) ?></a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-header"><?= hs(t('admin.dashboard.upcoming_showings')) ?></div>
            <ul class="list-group list-group-flush">
                <?php if (empty($data['upcomingShowings'])): ?>
                    <li class="list-group-item text-muted"><?= hs(t('admin.dashboard.no_upcoming')) ?></li>
                <?php else: ?>
                    <?php foreach ($data['upcomingShowings'] as $showing): ?>
                        <li class="list-group-item">
                            <strong><?= hs(show_title($showing)) ?></strong><br>
                            <small class="text-muted">
                                <?= hs((string) ($showing['start_time'] ?? '')) ?> &middot;
                                <?= hs($showing['room'] ?? '') ?> &middot;
                                $<?= hs(number_format((float) ($showing['base_price'] ?? 0), 2)) ?>
                            </small>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../common/adminFooter.php'; ?>
