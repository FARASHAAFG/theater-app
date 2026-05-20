<?php

use App\Helpers\ViewHelper;

ViewHelper::loadHeader($title ?? t('twofa.disable.title'));
?>
<?= App\Helpers\FlashMessage::render() ?>
<div class="container mt-5" style="max-width: 400px;">
    <h1><?= hs(t('twofa.disable.title')) ?></h1>
    <p><?= hs(t('twofa.disable.instructions')) ?></p>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= hs($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="<?= APP_BASE_URL ?>/2fa/disable">
        <div class="mb-3">
            <label for="password" class="form-label"><?= hs(t('twofa.disable.password')) ?></label>
            <input type="password" id="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-danger"><?= hs(t('twofa.disable.submit')) ?></button>
        <a href="<?= APP_BASE_URL ?>/dashboard" class="btn btn-secondary"><?= hs(t('common.cancel')) ?></a>
    </form>
</div>

<?php ViewHelper::loadFooter(); ?>
