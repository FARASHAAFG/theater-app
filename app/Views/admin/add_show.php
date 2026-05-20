<?php

require_once __DIR__ . '/../common/adminHeader.php';
?>
<div class="mb-4"><?= App\Helpers\FlashMessage::render() ?></div>

<div class="container mt-4">
    <h2><?= hs(t('admin.form.add_show')) ?></h2>
    <form method="POST" action="<?= APP_BASE_URL ?>/admin/add_show" class="mt-3">
        <div class="mb-3">
            <label for="title_fr" class="form-label"><?= hs(t('admin.form.title_fr')) ?></label>
            <input type="text" name="title_fr" id="title_fr" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="title" class="form-label"><?= hs(t('admin.form.title_en')) ?></label>
            <input type="text" name="title" id="title" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="duration" class="form-label"><?= hs(t('admin.form.duration')) ?></label>
            <input type="text" name="duration" id="duration" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="genre" class="form-label"><?= hs(t('admin.form.genre')) ?></label>
            <input type="text" name="genre" id="genre" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="language" class="form-label"><?= hs(t('admin.form.language')) ?></label>
            <input type="text" name="language" id="language" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="cast" class="form-label"><?= hs(t('admin.form.cast')) ?></label>
            <input type="text" name="cast" id="cast" class="form-control">
        </div>
        <div class="mb-3">
            <label for="show_type" class="form-label"><?= hs(t('admin.form.show_type')) ?></label>
            <input type="text" name="show_type" id="show_type" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label"><?= hs(t('admin.form.is_active')) ?></label><br>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="is_active" value="Yes" id="active_yes">
                <label class="form-check-label" for="active_yes"><?= hs(t('common.yes')) ?></label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="is_active" value="No" id="active_no" checked>
                <label class="form-check-label" for="active_no"><?= hs(t('common.no')) ?></label>
            </div>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label"><?= hs(t('admin.form.description_en')) ?></label>
            <textarea name="description" id="description" class="form-control" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label for="description_fr" class="form-label"><?= hs(t('admin.form.description_fr')) ?></label>
            <textarea name="description_fr" id="description_fr" class="form-control" rows="3" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary"><?= hs(t('admin.form.create_show')) ?></button>
    </form>
</div>

<?php require_once __DIR__ . '/../common/adminFooter.php'; ?>
