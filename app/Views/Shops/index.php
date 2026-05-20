<?php

require_once __DIR__ . '/../common/header.php';
$posters = $data ?? [];
?>

<h1 class="modal-header"><?= hs(t('admin.posters.all_title')) ?></h1>

<div class="gallery row mt-4">
    <?php foreach ($posters as $poster): ?>
        <div class="col-md-3 text-center mb-4">
            <img src="<?= APP_BASE_URL ?>/uploads/images/<?= htmlspecialchars($poster['poster_image'] ?? '') ?>"
                alt="<?= hs(t('admin.posters.all_title')) ?> #<?= (int) ($poster['poster_id'] ?? 0) ?>"
                class="img-fluid rounded mx-auto d-block">
            <p><?= hs(t('admin.show.show_id')) ?>: <?= hs((string) ($poster['show_id'] ?? '')) ?></p>
        </div>
    <?php endforeach; ?>
</div>

<?php require_once __DIR__ . '/../common/footer.php'; ?>
