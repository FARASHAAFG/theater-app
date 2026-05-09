<?php
//* Changed this to the admin header since only admins can add posters!
require_once __DIR__ . '/../common/adminHeader.php';
// Page with form to add new poster.

$poster = $data['poster'] ?? [];
?>
<div class="container mt-4">
    <div class="mb-4">
        <?= App\Helpers\FlashMessage::render() ?>
    </div>
    <h2>Adding Poster</h2>
    <br>

    <form method="POST" action="/theater-app/admin/add_poster/<?= (int)$poster['poster_id']; ?>">
        <label for="poster_image">Select Image:</label>
        <input type="file" name="poster_image" id="poster_image" accept="image/*" required>

        <label for="is_used">Display?</label>
        <input type="radio" name="is_used" id="is_used_yes" value="Yes">
        <input type="radio" name="is_used" id="is_used_no" value="No">
        <button type="submit">Add Poster</button>
    </form>

    <?
    $file = $_FILES['poster_image'];

    if ($file['error'] === UPLOAD_ERR_OK) {
        // File path change code from frostybee website
        $originalName = basename($file['name']);
        $safeName = preg_replace('/[^a-zA-Z0-9._-]/', '_', $originalName);
        $finalName = uniqid() . '_' . $safeName;

        move_uploaded_file($file['tmp_name'], "../../public/data/images/" . $finalName);
    }
    ?>
</div>
<?
require_once __DIR__ . '/../common/footer.php';
