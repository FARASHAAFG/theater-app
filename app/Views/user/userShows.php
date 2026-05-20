<?php
//! Has header required but then has a header below?

use App\Helpers\FlashMessage;

require_once __DIR__ . '/../common/header.php';


$posters = $data ?? [];

?>
<div class="mb-4">
    <?= App\Helpers\FlashMessage::render() ?>
</div>

<!DOCTYPE html>
<html lang="en">





<div class="container mt-4">
    <h1 class="modal-header">Shows</h1>
    <!-- Added a button to add new posters, instead of it being in the admin header -->



    <?php ?>
    <div class="gallery">
        <!-- Implementing Search And Filtering Logic -->
        <div class="row mt-4">
            <div class="input-group">
                <input type="text" class="form-control" id="searchInput" placeholder="Search shows by name or description" aria-label="Search products">
                <select class="form-select" id="typeFilter" aria-label="Filter by type">
                    <option value="">All Categories</option>

                    <option value="Show">
                        Show
                    </option>
                    <option value="Danse">
                        Dance
                    </option>
                    <option value="Théâtre">
                        Theater
                    </option>
                    <option value="Concert">
                        Concert
                    </option>
                </select>
            </div>
            <div class="col-md-1">
                <!-- Loading Spinner -->
                <div id="loadingSpinner" class="spinner-border text-primary" role="status" style="display: none;">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
        <br>
        <!-- Search Results Container -->
        <div id="searchResults" class="row">
            <!-- Results will be dynamically inserted here by JavaScript -->
        </div>
        <!-- Search And Filtering Logic End -->
        <div class="row mt-4" id="defaultShows">
            <br>
            <?php foreach ($posters as $poster): ?>

                <div class="col-md-4 mb-4">
                    <div class="card h-100" style="width: 100%;">
                        <img src="/theater-app/uploads/images/<?= htmlspecialchars($poster['poster_image']) ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= $poster['title']; ?></h5>
                        </div>
                        <ul class="list-group list-group-flush">

                            <li class="list-group-item">Genre : <?= $poster['genre']; ?></li>
                            <li class="list-group-item">Language : <?= $poster['language']; ?></li>


                            <li class="list-group-item">Duration : <?= $poster['duration']; ?> minutes</li>


                        </ul>
                        <div class="card-body">
                            <a href="/theater-app/user/show_details/<?= (int)$poster['show_id']; ?>" class="btn btn-primary btn-lg">Details</a>
                            <a href="/theater-app/user/booking/<?= (int)$poster['show_id']; ?>" class="btn btn-success btn-lg">Ticket</a>
                        </div>
                    </div>
                </div>

            <?php endforeach; ?>
        </div>
    </div>
    <?php ?>
</div>
</body>
<!-- Pass base URL to JavaScript -->
<script>
    // Make APP_BASE_URL available to JavaScript
    window.APP_BASE_URL = '<?= APP_BASE_URL ?>';
</script>

<!-- Load JavaScript for live search -->
<script src="<?= APP_BASE_URL ?>/public/assets/js/show-search.js"></script>

</html>

<?php

require_once __DIR__ . '/../common/footer.php';
