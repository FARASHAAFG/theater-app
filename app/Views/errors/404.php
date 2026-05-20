<?php

use App\Helpers\ViewHelper;

ViewHelper::loadHeader(t('errors.404.title'));
?>

<div style="text-align: center; padding: 50px 20px;">
    <h1 style="font-size: 72px; margin: 0; color: #e74c3c;">404</h1>
    <h2 style="margin: 20px 0;"><?= hs(t('errors.404.heading')) ?></h2>
    <p style="font-size: 18px; color: #666; margin: 20px 0;">
        <?= hs(t('errors.404.message')) ?>
    </p>
    <a href="<?= base_url('/') ?>" style="display: inline-block; margin-top: 30px; padding: 12px 30px; background-color: #3498db; color: white; text-decoration: none; border-radius: 5px; font-size: 16px;">
        <?= hs(t('errors.404.home')) ?>
    </a>
</div>

<?php
ViewHelper::loadJsScripts();
ViewHelper::loadFooter();
