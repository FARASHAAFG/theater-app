<?php
require_once __DIR__ . '/../common/header.php';
?>

<form method="POST" action="/theater-app/admin/add_show">
    <label for="title_fr">French Title:</label>
    <input type="text" name="title_fr" id="title_fr">

    <label for="title">English Title:</label>
    <input type="text" name="title" id="title">

    <label for="duration">Duration:</label>
    <input type="text" name="duration" id="duration">

    <label for="genre">Genre:</label>
    <input type="text" name="genre" id="genre">

    <label for="language">Language:</label>
    <input type="text" name="language" id="language">

    <label for="cast">Cast:</label>
    <input type="text" name="cast" id="cast">

    <label for="show_type">Show Type:</label>
    <input type="text" name="show_type" id="show_type">

    <label for="is_active">Is Active?:</label>
    <input type="radio" name="is_active" id="is_active" value="Yes">
    <input type="radio" name="is_active" id="is_active" value="No" checked>

    <label for="description">English Description:</label>
    <input type="text" name="description" id="description">

    <label for="description_fr">French Description:</label>
    <input type="text" name="description_fr" id="description_fr">

    <button type="submit">Create Show</button>
</form>

<? require_once __DIR__ . '/../common/footer.php';
