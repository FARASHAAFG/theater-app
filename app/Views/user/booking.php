<?php

use App\Helpers\SessionManager;

require_once __DIR__ . '/../common/header.php';

$seats = $data["seats"] ?? [];
var_dump($seats);

//var_dump($seats);

$scedule = SessionManager::get('schedule');
//var_dump($scedule);

$showTitle = SessionManager::get('showTitle');
//var_dump($showTitle);
$user = SessionManager::get('user');
//var_dump($user);
//echo $scedule[0]['start_time'];
//var_dump($scedule);
//SessionManager::get('showingId');
?>




<form action="<?= APP_BASE_URL ?>/user/checkout" method="POST">
    <!-- Hidden fields to pass data to controller -->
    <input type="hidden" name="schedule_id" value="<?= hs($scedule[0]['showing_id']) ?>">
    <input type="hidden" name="show_title" value="<?= hs($showTitle) ?>">

    <?php foreach ($seats as $seat): ?>
        <!-- Hidden field for each seat -->
        <input type="hidden" name="seats[]" value="<?= hs($seat) ?>">

        <!-- Display card (just for preview) -->
        <div class="card border-primary mb-3" style="max-width: 18rem;">
            <div class="card-header">Ticket</div>
            <div class="card-body">
                <p class="card-text">Schedule: <?= hs($scedule[0]['start_time']) ?></p>
                <p class="card-text">Seat_id: <?= hs($seat) ?></p>
                <p class="card-text"><?= hs($showTitle) ?></p>
            </div>
        </div>
    <?php endforeach; ?>
    <label>Cardholder Name</label><br>
    <input type="text" name="card_name" required><br><br>

    <label>Card Number</label><br>
    <input type="text" name="card_number" maxlength="19" required><br><br>

    <label>Expiry Date</label><br>
    <input type="month" name="expiry_date" required><br><br>

    <label>CVV</label><br>
    <input type="text" name="cvv" maxlength="4" required><br><br>



    <button type="submit" class="btn btn-success">Confirm Booking</button>
    <a href="<?= APP_BASE_URL ?>/seats" class="btn btn-danger">Cancel</a>
</form>
