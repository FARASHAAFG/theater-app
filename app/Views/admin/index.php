<?php
//! Has header required but then has a header below?
require_once __DIR__ . '/../common/header.php';
$posters = $data;


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Posters</title>

</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Navbar</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Link</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Dropdown
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Action</a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" aria-disabled="true">Disabled</a>
                    </li>
                </ul>
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" />
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
                <a class="btn btn-success btn-s ms-3" href="/theater-app/add_show">
                    Add Show
                </a>
            </div>
        </div>
    </nav>

    <h1 class="modal-header">All Posters </h1>


    <?php ?>
    <div class="gallery">
        <?php foreach ($posters as $poster): ?>

            <div class="card" style="width: 18rem;">
                <img src="<?= $poster['poster_image'] ?>" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title"><?= $poster['title']; ?></h5>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">An item</li>
                    <li class="list-group-item">A second item</li>
                    <li class="list-group-item">A third item</li>
                </ul>
                <div class="card-body">
                    <a href="/theater-app/detail/<?= (int)$poster['poster_id']; ?>" class="btn btn-primary btn-s">Details</a>

                    <a href="/theater-app/update_show/<?= (int)$poster['poster_id']; ?>" class="btn btn-warning btn-s">Update</a>
                    <a href="/theater-app/show/delete/<?= (int)$poster['poster_id']; ?>" class="btn btn-danger btn-s">Delete</a>


                </div>
            </div>

        <?php endforeach; ?>
    </div>
    <?php ?>
</body>

</html>

<?php
require_once __DIR__ . '/../common/footer.php';
