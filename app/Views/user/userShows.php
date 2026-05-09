<?php
//! Has header required but then has a header below?

use App\Helpers\FlashMessage;

require_once __DIR__ . '/../common/header.php';


$posters = $data ?? [];




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



    <?php ?>
    <div class="gallery">
        <div class="row mt-4">
            <br>
            <?php foreach ($posters as $poster): ?>

                <div class="col-md-4 mb-4">
                    <div class="card h-100" style="width: 100%;">
                        <img src="/theater-app/uploads/images/<?= htmlspecialchars($poster['poster_image']) ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= $poster['title']; ?></h5>
                        </div>
                        <ul class="list-group list-group-flush">

                            <li class="list-group-item">Genre : <?= $poster['genre']; ?></li>
                            <li class="list-group-item">Language : <?= $poster['language']; ?></li>


                            <li class="list-group-item">Duration : <?= $poster['duration']; ?> minutes</li>


                        </ul>
                        <div class="card-body">
                            <a href="/theater-app/user/show_details/<?= (int)$poster['show_id']; ?>" class="btn btn-primary btn-lg">Details</a>
                            <a href="/theater-app/user/booking/<?= (int)$poster['show_id']; ?>" class="btn btn-success btn-lg">Ticket</a>
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
