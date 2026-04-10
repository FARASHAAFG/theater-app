<?php
require_once __DIR__ . '/../common/header.php';

$poster = $data['poster'];
$schedules = $data['schedules'];
?>

<div class="container mt-4">
    <h3 class="mb-4">Update Show</h3>

    <form method="POST" action="/theater-app/admin/update_show/<?= (int)$poster['poster_id']; ?>">

        <div class="mb-3">
            <label class="form-label">French Title</label>
            <input type="text" name="title_fr" class="form-control" value="<?= $poster['title_fr'] ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">English Title</label>
            <input type="text" name="title" class="form-control" value="<?= $poster['title'] ?>" required>
        </div>

        <div class="d-flex">

            <div class="m">
                <label class="form-label">Duration</label>
                <input type="text" name="duration" class="form-control" value="<?= $poster['duration'] ?>" required>
            </div>

            <div class="m-2">
                <label class="form-label">Genre</label>
                <input type="text" name="genre" class="form-control" value="<?= $poster['genre'] ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Language</label>
                <input type="text" name="language" class="form-control" value="<?= $poster['language'] ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Cast</label>
                <input type="text" name="cast" class="form-control" value="<?= $poster['cast'] ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Show Type</label>
                <input type="text" name="show_type" class="form-control" value="<?= $poster['show_type'] ?>" required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Is Active?</label><br>

            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="is_active" value="Yes"
                    <?= $poster['is_active'] === 'Yes' ? 'checked' : '' ?>>
                <label class="form-check-label">Yes</label>
            </div>

            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="is_active" value="No"
                    <?= $poster['is_active'] === 'No' ? 'checked' : '' ?>>
                <label class="form-check-label">No</label>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">English Description</label>
            <textarea name="description" class="form-control" rows="3" required><?= $poster['description'] ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">French Description</label>
            <textarea name="description_fr" class="form-control" rows="3" required><?= $poster['description_fr'] ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update Show</button>


    </form>
</div>

<?php require_once __DIR__ . '/../common/footer.php'; ?>
