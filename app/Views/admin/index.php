<?php

require_once __DIR__ . '/../common/adminHeader.php';

$posters = $data ?? [];
?>

<?= App\Helpers\FlashMessage::render() ?>

<div class="container mt-4">
    <h2><?= hs(t('admin.posters.all_title')) ?></h2>
    <a class="btn btn-primary btn-lg mb-3" href="<?= APP_BASE_URL ?>/admin/shows"><?= hs(t('admin.shows.all_title')) ?></a>

    <table class="table table-striped table-bordered table-dark">
        <thead>
            <tr>
                <th><?= hs(t('admin.shows.col_id')) ?></th>
                <th><?= hs(t('admin.shows.col_title_en')) ?></th>
                <th><?= hs(t('admin.shows.col_title_fr')) ?></th>
                <th><?= hs(t('admin.shows.col_poster')) ?></th>
                <th colspan="3"><?= hs(t('admin.shows.col_actions')) ?></th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($posters)): ?>
                <tr>
                    <td colspan="7" class="text-center text-muted"><?= hs(t('common.none')) ?></td>
                </tr>
            <?php else: ?>
                <?php foreach ($posters as $poster): ?>
                    <?php
                    $showId = (int) ($poster['show_id'] ?? 0);
                    $posterId = (int) ($poster['poster_id'] ?? 0);
                    $hasPoster = $posterId > 0 && !empty($poster['poster_image']);
                    ?>
                    <tr>
                        <td><?= $showId ?></td>
                        <td><?= hs($poster['title'] ?? '') ?></td>
                        <td><?= hs($poster['title_fr'] ?? '') ?></td>
                        <td>
                            <?php if ($hasPoster): ?>
                                <img src="<?= poster_url($poster['poster_image']) ?>" alt="" style="height: 60px; object-fit: cover;">
                            <?php else: ?>
                                <span class="badge bg-danger"><?= hs(t('admin.shows.no_poster')) ?></span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a class="btn btn-primary btn-sm" href="<?= APP_BASE_URL ?>/admin/show_details/<?= $showId ?>">
                                <?= hs(t('admin.shows.view_details')) ?>
                            </a>
                        </td>
                        <td>
                            <a class="btn btn-<?= $hasPoster ? 'info' : 'warning' ?> btn-sm"
                                href="<?= APP_BASE_URL ?>/admin/upload/<?= $showId ?>">
                                <?= hs($hasPoster ? t('admin.shows.change_poster') : t('admin.shows.add_poster')) ?>
                            </a>
                        </td>
                        <td>
                            <a href="<?= APP_BASE_URL ?>/admin/show/delete/<?= $showId ?>"
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('<?= hs(t('admin.shows.confirm_delete')) ?>')">
                                <?= hs(t('common.delete')) ?>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once __DIR__ . '/../common/adminFooter.php'; ?>
