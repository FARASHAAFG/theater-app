<?php

use App\Helpers\SessionManager;

require_once __DIR__ . '/../common/header.php';

$seats = $data['data']['seats'] ?? $data['seats'] ?? [];
$schedule = SessionManager::get('schedule', []);
$showTitle = SessionManager::get('showTitle', '');
$scheduleRow = $schedule[0] ?? [];
?>

<form action="<?= APP_BASE_URL ?>/user/checkout" method="POST">
    <input type="hidden" name="schedule_id" value="<?= hs((string) ($scheduleRow['showing_id'] ?? '')) ?>">
    <input type="hidden" name="show_title" value="<?= hs($showTitle) ?>">

    <?php foreach ((array) $seats as $seat): ?>
        <input type="hidden" name="seats[]" value="<?= hs((string) $seat) ?>">
        <div class="card border-primary mb-3" style="max-width: 18rem;">
            <div class="card-header"><?= hs(t('booking.ticket')) ?></div>
            <div class="card-body">
                <p class="card-text"><?= hs(t('booking.schedule_label')) ?>: <?= hs($scheduleRow['start_time'] ?? '') ?></p>
                <p class="card-text"><?= hs(t('booking.seat_id')) ?>: <?= hs((string) $seat) ?></p>
                <p class="card-text"><?= hs($showTitle) ?></p>
            </div>
        </div>
    <?php endforeach; ?>

    <div class="mb-3">
        <label class="form-label"><?= hs(t('booking.cardholder_name')) ?></label>
        <input type="text" name="card_name" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label"><?= hs(t('booking.card_number')) ?></label>
        <input type="text" name="card_number" class="form-control" maxlength="19" required>
    </div>
    <div class="mb-3">
        <label class="form-label"><?= hs(t('booking.expiry_date')) ?></label>
        <input type="month" name="expiry_date" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label"><?= hs(t('booking.cvv')) ?></label>
        <input type="text" name="cvv" class="form-control" maxlength="4" required>
    </div>

    <button type="submit" class="btn btn-success"><?= hs(t('booking.confirm')) ?></button>
    <a href="<?= APP_BASE_URL ?>/user/shows" class="btn btn-danger"><?= hs(t('booking.cancel')) ?></a>
</form>

<?php require_once __DIR__ . '/../common/footer.php'; ?>
