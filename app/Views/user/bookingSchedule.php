<?php

require_once __DIR__ . '/../common/header.php';

$show = $data['show'] ?? [];
$schedules = $data['schedules'] ?? [];
$price = $schedules[0]['base_price'] ?? 0;
?>

<div class="badge text-bg-primary text-wrap mb-3" style="width: auto;">
    <?= hs(t('booking.price_per_ticket')) ?>: <?= hs((string) $price) ?>
</div>

<h1><?= hs(t('booking.schedule_title')) ?></h1>

<?php if (empty($schedules)): ?>
    <p class="text-muted"><?= hs(t('admin.show.no_schedules')) ?></p>
<?php else: ?>
    <form action="<?= APP_BASE_URL ?>/user/seats" method="post">
        <select name="showing_id" class="form-select form-select-lg mb-3" required>
            <?php foreach ($schedules as $schedule): ?>
                <option value="<?= (int) $schedule['showing_id'] ?>">
                    <?= date('M d, Y', strtotime($schedule['start_time'])) ?>
                    | <?= date('H:i', strtotime($schedule['start_time'])) ?> - <?= date('H:i', strtotime($schedule['end_time'])) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit" class="btn btn-primary mt-2"><?= hs(t('booking.select_seats')) ?></button>
    </form>
<?php endif; ?>

<?php require_once __DIR__ . '/../common/footer.php'; ?>
