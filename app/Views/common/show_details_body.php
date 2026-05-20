<?php
/** @var array $show @var array|null $poster @var array $schedules @var array $reviews @var array $ratingData @var bool $isAdmin */
$isAdmin = $isAdmin ?? false;
$show = $show ?? [];
$poster = $poster ?? null;
$schedules = $schedules ?? [];
$reviews = $reviews ?? [];
$ratingData = $ratingData ?? [];
?>
<?php if ($isAdmin): ?>
<div class="text-center mb-4">
    <a class="btn btn-primary" href="<?= APP_BASE_URL ?>/admin/add_poster/<?= (int) $show['show_id'] ?>">
        <?= hs(t('admin.show.add_edit_poster')) ?>
    </a>
    <a class="btn btn-secondary" href="<?= APP_BASE_URL ?>/admin/update_show/<?= (int) $show['show_id'] ?>">
        <?= hs(t('admin.show.update_details')) ?>
    </a>
</div>
<?php endif; ?>

<div class="card mb-4" style="max-width: 800px; margin: auto;">
    <?php if (!empty($poster['poster_image'])): ?>
        <img src="<?= poster_url($poster['poster_image']) ?>"
            class="card-img-top" alt="<?= htmlspecialchars($show['title'] ?? '') ?>">
    <?php else: ?>
        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 300px; border-bottom: 1px solid #ddd;">
            <span class="text-muted"><?= hs(t('admin.show.no_poster')) ?></span>
        </div>
    <?php endif; ?>
    <div class="card-body">
        <p class="card-title"><strong><?= hs(t('admin.show.show_id')) ?>:</strong> <?= (int) ($show['show_id'] ?? 0) ?></p>
        <p class="card-title"><strong><?= hs(t('admin.show.poster_id')) ?>:</strong> <?= hs($poster['poster_id'] ?? t('common.na')) ?></p>
    </div>
    <ul class="list-group list-group-flush">
        <li class="list-group-item"><strong><?= hs(t('admin.show.title')) ?>:</strong> <?= hs($show['title'] ?? '') ?></li>
        <li class="list-group-item"><strong><?= hs(t('admin.show.title_fr')) ?>:</strong> <?= hs($show['title_fr'] ?? '') ?></li>
        <li class="list-group-item"><strong><?= hs(t('admin.show.description')) ?>:</strong> <?= hs($show['description'] ?? t('admin.show.no_description')) ?></li>
        <li class="list-group-item"><strong><?= hs(t('admin.show.description_fr')) ?>:</strong> <?= hs($show['description_fr'] ?? t('admin.show.no_description')) ?></li>
        <li class="list-group-item"><strong><?= hs(t('shows.duration')) ?>:</strong> <?= hs(t('shows.duration_minutes', ['%minutes%' => (string) ($show['duration'] ?? 0)])) ?></li>
        <li class="list-group-item"><strong><?= hs(t('shows.genre')) ?>:</strong> <?= hs($show['genre'] ?? t('common.na')) ?></li>
        <li class="list-group-item"><strong><?= hs(t('shows.language')) ?>:</strong> <?= hs($show['language'] ?? t('common.na')) ?></li>
        <li class="list-group-item"><strong><?= hs(t('admin.show.cast')) ?>:</strong> <?= hs($show['cast'] ?? t('common.na')) ?></li>
        <li class="list-group-item"><strong><?= hs(t('admin.show.show_type')) ?>:</strong> <?= hs($show['show_type'] ?? t('common.na')) ?></li>
        <li class="list-group-item"><strong><?= hs(t('admin.show.active')) ?>:</strong> <?= hs(ynn($show['is_active'] ?? 0)) ?></li>
    </ul>
</div>

<h3 class="text-center mb-3"><?= hs(t('admin.show.schedules')) ?></h3>
<?php if (empty($schedules)): ?>
    <div class="text-center text-muted mb-5"><p><?= hs(t('admin.show.no_schedules')) ?></p></div>
<?php else: ?>
    <div class="d-flex flex-wrap justify-content-center" style="gap: 1rem; max-width: 900px; margin:auto;">
        <?php foreach ($schedules as $schedule): ?>
            <div class="card" style="width: 200px; border-left: 4px solid #007bff;">
                <div class="card-body">
                    <h6 class="card-title text-primary"><?= date('Y-m-d', strtotime($schedule['start_time'])) ?></h6>
                    <p class="card-text mb-1"><strong><?= hs(t('admin.show.schedule_start')) ?>:</strong> <?= date('H:i', strtotime($schedule['start_time'])) ?></p>
                    <p class="card-text mb-1"><strong><?= hs(t('admin.show.schedule_end')) ?>:</strong> <?= date('H:i', strtotime($schedule['end_time'])) ?></p>
                    <p class="card-text"><strong><?= hs(t('admin.show.schedule_room')) ?>:</strong> <?= htmlspecialchars($schedule['room'] ?? t('admin.show.schedule_tbd')) ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<hr class="my-5">
<div style="max-width: 900px; margin:auto;">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0"><?= hs(t('admin.show.reviews')) ?></h3>
        <?php if (!empty($ratingData['average_rating'])): ?>
            <div class="text-end">
                <div class="fw-bold text-warning fs-5">★ <?= number_format((float) $ratingData['average_rating'], 1) ?>/5</div>
                <small class="text-muted"><?= hs(t('admin.show.reviews_count', ['%count%' => (string) (int) ($ratingData['total_reviews'] ?? 0)])) ?></small>
            </div>
        <?php endif; ?>
    </div>
    <?php if (empty($reviews)): ?>
        <div class="alert alert-light border text-center"><?= hs(t('admin.show.no_reviews')) ?></div>
    <?php else: ?>
        <div class="d-flex flex-column gap-3">
            <?php foreach ($reviews as $review): ?>
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <strong><?= hs($review['username'] ?? t('admin.show.anonymous')) ?></strong>
                            <div class="text-warning fw-bold">
                                <?= str_repeat('★', (int) $review['rating']) ?>
                                <?= str_repeat('☆', 5 - (int) $review['rating']) ?>
                            </div>
                        </div>
                        <p class="mb-2 text-muted"><?= hs($review['comment']) ?></p>
                        <small class="text-secondary"><?= date('Y-m-d H:i', strtotime($review['created_at'])) ?></small>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
