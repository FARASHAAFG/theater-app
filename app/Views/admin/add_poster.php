<?php

require_once __DIR__ . '/../common/adminHeader.php';

$showId = (int) ($show_id ?? $poster['show_id'] ?? 0);
?>

<div class="container mt-4">
    <?= App\Helpers\FlashMessage::render() ?>
    <p class="text-muted"><?= hs(t('admin.poster.adding')) ?></p>
    <a href="<?= APP_BASE_URL ?>/admin/upload/<?= $showId ?>" class="btn btn-primary">
        <?= hs(t('admin.upload.title')) ?>
    </a>
</div>

<?php require_once __DIR__ . '/../common/adminFooter.php'; ?>
