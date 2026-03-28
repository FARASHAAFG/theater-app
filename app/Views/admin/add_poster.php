<?php
require_once __DIR__ . '/../common/header.php';
// Page with form to add new poster.

$poster = $data['poster'];
?>
<form method="POST" action="/theater-app/add_poster/<?= (int)$poster['poster_id']; ?>">
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

<?
require_once __DIR__ . '/../common/footer.php';
