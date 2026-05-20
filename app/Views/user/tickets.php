<?php

use App\Helpers\SessionManager;

require_once __DIR__ . '/../common/header.php';
$tickets = $data ?? [];


?>
<div class="container mt-4">

    <?php foreach ($tickets as $transaction): ?>

        <?php foreach ($transaction['showings'] as $showing): ?>

            <?php foreach ($showing['seats'] as $seat): ?>

                <div class="card text-bg-info mb-3" style="max-width: 18rem;">

                    <div class="card-header">
                        Transaction #<?= $transaction['transaction_id']; ?>
                    </div>

                    <div class="card-body">

                        <h5 class="card-title">
                            Seat <?= $seat['row_label']; ?><?= $seat['seat_number']; ?>
                        </h5>

                        <p class="card-text">
                            Room: <?= $showing['room']; ?>
                        </p>

                        <p class="card-text">
                            Start: <?= $showing['start_time']; ?>
                        </p>

                        <p class="card-text">
                            Price Paid: $<?= $seat['price_paid']; ?>
                        </p>

                        <p class="card-text">
                            Status: <?= ucfirst($transaction['status']); ?>
                        </p>

                    </div>

                </div>

            <?php endforeach; ?>

        <?php endforeach; ?>

    <?php endforeach; ?>

</div>
