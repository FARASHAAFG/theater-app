<?php

namespace App\Views\admin;

require_once __DIR__ . '/../common/adminHeader.php';
echo $_SERVER['DOCUMENT_ROOT'];




$shows = $data ?? [];

//dd($shows);

?>

<button type="button" class="btn btn-primary">Primary</button>


<div class="container mt-4">
    <h2>All Shows</h2>
    <a class="btn btn-primary btn-lg mb-3" href="<?= APP_BASE_URL ?>/admin/add_show">Add New Show</a>
    <table class="table table-striped table-bordered table-dark">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title ENG</th>
                <th>Title FR</th>
                <th>Duration</th>
                <th>Genre</th>
                <th>Language</th>
                <th>Type</th>
                <th>Active</th>
                <th>Poster?</th>

                <th colspan="3">Actions</th>

            </tr>
        </thead>

        <tbody>
            <?php
            foreach ($shows as $key => $show) {

            ?>
                <tr>
                    <td><?= hs($show["show_id"]); ?></td>

                    <td>
                        <?= hs($show["title"]); ?>

                    </td>
                    <td><?= hs($show["title_fr"]); ?></td>
                    <td><?= hs($show["duration"]); ?> minutes</td>
                    <td><?= hs($show["genre"]); ?></td>
                    <td><?= hs($show["language"]); ?></td>
                    <td><?= hs($show["show_type"]); ?></td>

                    <td><?= hs(ynn($show["is_active"])); ?></td>

                    <td>
                        <?php if ($show["poster_id"]): ?>
                            <span class="badge bg-success">
                                <i class="bi bi-star-fill"></i> Has Poster
                            </span>
                        <?php else: ?>
                            <span class="badge bg-danger">
                                <i class="bi bi-star-fill"></i> No Poster
                            </span>
                        <?php endif; ?>
                    </td>

                    <td><a class="btn btn-primary"
                            href="<?= APP_BASE_URL . '/admin/show_details/' . $show['show_id'] ?>">
                            View Details
                        </a>
                    </td>

                    <td>
                        <!-- Adding and Updating poster logic NOT DONE -->
                        <!-- Takes in the show_id to the next page -->

                        <?php if ($show["poster_id"]): ?>
                            <a class="btn btn-info"
                                href="<?= APP_BASE_URL . '/admin/upload/' . $show['show_id']  ?>">
                                Change Poster
                            </a>
                        <?php else: ?>
                            <a class="btn btn-warning"
                                href="<?= APP_BASE_URL . '/admin/upload/' . $show['show_id']  ?>">
                                Add Poster
                            </a>

                        <?php endif; ?>

                    <td>

                        <a href="/theater-app/admin/show/delete/<?= (int)$show['show_id']; ?>" class="btn btn-danger btn-s" onclick="return confirm('Are you sure you want to delete this product?')">Delete</a>

                    </td>

                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>

</div>
