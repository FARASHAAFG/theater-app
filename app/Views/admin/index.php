<?php
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

                    <a href="#" class="btn btn-warning btn-s">Update</a>
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
