<?php

require_once __DIR__ . '/../common/header.php';
$tickets = $data ?? [];
?>

<div class="container mt-4">
    <?= App\Helpers\FlashMessage::render() ?>
    <?php if (empty($tickets)): ?>
        <p class="text-muted"><?= hs(t('nav.tickets')) ?> — <?= hs(t('common.none')) ?></p>
    <?php endif; ?>

    <?php foreach ($tickets as $transaction): ?>
        <?php foreach ($transaction['showings'] ?? [] as $showing): ?>
            <?php foreach ($showing['seats'] ?? [] as $seat): ?>
                <div class="card text-bg-info mb-3" style="max-width: 22rem;">
                    <div class="card-header">
                        <?= hs(t('tickets.transaction')) ?> #<?= hs((string) ($transaction['transaction_id'] ?? '')) ?>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">
                            <?= hs(t('tickets.seat')) ?> <?= hs(($seat['row_label'] ?? '') . ($seat['seat_number'] ?? '')) ?>
                        </h5>
                        <p class="card-text"><?= hs(t('tickets.room')) ?>: <?= hs($showing['room'] ?? '') ?></p>
                        <p class="card-text"><?= hs(t('tickets.start')) ?>: <?= hs($showing['start_time'] ?? '') ?></p>
                        <p class="card-text"><?= hs(t('tickets.price_paid')) ?>: $<?= hs((string) ($seat['price_paid'] ?? '')) ?></p>
                        <p class="card-text"><?= hs(t('tickets.status')) ?>: <?= hs(ucfirst((string) ($transaction['status'] ?? ''))) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endforeach; ?>
    <?php endforeach; ?>
</div>

<?php require_once __DIR__ . '/../common/footer.php'; ?>
