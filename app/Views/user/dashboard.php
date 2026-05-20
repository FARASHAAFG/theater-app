<?php

use App\Helpers\SessionManager;
use App\Helpers\ViewHelper;

ViewHelper::loadHeader($title ?? t('user.dashboard.title'));
$user = SessionManager::get('user', []);
$has2FA = $twoFactorEnabled ?? false;
$stats = $bookingStats ?? ['booking_count' => 0, 'ticket_count' => 0, 'total_spent' => 0.0];
$recentBookings = $recentBookings ?? [];
?>
<?= App\Helpers\FlashMessage::render() ?>

<h1><?= hs(t('user.dashboard.title')) ?></h1>
<p class="text-muted"><?= hs(t('user.dashboard.welcome', ['%name%' => $user['full_name'] ?? t('user.guest')])) ?></p>

<div class="row mb-4">
    <div class="col-md-4 mb-3">
        <div class="card border-primary h-100">
            <div class="card-body text-center">
                <h6 class="text-muted"><?= hs(t('user.dashboard.stat_bookings')) ?></h6>
                <h2 class="mb-0"><?= hs((string) ($stats['booking_count'] ?? 0)) ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card border-success h-100">
            <div class="card-body text-center">
                <h6 class="text-muted"><?= hs(t('user.dashboard.stat_tickets')) ?></h6>
                <h2 class="mb-0"><?= hs((string) ($stats['ticket_count'] ?? 0)) ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card border-warning h-100">
            <div class="card-body text-center">
                <h6 class="text-muted"><?= hs(t('user.dashboard.stat_spent')) ?></h6>
                <h2 class="mb-0">$<?= hs(number_format((float) ($stats['total_spent'] ?? 0), 2)) ?></h2>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <h5 class="card-title"><?= hs(t('user.dashboard.profile')) ?></h5>
                <p class="card-text">
                    <strong><?= hs(t('user.dashboard.name')) ?>:</strong> <?= hs($user['full_name'] ?? 'N/A') ?><br>
                    <strong><?= hs(t('user.dashboard.email')) ?>:</strong> <?= hs($user['email'] ?? 'N/A') ?><br>
                    <strong><?= hs(t('user.dashboard.role')) ?>:</strong> <?= hs($user['role'] ?? 'N/A') ?>
                </p>
            </div>
        </div>
    </div>
    <div class="col-md-8 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <h5 class="card-title"><?= hs(t('user.dashboard.quick_actions')) ?></h5>
                <div class="d-grid gap-2 d-md-flex">
                    <a href="<?= APP_BASE_URL ?>/user/shows" class="btn btn-primary"><?= hs(t('user.dashboard.browse_shows')) ?></a>
                    <a href="<?= APP_BASE_URL ?>/user/tickets" class="btn btn-outline-primary"><?= hs(t('nav.tickets')) ?></a>
                    <a href="<?= APP_BASE_URL ?>/" class="btn btn-outline-secondary"><?= hs(t('nav.home')) ?></a>
                    <a href="<?= APP_BASE_URL ?>/logout" class="btn btn-outline-danger"><?= hs(t('nav.logout')) ?></a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><?= hs(t('user.dashboard.recent_bookings')) ?></span>
        <a href="<?= APP_BASE_URL ?>/user/tickets" class="btn btn-sm btn-outline-primary"><?= hs(t('user.dashboard.view_all_tickets')) ?></a>
    </div>
    <div class="card-body p-0">
        <?php if (empty($recentBookings)): ?>
            <p class="text-muted p-3 mb-0"><?= hs(t('user.dashboard.no_bookings')) ?></p>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th><?= hs(t('admin.show.title')) ?></th>
                            <th><?= hs(t('tickets.room')) ?></th>
                            <th><?= hs(t('tickets.start')) ?></th>
                            <th><?= hs(t('admin.dashboard.seats')) ?></th>
                            <th><?= hs(t('admin.dashboard.amount')) ?></th>
                            <th><?= hs(t('tickets.status')) ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recentBookings as $booking): ?>
                            <?php
                            $status = (string) ($booking['status'] ?? '');
                            $badge = match ($status) {
                                'completed' => 'success',
                                'pending' => 'warning',
                                'cancelled' => 'danger',
                                default => 'secondary',
                            };
                            ?>
                            <tr>
                                <td><?= hs(show_title($booking)) ?></td>
                                <td><?= hs($booking['room'] ?? '') ?></td>
                                <td><?= hs((string) ($booking['start_time'] ?? '')) ?></td>
                                <td><?= hs((string) ($booking['seat_count'] ?? 0)) ?></td>
                                <td>$<?= hs(number_format((float) ($booking['total_amount'] ?? 0), 2)) ?></td>
                                <td><span class="badge bg-<?= $badge ?>"><?= hs(ucfirst($status)) ?></span></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<h3><?= hs(t('user.dashboard.security')) ?></h3>
<div class="border rounded p-4 bg-white mb-4">
    <h4><?= hs(t('user.dashboard.2fa_title')) ?></h4>
    <?php if ($has2FA): ?>
        <div class="alert alert-success"><?= hs(t('user.dashboard.2fa_enabled')) ?></div>
        <p><?= hs(t('user.dashboard.2fa_enabled_desc')) ?></p>
        <a href="<?= APP_BASE_URL ?>/2fa/disable" class="btn btn-danger"><?= hs(t('user.dashboard.2fa_disable')) ?></a>
    <?php else: ?>
        <div class="alert alert-warning"><?= hs(t('user.dashboard.2fa_disabled')) ?></div>
        <p><?= hs(t('user.dashboard.2fa_disabled_desc')) ?></p>
        <a href="<?= APP_BASE_URL ?>/2fa/setup" class="btn btn-primary"><?= hs(t('user.dashboard.2fa_enable')) ?></a>
    <?php endif; ?>
</div>

<?php ViewHelper::loadFooter(); ?>
