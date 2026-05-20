<?php

use App\Helpers\ViewHelper;

ViewHelper::loadHeader($title ?? t('twofa.verify.title'));
?>

<div class="container mt-5" style="max-width: 400px;">
    <?= App\Helpers\FlashMessage::render() ?>
    <h1><?= hs(t('twofa.verify.title')) ?></h1>
    <p><?= hs(t('twofa.verify.instructions')) ?></p>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= hs($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="<?= APP_BASE_URL ?>/2fa/verify">
        <div class="mb-3">
            <label for="code" class="form-label"><?= hs(t('twofa.verify.code_label')) ?></label>
            <input type="text" id="code" name="code" class="form-control text-center"
                pattern="[0-9]{6}" maxlength="6" required autofocus
                placeholder="000000" style="font-size: 2em; letter-spacing: 10px;">
        </div>
        <button type="submit" class="btn btn-primary w-100"><?= hs(t('twofa.verify.submit')) ?></button>
    </form>
    <div class="mt-4 text-center">
        <form method="POST" action="<?= APP_BASE_URL ?>/logout">
            <button type="submit" class="btn btn-link"><?= hs(t('twofa.verify.logout')) ?></button>
        </form>
    </div>
</div>

<?php ViewHelper::loadFooter(); ?>
