<?php

use App\Helpers\ViewHelper;

ViewHelper::loadHeader($title ?? t('twofa.setup.title'));
?>

<div class="container mt-5" style="max-width: 500px;">
    <?= App\Helpers\FlashMessage::render() ?>
    <h1><?= hs(t('twofa.setup.title')) ?></h1>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= hs($error) ?></div>
    <?php endif; ?>

    <div class="mb-4">
        <h3><?= hs(t('twofa.setup.instructions_title')) ?></h3>
        <ol>
            <li><?= hs(t('twofa.setup.step1')) ?></li>
            <li><?= hs(t('twofa.setup.step2')) ?></li>
            <li><?= hs(t('twofa.setup.step3')) ?></li>
        </ol>
    </div>

    <div class="text-center my-4 p-4 bg-white">
        <img src="<?= $qrCodeDataUri ?? '' ?>" alt="QR Code" width="250" height="250">
    </div>

    <div class="bg-light p-3 my-4">
        <p><strong><?= hs(t('twofa.setup.manual')) ?></strong></p>
        <code style="font-size: 1.2em; letter-spacing: 2px;"><?= hs($secret ?? '') ?></code>
    </div>

    <form method="POST" action="<?= APP_BASE_URL ?>/2fa/verify-and-enable">
        <div class="mb-3">
            <label for="code" class="form-label"><?= hs(t('twofa.setup.code_label')) ?></label>
            <input type="text" id="code" name="code" class="form-control text-center"
                pattern="[0-9]{6}" maxlength="6" required autofocus
                placeholder="<?= hs(t('twofa.setup.code_placeholder')) ?>"
                style="font-size: 1.5em; letter-spacing: 5px;">
        </div>
        <button type="submit" class="btn btn-primary"><?= hs(t('twofa.setup.submit')) ?></button>
        <a href="<?= APP_BASE_URL ?>/dashboard" class="btn btn-secondary"><?= hs(t('twofa.setup.cancel')) ?></a>
    </form>
</div>

<?php ViewHelper::loadFooter(); ?>
