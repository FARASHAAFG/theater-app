<?php
$currentLocale = locale();
?>
<div class="btn-group btn-group-sm" role="group" aria-label="<?= hs(t('nav.lang.en')) ?> / <?= hs(t('nav.lang.fr')) ?>">
    <a href="<?= APP_BASE_URL ?>/language/en"
        class="btn btn-outline-light <?= $currentLocale === 'en' ? 'active' : '' ?>"
        title="<?= hs(t('nav.lang.en')) ?>">EN</a>
    <a href="<?= APP_BASE_URL ?>/language/fr"
        class="btn btn-outline-light <?= $currentLocale === 'fr' ? 'active' : '' ?>"
        title="<?= hs(t('nav.lang.fr')) ?>">FR</a>
</div>
