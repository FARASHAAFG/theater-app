<?php

require_once __DIR__ . '/../common/adminHeader.php';
$shows = $data ?? [];
?>

<div class="container mt-4">
    <h2><?= hs(t('admin.shows.all_title')) ?></h2>
    <a class="btn btn-primary btn-lg mb-3" href="<?= APP_BASE_URL ?>/admin/add_show"><?= hs(t('admin.shows.add_new')) ?></a>

    <div class="row mb-3">
        <div class="col">
            <div class="input-group">
                <input type="text" class="form-control" id="searchInput"
                    placeholder="<?= hs(t('shows.search_placeholder')) ?>"
                    aria-label="<?= hs(t('shows.search_placeholder')) ?>">
                <select class="form-select" id="typeFilter" aria-label="<?= hs(t('shows.filter_all')) ?>">
                    <option value=""><?= hs(t('shows.filter_all')) ?></option>
                    <option value="Show"><?= hs(t('shows.filter_show')) ?></option>
                    <option value="Danse"><?= hs(t('shows.filter_dance')) ?></option>
                    <option value="Théâtre"><?= hs(t('shows.filter_theater')) ?></option>
                    <option value="Concert"><?= hs(t('shows.filter_concert')) ?></option>
                </select>
            </div>
        </div>
        <div class="col-auto">
            <div id="loadingSpinner" class="spinner-border text-primary" role="status" style="display: none;">
                <span class="visually-hidden"><?= hs(t('shows.loading')) ?></span>
            </div>
        </div>
    </div>

    <table class="table table-striped table-bordered table-dark">
        <thead>
            <tr>
                <th><?= hs(t('admin.shows.col_id')) ?></th>
                <th><?= hs(t('admin.shows.col_title_en')) ?></th>
                <th><?= hs(t('admin.shows.col_title_fr')) ?></th>
                <th><?= hs(t('admin.shows.col_duration')) ?></th>
                <th><?= hs(t('admin.shows.col_genre')) ?></th>
                <th><?= hs(t('admin.shows.col_language')) ?></th>
                <th><?= hs(t('admin.shows.col_type')) ?></th>
                <th><?= hs(t('admin.shows.col_active')) ?></th>
                <th><?= hs(t('admin.shows.col_poster')) ?></th>
                <th colspan="3"><?= hs(t('admin.shows.col_actions')) ?></th>
            </tr>
        </thead>
        <tbody id="defaultShowsTableBody">
            <?php foreach ($shows as $show): ?>
                <tr>
                    <td><?= hs($show['show_id']) ?></td>
                    <td><?= hs($show['title']) ?></td>
                    <td><?= hs($show['title_fr']) ?></td>
                    <td><?= hs(t('shows.duration_minutes', ['%minutes%' => (string) $show['duration']])) ?></td>
                    <td><?= hs($show['genre']) ?></td>
                    <td><?= hs($show['language']) ?></td>
                    <td><?= hs($show['show_type']) ?></td>
                    <td><?= hs(ynn($show['is_active'])) ?></td>
                    <td>
                        <?php if ($show['poster_id']): ?>
                            <span class="badge bg-success"><i class="bi bi-star-fill"></i> <?= hs(t('admin.shows.has_poster')) ?></span>
                        <?php else: ?>
                            <span class="badge bg-danger"><i class="bi bi-star-fill"></i> <?= hs(t('admin.shows.no_poster')) ?></span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a class="btn btn-primary" href="<?= APP_BASE_URL ?>/admin/show_details/<?= (int) $show['show_id'] ?>">
                            <?= hs(t('admin.shows.view_details')) ?>
                        </a>
                    </td>
                    <td>
                        <a class="btn btn-<?= $show['poster_id'] ? 'info' : 'warning' ?>"
                            href="<?= APP_BASE_URL ?>/admin/upload/<?= (int) $show['show_id'] ?>">
                            <?= hs($show['poster_id'] ? t('admin.shows.change_poster') : t('admin.shows.add_poster')) ?>
                        </a>
                    </td>
                    <td>
                        <a href="<?= APP_BASE_URL ?>/admin/show/delete/<?= (int) $show['show_id'] ?>"
                            class="btn btn-danger btn-sm"
                            onclick="return confirm('<?= hs(t('admin.shows.confirm_delete')) ?>')">
                            <?= hs(t('common.delete')) ?>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tbody id="showsTableBody" style="display: none;"></tbody>
    </table>
</div>

<script>
    window.APP_BASE_URL = '<?= APP_BASE_URL ?>';
    window.i18n = <?= json_encode([
        'noResults' => t('shows.no_results'),
        'loadError' => t('shows.load_error'),
        'durationMinutes' => t('shows.duration_minutes'),
        'hasPoster' => t('admin.shows.has_poster'),
        'noPoster' => t('admin.shows.no_poster'),
        'viewDetails' => t('admin.shows.view_details'),
        'changePoster' => t('admin.shows.change_poster'),
        'addPoster' => t('admin.shows.add_poster'),
        'delete' => t('common.delete'),
        'confirmDelete' => t('admin.shows.confirm_delete'),
        'yes' => t('common.yes'),
        'no' => t('common.no'),
    ], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>;
</script>
<script src="<?= APP_BASE_URL ?>/public/assets/js/admin-show-search.js"></script>

<?php require_once __DIR__ . '/../common/adminFooter.php'; ?>
