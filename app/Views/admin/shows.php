<?php

namespace App\Views\admin;

require_once __DIR__ . '/../common/adminHeader.php';

$shows = $data;

//dd($shows);

?>


<div class="container mt-4">
    <h2>All Shows</h2>
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
            </tr>
        </thead>

        <tbody>
            <?php
            foreach ($shows as $key => $show) {

            ?>
                <tr>
                    <td><?= hs($show["show_id"]); ?></td>

                    <td><?= hs($show["title"]); ?></td>
                    <td><?= hs($show["title_fr"]); ?></td>
                    <td><?= hs($show["duration"]); ?></td>
                    <td><?= hs($show["genre"]); ?></td>
                    <td><?= hs($show["language"]); ?></td>
                    <td><?= hs($show["show_type"]); ?></td>

                    <td><?= hs($show["is_active"]); ?></td>
                    <td>
                        <!-- Adding and Updating poster logic NOT DONE -->
                        <!-- Takes in the show_id to the next page -->

                        <?php if ($show["poster_id"]): ?>
                            <a class="btn btn-info"
                                href="<?= APP_BASE_URL . '/admin/add_poster/' . $show['show_id'] ?>">
                                Change Poster
                            </a>
                        <?php else: ?>
                            <a class="btn btn-primary"
                                href="<?= APP_BASE_URL . '/admin/add_poster/' . $show['show_id'] ?>">
                                Add Poster
                            </a>
                        <?php endif; ?>
                    </td>

                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>

</div>
