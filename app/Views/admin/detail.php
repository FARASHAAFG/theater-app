<?php

require_once __DIR__ . '/../common/adminHeader.php';

$poster = $poster ?? [];
$schedules = $schedules ?? [];
?>
<a class="btn btn-primary" href="<?= APP_BASE_URL ?>/admin/add_poster/<?= (int) ($poster['poster_id'] ?? 0) ?>"><?= hs(t('admin.posters.add')) ?></a>
<a class="btn btn-primary" href="<?= APP_BASE_URL ?>/admin/update_show/<?= (int) ($poster['poster_id'] ?? 0) ?>"><?= hs(t('admin.show.update_details')) ?></a>

<div class="card mb-4" style="max-width: 800px; margin: auto;">
    <?php if (!empty($poster['poster_image'])): ?>
        <img src="<?= APP_BASE_URL ?>/uploads/images/<?= htmlspecialchars($poster['poster_image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($poster['title'] ?? '') ?>">
    <?php endif; ?>
    <div class="card-body">
        <h2 class="card-title"><?= hs($poster['show_name'] ?? $poster['title'] ?? '') ?></h2>
        <p class="card-text"><?= hs($poster['description'] ?? '') ?></p>
    </div>
    <ul class="list-group list-group-flush">
        <li class="list-group-item"><strong><?= hs(t('shows.duration')) ?>:</strong> <?= hs(t('shows.duration_minutes', ['%minutes%' => (string) ($poster['duration'] ?? 0)])) ?></li>
        <li class="list-group-item"><strong><?= hs(t('shows.genre')) ?>:</strong> <?= hs($poster['genre'] ?? '') ?></li>
        <li class="list-group-item"><strong><?= hs(t('shows.language')) ?>:</strong> <?= hs($poster['language'] ?? '') ?></li>
        <li class="list-group-item"><strong><?= hs(t('admin.show.cast')) ?>:</strong> <?= hs($poster['cast'] ?? '') ?></li>
        <li class="list-group-item"><strong><?= hs(t('admin.show.show_type')) ?>:</strong> <?= hs($poster['show_type'] ?? '') ?></li>
        <li class="list-group-item"><strong><?= hs(t('admin.show.active')) ?>:</strong> <?= hs(ynn($poster['is_active'] ?? 0)) ?></li>
    </ul>
</div>

<h3 class="text-center mb-3"><?= hs(t('admin.show.schedules')) ?></h3>
<div class="d-flex flex-wrap justify-content-center" style="gap: 1rem; max-width: 900px; margin:auto;">
    <?php foreach ($schedules as $schedule): ?>
        <div class="card" style="width: 200px; border-left: 4px solid #007bff;">
            <div class="card-body">
                <h6 class="card-title text-primary"><?= date('Y-m-d', strtotime($schedule['start_time'])) ?></h6>
                <p class="card-text mb-1"><strong><?= hs(t('admin.show.schedule_start')) ?>:</strong> <?= date('H:i', strtotime($schedule['start_time'])) ?></p>
                <p class="card-text mb-1"><strong><?= hs(t('admin.show.schedule_end')) ?>:</strong> <?= date('H:i', strtotime($schedule['end_time'])) ?></p>
                <p class="card-text"><strong><?= hs(t('admin.show.schedule_room')) ?>:</strong> <?= htmlspecialchars($schedule['room'] ?? '') ?></p>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php require_once __DIR__ . '/../common/adminFooter.php'; ?>
