<?php
require_once __DIR__ . '/../common/header.php';

// Poster/show data
$show = $data['show'] ?? [];
$poster = $data['poster'] ?? null;
$schedules = $data['schedules'] ?? [];
$reviews = $data['reviews'] ?? [];
$ratingData = $data['ratingData'] ?? [];
?>



<div class="card mb-4" style="max-width: 800px; margin: auto;">
    <?php if (!empty($poster['poster_image'])): ?>
        <img src="/theater-app/uploads/images/<?= htmlspecialchars($poster['poster_image']) ?>"
            class="card-img-top"
            alt="<?= htmlspecialchars($show['title']) ?>">
    <?php else: ?>
        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 300px; border-bottom: 1px solid #ddd;">
            <span class="text-muted">No poster available</span>
        </div>
    <?php endif; ?>

    <div class="card-body">
        <p class="card-title"><strong>Show ID:</strong> <?= (int)($show['show_id']); ?></p>
        <p class="card-title"><strong>Poster ID:</strong> <?= hs($poster['poster_id'] ?? 'N/A'); ?></p>
    </div>

    <ul class="list-group list-group-flush">
        <li class="list-group-item"><strong>Title:</strong> <?= hs($show['title']); ?></li>
        <li class="list-group-item"><strong>Title (French):</strong> <?= hs($show['title_fr']); ?></li>
        <li class="list-group-item"><strong>Description:</strong> <?= hs($show['description'] ?? 'No description provided.'); ?></li>
        <li class="list-group-item"><strong>Description (French):</strong> <?= hs($show['description_fr'] ?? 'No description provided.'); ?></li>
        <li class="list-group-item"><strong>Duration:</strong> <?= (int)($show['duration'] ?? 0); ?> minutes</li>
        <li class="list-group-item"><strong>Genre:</strong> <?= hs($show['genre'] ?? 'N/A'); ?></li>
        <li class="list-group-item"><strong>Language:</strong> <?= hs($show['language'] ?? 'N/A'); ?></li>
        <li class="list-group-item"><strong>Cast:</strong> <?= hs($show['cast'] ?? 'N/A'); ?></li>
        <li class="list-group-item"><strong>Show Type:</strong> <?= hs($show['show_type'] ?? 'N/A'); ?></li>
        <li class="list-group-item"><strong>Active:</strong> <?= hs(ynn($show['is_active'] ?? 0)); ?></li>
    </ul>
</div>

<h3 class="text-center mb-3">Schedules</h3>

<?php if (empty($schedules)): ?>
    <div class="text-center text-muted mb-5">
        <p>No schedules currently assigned to this show.</p>
    </div>
<?php else: ?>
    <div class="d-flex flex-wrap justify-content-center" style="gap: 1rem; max-width: 900px; margin:auto;">
        <?php foreach ($schedules as $schedule): ?>
            <div class="card" style="width: 200px; border-left: 4px solid #007bff;">
                <div class="card-body">
                    <h6 class="card-title text-primary"><?= date('Y-m-d', strtotime($schedule['start_time'])); ?></h6>
                    <p class="card-text mb-1"><strong>Start:</strong> <?= date('H:i', strtotime($schedule['start_time'])); ?></p>
                    <p class="card-text mb-1"><strong>End:</strong> <?= date('H:i', strtotime($schedule['end_time'])); ?></p>
                    <p class="card-text"><strong>Room:</strong> <?= htmlspecialchars($schedule['room'] ?? 'TBD'); ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
<br>
<div style="max-width: 900px; margin:auto;">
    <h3 class="text-center mb-3">Customer Reviews</h3>
    <div class="text-center mb-3">


        <?php if (!empty($ratingData['average_rating'])): ?>
            <div class="text-end">
                <div class="fw-bold text-warning fs-5">
                    ★ <?= number_format($ratingData['average_rating'], 1); ?>/5
                </div>

                <small class="text-muted">
                    <?= (int)$ratingData['total_reviews']; ?> review(s)
                </small>
            </div>
        <?php endif; ?>
    </div>

    <?php if (empty($reviews)): ?>

        <div class="alert alert-light border text-center">
            No reviews available for this show yet.
        </div>

    <?php else: ?>

        <div class="d-flex flex-column gap-3">

            <?php foreach ($reviews as $review): ?>

                <div class="card shadow-sm border-0">
                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center mb-2">

                            <div>
                                <strong>
                                    <?= hs($review['username'] ?? 'Anonymous'); ?>
                                </strong>
                            </div>

                            <div class="text-warning fw-bold">
                                <?= str_repeat('★', (int)$review['rating']); ?>
                                <?= str_repeat('☆', 5 - (int)$review['rating']); ?>
                            </div>

                        </div>

                        <p class="mb-2 text-muted">
                            <?= hs($review['comment']); ?>
                        </p>

                        <small class="text-secondary">
                            <?= date('F j, Y - H:i', strtotime($review['created_at'])); ?>
                        </small>

                    </div>
                </div>

            <?php endforeach; ?>

        </div>

    <?php endif; ?>
    <br>
</div>

<?php
require_once __DIR__ . '/../common/footer.php';
