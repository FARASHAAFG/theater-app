<?php

use App\Helpers\FlashMessage;
use App\Helpers\ViewHelper;

ViewHelper::loadHeader($page_title ?? t('auth.register.title'));
?>
<?= FlashMessage::render() ?>
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="text-center"><?= hs(t('auth.register.title')) ?></h3>
            </div>
            <div class="card-body">
                <form method="POST" action="<?= APP_BASE_URL ?>/register">
                    <div class="mb-3">
                        <label for="first_name" class="form-label"><?= hs(t('auth.register.first_name')) ?></label>
                        <input type="text" class="form-control" id="first_name" name="first_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="last_name" class="form-label"><?= hs(t('auth.register.last_name')) ?></label>
                        <input type="text" class="form-control" id="last_name" name="last_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label"><?= hs(t('auth.register.username')) ?></label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label"><?= hs(t('auth.register.email')) ?></label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label"><?= hs(t('auth.register.password')) ?></label>
                        <input type="password" class="form-control" id="password" name="password" required>
                        <div class="form-text"><?= hs(t('auth.register.password_hint')) ?></div>
                    </div>
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label"><?= hs(t('auth.register.confirm_password')) ?></label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary"><?= hs(t('auth.register.submit')) ?></button>
                    </div>
                </form>
                <div class="mt-3 text-center">
                    <p><?= hs(t('auth.register.has_account')) ?>
                        <a href="<?= APP_BASE_URL ?>/login"><?= hs(t('auth.register.login_link')) ?></a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php ViewHelper::loadFooter(); ?>
