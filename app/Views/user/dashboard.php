<?php

use App\Helpers\SessionManager;
use App\Helpers\ViewHelper;

ViewHelper::loadHeader($title ?? 'User Dashboard');
$user = SessionManager::get('user', []);
$has2FA = $twoFactorEnabled ?? false;
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
                    <a href="<?= APP_BASE_URL ?>/user/shows" class="btn btn-primary">Browse Shows</a>
                    <a href="<?= APP_BASE_URL ?>/logout" class="btn btn-outline-secondary">Logout</a>
                </div>
            </div>
        </div>
    </div>
</div>
<h3>Security Settings</h3>

<div class="border rounded p-4 bg-white">
    <h4>Two-Factor Authentication (2FA)</h4>

    <?php if ($has2FA ?? false): ?>
        <div class="alert alert-success">2FA is enabled</div>
        <p>Your account is protected with two-factor authentication.</p>
        <a href="<?= APP_BASE_URL ?>/2fa/disable" class="btn btn-danger">Disable 2FA</a>
    <?php else: ?>
        <div class="alert alert-warning">2FA is disabled</div>
        <p>Enable 2FA to add an extra layer of security to your account.</p>
        <a href="<?= APP_BASE_URL ?>/2fa/setup" class="btn btn-primary">Enable 2FA</a>
    <?php endif; ?>
</div>

<hr>

<form method="POST" action="<?= APP_BASE_URL ?>/logout">
    <button type="submit" class="btn btn-secondary">Logout</button>
</form>
</div>

<?php ViewHelper::loadFooter(); ?>
