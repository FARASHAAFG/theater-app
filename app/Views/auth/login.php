<?php

use App\Helpers\ViewHelper;

ViewHelper::loadHeader($title ?? t('auth.login.title'));
?>
<?= App\Helpers\FlashMessage::render() ?>
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card">
            <div class="card-header">
                <h3 class="text-center"><?= hs(t('auth.login.title')) ?></h3>
            </div>
            <div class="card-body">
                <form method="POST" action="<?= APP_BASE_URL ?>/login">
                    <div class="mb-3">
                        <label for="identifier" class="form-label"><?= hs(t('auth.login.identifier')) ?></label>
                        <input
                            type="text"
                            class="form-control"
                            id="identifier"
                            name="identifier"
                            placeholder="<?= hs(t('auth.login.identifier_placeholder')) ?>"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label"><?= hs(t('auth.login.password')) ?></label>
                        <input
                            type="password"
                            class="form-control"
                            id="password"
                            name="password"
                            placeholder="<?= hs(t('auth.login.password_placeholder')) ?>"
                            required>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary"><?= hs(t('auth.login.submit')) ?></button>
                    </div>
                </form>
                <div class="mt-3 text-center">
                    <p><?= hs(t('auth.login.no_account')) ?>
                        <a href="<?= APP_BASE_URL ?>/register"><?= hs(t('auth.login.register_link')) ?></a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php ViewHelper::loadFooter(); ?>
