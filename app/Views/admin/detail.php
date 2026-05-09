<?php
require_once __DIR__ . '/../common/adminHeader.php';

// Poster/show data
$poster = $data['poster'] ?? [];
$schedules = $data['schedules'] ?? []; // array of schedules for this poster
?>
<a class="btn btn-primary" href="/theater-app/admin/add_poster/<?= (int)$poster['poster_id']; ?>">Add Poster</a>

<a class="btn btn-primary" href="/theater-app/admin/update_show/<?= (int)$poster['poster_id']; ?>">Update Show</a>
<div class="card mb-4" style="max-width: 800px; margin: auto;">
    <img src="/theater-app/upload/images<?= htmlspecialchars($poster['poster_image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($poster['title']) ?>">

    <div class="card-body">
        <h2 class="card-title"><?= hs($poster['show_name']); ?></h2>
        <p class="card-text"><?= hs($poster['description']); ?></p>
    </div>

    <ul class="list-group list-group-flush">
        <li class="list-group-item"><strong>Duration:</strong> <?= $poster['duration']; ?> minutes</li>
        <li class="list-group-item"><strong>Genre:</strong> <?= hs($poster['genre']); ?></li>
        <li class="list-group-item"><strong>Language:</strong> <?= hs($poster['language']); ?></li>
        <li class="list-group-item"><strong>Cast:</strong> <?= hs($poster['cast']); ?></li>
        <li class="list-group-item"><strong>Show Type:</strong> <?= hs($poster['show_type']); ?></li>
        <li class="list-group-item"><strong>Active:</strong> <?= hs(ynn($poster['is_active'])); ?></li>
    </ul>
</div>

<!-- Schedules -->
<h3 class="text-center mb-3">Schedules</h3>
<div class="d-flex flex-wrap justify-content-center" style="gap: 1rem; max-width: 900px; margin:auto;">
    <?php foreach ($schedules as $schedule): ?>
        <div class="card" style="width: 200px; border-left: 4px solid #007bff;">
            <div class="card-body">
                <h6 class="card-title text-primary"><?= date('Y-m-d', strtotime($schedule['start_time'])); ?></h6>
                <p class="card-text mb-1"><strong>Start:</strong> <?= date('H:i', strtotime($schedule['start_time'])); ?></p>
                <p class="card-text mb-1"><strong>End:</strong> <?= date('H:i', strtotime($schedule['end_time'])); ?></p>
                <p class="card-text"><strong>Room:</strong> <?= htmlspecialchars($schedule['room']); ?></p>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php
require_once __DIR__ . '/../common/footer.php';
