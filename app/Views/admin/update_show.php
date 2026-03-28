<?php
require_once __DIR__ . '/../common/header.php';

// Poster/show data
$poster = $data['poster'];
$schedules = $data['schedules']; // array of schedules for this poster
?>

<form method="POST" action="/theater-app/update_show/<?= (int)$poster['poster_id']; ?>">
    <label for="title_fr">French Title:</label>
    <input type="text" name="title_fr" id="title_fr" value="<?= $poster['title_fr'] ?>" required>

    <label for="title">English Title:</label>
    <input type="text" name="title" id="title" value="<?= $poster['title'] ?>" required>

    <label for="duration">Duration:</label>
    <input type="text" name="duration" id="duration" value="<?= $poster['duration'] ?>" required>

    <label for="genre">Genre:</label>
    <input type="text" name="genre" id="genre" value="<?= $poster['genre'] ?>" required>

    <label for="language">Language:</label>
    <input type="text" name="language" id="language" value="<?= $poster['language'] ?>" required>

    <label for="cast">Cast:</label>
    <input type="text" name="cast" id="cast" value="<?= $poster['cast'] ?>" required>

    <label for="show_type">Show Type:</label>
    <input type="text" name="show_type" id="show_type" value="<?= $poster['show_type'] ?>" required>

    <label for="is_active">Is Active?:</label>
    <input type="radio" name="is_active" id="is_active" value="Yes">
    <input type="radio" name="is_active" id="is_active" value="No" checked>

    <label for="description">English Description:</label>
    <input type="text" name="description" id="description" value="<?= $poster['description'] ?>" required>

    <label for="description_fr">French Description:</label>
    <input type="text" name="description_fr" id="description_fr" value="<?= $poster['description_fr'] ?>" required>

    <button type="submit">Update Show</button>
</form>

<? require_once __DIR__ . '/../common/footer.php';
