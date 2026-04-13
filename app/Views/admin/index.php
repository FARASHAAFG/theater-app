<?php
//! Has header required but then has a header below?

use App\Helpers\FlashMessage;

require_once __DIR__ . '/../common/adminHeader.php';


$posters = $data;


?>
<div class="mb-4">
    <?= App\Helpers\FlashMessage::render() ?>
</div>

<!DOCTYPE html>
<html lang="en">





<div class="container mt-4">
    <h2 class="modal-header">All Posters</h2>
    <br>
    <!-- Added a button to add new posters, instead of it being in the admin header -->
    <a class="btn btn-primary btn-lg" href="<?= APP_BASE_URL ?>/admin/add_poster/1">Add Poster</a>


    <?php ?>
    <div class="gallery">
        <div class="row mt-4">
            <br>
            <?php foreach ($posters as $poster): ?>

                <div class="col-md-4 mb-4">
                    <div class="card h-100" style="width: 100%;">
                        <img src="/theater-app/<?= htmlspecialchars($poster['poster_image']) ?>" class=" card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title"><?= $poster['title']; ?></h5>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">An item</li>
                            <li class="list-group-item">A second item</li>
                            <li class="list-group-item">A third item</li>
                        </ul>
                        <div class="card-body">
                            <a href="/theater-app/admin/detail/<?= (int)$poster['poster_id']; ?>" class="btn btn-primary btn-s">Details</a>

                            <a href="/theater-app/admin/update_show/<?= (int)$poster['poster_id']; ?>" class="btn btn-warning btn-s">Update</a>
                            <a href="/theater-app/admin/show/delete/<?= (int)$poster['poster_id']; ?>" class="btn btn-danger btn-s">Delete</a>


                        </div>
                    </div>
                </div>

            <?php endforeach; ?>
        </div>
    </div>
    <?php ?>
</div>
</body>

</html>

<?php

require_once __DIR__ . '/../common/footer.php';
