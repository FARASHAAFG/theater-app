<?php
require_once __DIR__ . '/../common/header.php';

// Poster/show data
$show = $data['show'] ?? [];
$poster = $data['poster'] ?? null;
$schedules = $data['schedules'] ?? [];


?>
<div class="badge text-bg-primary text-wrap" style="width: 6rem;">
    Price per ticket : <?= $schedules[0]["base_price"]; ?>
</div>
<h3 class="bg-primary-subtle">
    <h3>
        <h1>Schedule</h1>

        <form action="/theater-app/user/seats" method="post">
            <select name="showing_id" class="form-select form-select-lg mb-3" aria-label="Large select example">

                <?php foreach ($schedules as $schedule): ?>
                    <option value="<?= $schedule['showing_id'] ?>">
                        <?= date('M d, Y', strtotime($schedule['start_time'])) ?>
                        | <?= date('H:i', strtotime($schedule['start_time'])) ?> -
                        <?= date('H:i', strtotime($schedule['end_time'])) ?>

                    </option>
                <?php endforeach; ?>

            </select>

            <button type="submit" class="btn btn-primary mt-2">
                Select Seats
            </button>

        </form>
