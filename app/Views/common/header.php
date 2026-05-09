<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Booking System') ?></title>

    <script src="/theater-app/public/assets/js/seat.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/theater-app/public/assets/css/seatstyle.css">
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

    <!-- USER NAVBAR -->
    <nav class="navbar navbar-expand-lg user-navbar navbar-dark px-3">
        <a class="navbar-brand text-white" href="<?= APP_BASE_URL ?>/">
            <i class="bi bi-ticket-detailed"> Booking System</i>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#userNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="userNav">

            <!-- Left links -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                <li class="nav-item">
                    <a class="nav-link" href="<?= APP_BASE_URL ?>/user/shows">Home</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="<?= APP_BASE_URL ?>/booking">Bookings</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="<?= APP_BASE_URL ?>/tickets">My Tickets</a>
                </li>

            </ul>

            <!-- Right side -->
            <div class="d-flex align-items-center gap-3">

                <!-- CART / BOOKING COUNT -->
                <a href="<?= APP_BASE_URL ?>/booking" class="btn btn-outline-light position-relative">

                    <i class="bi bi-bag-fill"> Booking</i>


                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger cart-badge">
                        <?= $bookingCount ?? 0 ?>
                    </span>
                </a>

                <!-- USER INFO -->


                <!-- LOGIN / LOGOUT -->
                <?php if (!empty($userId)): ?>
                    <a href="<?= APP_BASE_URL ?>/logout" class="btn btn-sm btn-danger">Logout</a>
                <?php else: ?>
                    <a href="<?= APP_BASE_URL ?>/login" class="btn btn-sm btn-primary">Login</a>
                <?php endif; ?>

            </div>
        </div>
    </nav>

    <!-- MAIN CONTENT -->
    <div class="container mt-4">
