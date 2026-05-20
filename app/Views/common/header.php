<?php

use App\Helpers\SessionManager;

$user = SessionManager::get('user');
$htmlLocale = locale();

?>

<!DOCTYPE html>
<html lang="<?= hs($htmlLocale) ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? t('app.tagline')) ?></title>

    <script src="<?= APP_BASE_URL ?>/public/assets/js/seat.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= APP_BASE_URL ?>/public/assets/css/seatstyle.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        .user-navbar {
            background-color: #212529;
        }

        .user-navbar .nav-link {
            color: #adb5bd;
        }

        .user-navbar .nav-link:hover {
            color: #fff;
        }

        .cart-badge {
            font-size: 0.75rem;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg user-navbar navbar-dark px-3">
        <a class="navbar-brand text-white" href="<?= APP_BASE_URL ?>/">
            <i class="bi bi-ticket-detailed"></i> <?= hs(t('app.name')) ?>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#userNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="userNav">

            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="<?= APP_BASE_URL ?>"><?= hs(t('nav.home')) ?></a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="<?= APP_BASE_URL ?>/user/shows"><?= hs(t('nav.shows')) ?></a>
                </li>
                <li class="nav-item">
                    <a href="<?= APP_BASE_URL ?>/dashboard" class="btn btn-outline-light position-relative">
                        <i class="bi bi-bag-fill"></i> <?= hs(t('user.dashboard')) ?>

                    </a>
                </li>
                <li class="nav-item d-flex align-items-center ms-2">
                    <?php require __DIR__ . '/lang-switcher.php'; ?>
                </li>

            </ul>

            <div class="d-flex align-items-center gap-3">


                <div class="d-flex align-items-center gap-3">
                    <a href="<?= APP_BASE_URL ?>/user/tickets" class="btn btn-outline-light position-relative">
                        <i class="bi bi-bag-fill"></i> <?= hs(t('nav.tickets')) ?>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger cart-badge">
                            <?= SessionManager::get('id') ?? 0 ?>
                        </span>
                    </a>



                    <?php if (!empty($user['is_authenticated'])): ?>
                        <a href="<?= APP_BASE_URL ?>/logout" class="btn btn-sm btn-danger"><?= hs(t('nav.logout')) ?></a>
                    <?php else: ?>
                        <a href="<?= APP_BASE_URL ?>/login" class="btn btn-sm btn-primary"><?= hs(t('nav.login')) ?></a>
                        <a href="<?= APP_BASE_URL ?>/register" class="btn btn-sm btn-outline-light"><?= hs(t('nav.register')) ?></a>
                    <?php endif; ?>
                </div>
            </div>
    </nav>

    <div class="container mt-4">
