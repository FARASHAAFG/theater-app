<?php
require_once __DIR__ . '/../common/header.php';
$posters = $data ?? []; // Was giving an error so i added "?? []"


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
            <div class="col-md-3 text-center">
                <img src="<?= $poster['poster_image'] ?>" alt="Poster #<?= $poster['poster_id']  ?>" class="img-fluid rounded mx-auto d-block">
                <p>Show ID: <?= $poster['show_id'] ?></p>
            </div>
        <?php endforeach; ?>
    </div>
    <?php ?>
</body>

</html>

<?php
require_once __DIR__ . '/../common/footer.php';
