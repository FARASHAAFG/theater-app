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






    <h1 class="modal-header">All Posters </h1>


    <?php ?>
    <div class="gallery">
        <?php foreach ($posters as $poster): ?>

            <div class="card" style="width: 18rem;">
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

        <?php endforeach; ?>
    </div>
    <?php ?>
</body>

</html>

<?php

require_once __DIR__ . '/../common/footer.php';
