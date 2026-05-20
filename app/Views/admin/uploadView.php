<?php

require_once __DIR__ . '/../common/adminHeader.php';

$id = (int) ($id ?? 0);
$poster = $poster ?? [];
$show = $show ?? [];
?>

<?= App\Helpers\FlashMessage::render() ?>

<?php if (!empty($show['title'])): ?>
    <p class="text-muted mb-3">
        <?= hs(t('admin.show.title')) ?>: <strong><?= hs($show['title']) ?></strong>
        (<?= hs(t('admin.show.show_id')) ?>: <?= $id ?>)
    </p>
<?php endif; ?>

<?php if (!empty($poster['poster_image'])): ?>
<div class="card mb-4" style="max-width: 800px;">
    <img src="<?= poster_url($poster['poster_image']) ?>" class="card-img-top" alt="">
</div>
<?php endif; ?>

<div class="card mb-4">
    <div class="card-header"><h5><?= hs(t('admin.upload.title')) ?></h5></div>
    <div class="card-body">
        <form method="POST" action="<?= APP_BASE_URL ?>/admin/upload/<?= $id ?>" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="myfile" class="form-label"><?= hs(t('admin.upload.choose_file')) ?></label>
                <input type="file" class="form-control" id="myfile" name="myfile" accept="image/jpeg,image/png,image/gif,image/webp" required>
                <div class="form-text"><?= hs(t('admin.upload.hint')) ?></div>
            </div>
            <button type="submit" class="btn btn-primary"><?= hs(t('admin.upload.submit')) ?></button>
            <a href="<?= APP_BASE_URL ?>/admin/shows" class="btn btn-secondary ms-2"><?= hs(t('common.cancel')) ?></a>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/../common/adminFooter.php'; ?>
