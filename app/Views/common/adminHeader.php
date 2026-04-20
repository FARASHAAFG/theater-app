<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Admin Panel') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <style>
        .admin-sidebar {
            min-height: 100vh;
            background-color: #212529;
        }

        .admin-sidebar .nav-link {
            color: #adb5bd;
            padding: 0.75rem 1rem;
            border-radius: 0.25rem;
            margin-bottom: 0.25rem;
        }

        .admin-sidebar .nav-link:hover,
        .admin-sidebar .nav-link.active {
            color: #fff;
            background-color: #495057;
        }

        .admin-content {
            background-color: #f8f9fa;
            min-height: 100vh;
        }

        .stat-card {
            transition: transform 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-2px);
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block admin-sidebar p-0">
                <div class="p-3">
                    <h5 class="text-white mb-0">Admin Panel</h5>
                    <small class="text-muted">E-Commerce Manager</small>
                </div>
                <hr class="text-secondary my-0">
                <ul class="nav flex-column px-2 mt-2">
                    <li class="nav-item">
                        <a class="nav-link active" href="<?= APP_BASE_URL ?>/admin">
                            Dashboard
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="<?= APP_BASE_URL ?>/admin/shows">
                            Shows
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= APP_BASE_URL ?>/admin/posters">
                            Posters
                        </a>
                    </li>
                    <!-- Not Done YET -->
                    <li class="nav-item">
                        <a class="nav-link" href="<?= APP_BASE_URL ?>/admin/categories">
                            Categories
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= APP_BASE_URL ?>/admin/transactions">
                            Transactions
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= APP_BASE_URL ?>/admin/users">
                            Users
                        </a>
                    </li>

                </ul>
                <hr class="text-secondary">
                <div class="px-2">
                    <a class="nav-link text-muted" href="<?= APP_BASE_URL ?>/">
                        &larr; Back to Store
                    </a>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 admin-content">
                <!-- Top bar -->
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2"><?= htmlspecialchars($title ?? 'Dashboard') ?></h1>
                    <div class="text-muted">
                        Logged in as: <strong><?= htmlspecialchars($username ?? 'Admin') ?></strong>
                    </div>
                </div>
