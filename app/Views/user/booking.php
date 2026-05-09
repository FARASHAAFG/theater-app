<?php

use App\Helpers\SessionManager;

require_once __DIR__ . '/../common/header.php';

$seats = $data["seats"] ?? [];

//var_dump($seats);

$scedule = SessionManager::get('schedule');
$showTitle = SessionManager::get('showTitle');
//echo $scedule[0]['start_time'];
//var_dump($scedule);
//SessionManager::get('showingId');
?>

<?php foreach ($seats as $seat): ?>

    <div class="card border-primary mb-3" style="max-width: 18rem;">
        <div class="card-header">Ticket</div>
        <div class="card-body">
            <h5 class="card-title"></h5>
            <p class="card-text">Schedule <?= $scedule[0]['start_time']; ?></p>
            <p class="card-text">Seat : <?= $seat ?></p>
            <p class="card-text"><?= $showTitle ?></p>


        </div>
    </div>
<?php endforeach; ?>
