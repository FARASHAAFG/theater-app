<?php

use App\Helpers\SessionManager;
use App\Helpers\ViewHelper;

ViewHelper::loadHeader($title ?? 'User Dashboard');
$user = SessionManager::get('user', []);
//dd($user);
?>
<?= App\Helpers\FlashMessage::render() ?>
<h1>User Dashboard</h1>

<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">My Profile</h5>
                <p class="card-text">
                    <strong>Name:</strong> <?= hs($user['full_name'] ?? 'N/A') ?><br>
                    <strong>Email:</strong> <?= hs($user['email'] ?? 'N/A') ?><br>
                    <strong>Role:</strong> <?= hs($user['role'] ?? 'N/A') ?>
                </p>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Quick Actions</h5>
                <div class="d-grid gap-2">
                    <a href="<?= APP_BASE_URL ?>/" class="btn btn-primary">Browse Products</a>
                    <a href="<?= APP_BASE_URL ?>/logout" class="btn btn-outline-secondary">Logout</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php ViewHelper::loadFooter(); ?>
