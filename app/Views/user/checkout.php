<?php

require_once __DIR__ . '/../common/header.php';
?>

<h1><?= hs(t('booking.success')) ?></h1>
<a class="btn btn-success px-4" href="<?= APP_BASE_URL ?>/user/shows"><?= hs(t('booking.go_back')) ?></a>

<?php require_once __DIR__ . '/../common/footer.php'; ?>
