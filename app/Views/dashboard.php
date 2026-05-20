<?php

use App\Helpers\ViewHelper;
use App\Helpers\SessionManager;

ViewHelper::loadHeader($title ?? 'Dashboard');
?>

<div class="container mt-5" style="max-width: 800px;">
    <h1>Dashboard</h1>

    <div class="bg-light p-4 rounded mb-4">
        <h2>Welcome, <?= hs(SessionManager::get('user_first_name', 'User')) ?>!</h2>
        <p>Email: <?= hs(SessionManager::get('user_email', '')) ?></p>
    </div>

    <hr>

    

<?php ViewHelper::loadFooter(); ?>
