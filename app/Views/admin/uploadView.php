<?php

use App\Helpers\ViewHelper;

require_once __DIR__ . '/../common/adminHeader.php';

$id = (int) $id;

var_dump($poster);



?>


<div class="card mb-4" style="max-width: 800px; margin: auto;">
    <img src="/theater-app/uploads/images/<?= htmlspecialchars($poster['poster_image']) ?>">
</div>




<div class="card mb-4">
    <div class="card-header">
        <h5>Upload an Image</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="<?= APP_BASE_URL ?>/admin/upload/<?= $id ?>" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="myfile" class="form-label">Choose a file:</label>
                <input
                    type="file"
                    class="form-control"
                    id="myfile"
                    name="myfile"
                    accept="image/*"
                    required>
                <div class="form-text">
                    Select an image file to upload (JPEG, PNG, GIF).
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Upload File</button>
        </form>
    </div>
</div>

<!-- Uploaded Files Display -->
<?php
$uploadedFiles = App\Helpers\SessionManager::get('uploaded_files', []);
?>
<?php if (!empty($uploadedFiles)): ?>
    <div class="card mt-4">
        <div class="card-header">
            <h5>Uploaded Files</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <?php foreach (array_reverse($uploadedFiles) as $filename): ?>
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <img
                                src="<?= APP_BASE_URL ?>/public/uploads/images/<?= hs($filename) ?>"
                                class="card-img-top"
                                alt="Uploaded image"
                                style="height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <p class="card-text small text-muted">
                                    <?= hs($filename) ?>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
<?php endif; ?>
