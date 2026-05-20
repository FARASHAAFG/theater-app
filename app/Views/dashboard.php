<?php

use App\Helpers\ViewHelper;
use App\Helpers\SessionManager;

ViewHelper::loadHeader($title ?? t('user.dashboard.title'));
$user = SessionManager::get('user', []);
?>

<div class="container mt-5" style="max-width: 800px;">
    <h1><?= hs(t('user.dashboard.title')) ?></h1>
    <div class="bg-light p-4 rounded mb-4">
        <h2><?= hs(t('home.welcome')) ?></h2>
        <p><strong><?= hs(t('user.dashboard.email')) ?>:</strong> <?= hs($user['email'] ?? SessionManager::get('user_email', '')) ?></p>
    </div>
</div>

<?php ViewHelper::loadFooter(); ?>
