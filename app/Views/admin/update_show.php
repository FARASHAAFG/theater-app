<?php

require_once __DIR__ . '/../common/adminHeader.php';

$show = $data['show'] ?? [];
?>

<div class="container mt-4">
    <h3 class="mb-4"><?= hs(t('admin.form.update_show')) ?></h3>
    <form method="POST" action="<?= APP_BASE_URL ?>/admin/update_show/<?= (int) $show['show_id'] ?>">
        <div class="mb-3">
            <label class="form-label"><?= hs(t('admin.form.title_fr')) ?></label>
            <input type="text" name="title_fr" class="form-control" value="<?= hs($show['title_fr'] ?? '') ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label"><?= hs(t('admin.form.title_en')) ?></label>
            <input type="text" name="title" class="form-control" value="<?= hs($show['title'] ?? '') ?>" required>
        </div>
        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label"><?= hs(t('admin.form.duration')) ?></label>
                <input type="text" name="duration" class="form-control" value="<?= hs($show['duration'] ?? '') ?>" required>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label"><?= hs(t('admin.form.genre')) ?></label>
                <input type="text" name="genre" class="form-control" value="<?= hs($show['genre'] ?? '') ?>" required>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label"><?= hs(t('admin.form.language')) ?></label>
                <input type="text" name="language" class="form-control" value="<?= hs($show['language'] ?? '') ?>" required>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label"><?= hs(t('admin.form.cast')) ?></label>
            <input type="text" name="cast" class="form-control" value="<?= hs($show['cast'] ?? '') ?>">
        </div>
        <div class="mb-3">
            <label class="form-label"><?= hs(t('admin.form.show_type')) ?></label>
            <input type="text" name="show_type" class="form-control" value="<?= hs($show['show_type'] ?? '') ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label"><?= hs(t('admin.form.is_active')) ?></label><br>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="is_active" value="Yes" <?= ($show['is_active'] ?? '') === 'Yes' ? 'checked' : '' ?>>
                <label class="form-check-label"><?= hs(t('common.yes')) ?></label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="is_active" value="No" <?= ($show['is_active'] ?? '') === 'No' ? 'checked' : '' ?>>
                <label class="form-check-label"><?= hs(t('common.no')) ?></label>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label"><?= hs(t('admin.form.description_en')) ?></label>
            <textarea name="description" class="form-control" rows="3" required><?= hs($show['description'] ?? '') ?></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label"><?= hs(t('admin.form.description_fr')) ?></label>
            <textarea name="description_fr" class="form-control" rows="3" required><?= hs($show['description_fr'] ?? '') ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary"><?= hs(t('admin.form.update_submit')) ?></button>
    </form>
</div>

<?php require_once __DIR__ . '/../common/adminFooter.php'; ?>
