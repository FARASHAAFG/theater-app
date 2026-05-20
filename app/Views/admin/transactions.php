<?php

require_once __DIR__ . '/../common/adminHeader.php';

$transactions = $data ?? [];
?>

<?= App\Helpers\FlashMessage::render() ?>

<div class="container mt-4">
    <h2><?= hs("All transactions") ?></h2>

    <table class="table table-striped table-bordered table-dark">
        <thead>
            <tr>
                <th><?= hs(t('transaction_id')) ?></th>
                <th><?= hs(t('user_id')) ?></th>
                <th><?= hs(t('status')) ?></th>
                <th><?= hs(t('first_name')) ?></th>
                <th><?= hs(t('last_name')) ?></th>
                <th><?= hs(t('username')) ?></th>
                <th><?= hs(t('email')) ?></th>
                <th><?= hs(t('created_at')) ?></th>
                <th><?= hs(t('updated_at')) ?></th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($transactions)): ?>
                <tr>
                    <td colspan="7" class="text-center text-muted"><?= hs(t('common.none')) ?></td>
                </tr>
            <?php else: ?>
                <?php foreach ($transactions as $transaction): ?>
                    <?php
                    $transactionId = (int) ($transaction['transaction_id'] ?? 0);
                    $userId = (int) ($transaction['user_id'] ?? 0);
                    $transactionStatus = hs($transaction['status'] ?? "pending");
                    $userFirstName = hs($transaction['first_name'] ?? "");
                    $userLastName = hs($transaction['last_name'] ?? "");
                    $userUsername = hs($transaction['username'] ?? "");
                    $userEmail = hs($transaction['email'] ?? "");
                    $transactionCreatedAt = hs($transaction['created_at'] ?? date(0));
                    $transactionUpdatedAt = hs($transaction['updated_at'] ?? date(0));

                    ?>
                    <tr>
                        <td><?= $transactionId ?></td>
                        <td><?= $userId ?></td>
                        <td><?= $transactionStatus ?></td>
                        <td><?= $userFirstName ?></td>
                        <td><?= $userLastName ?></td>
                        <td><?= $userUsername ?></td>
                        <td><?= $userEmail ?></td>
                        <td><?= $transactionCreatedAt ?></td>
                        <td><?= $transactionUpdatedAt ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once __DIR__ . '/../common/adminFooter.php'; ?>
