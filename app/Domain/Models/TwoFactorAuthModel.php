<?php

declare(strict_types=1);

namespace App\Domain\Models;

class TwoFactorAuthModel extends BaseModel
{
    public function findByUserId(int $userId): ?array
    {
        // TODO: Query the two_factor_auth table to find the record
        //       for the given user.
        $sql = "SELECT * FROM two_factor_auth WHERE user_id = :user_id";

        $result = $this->selectOne($sql, [
            ':user_id' => $userId
        ]);

        return $result ?: null;
    }

    public function create(int $userId, string $secret): int
    {
        // TODO: Insert a new 2FA record with the user ID and secret.
        //       Return the ID of the created record.
        $this->execute('INSERT INTO two_factor_auth (user_id, secret)
         VALUES (:user_id, :secret)', [
            'user_id' => $userId,
            'secret' => $secret
        ]);

        $id = $this->lastInsertId();
        return (int)$id;
    }

    public function enable(int $userId): bool
    {
        // TODO: Update the record to mark 2FA as enabled and set
        //       the enabled timestamp.
        $rows = $this->execute(
            'UPDATE two_factor_auth
         SET enabled = :enabled,
             enabled_at = :enabled_at
         WHERE user_id = :user_id',
            [
                ':user_id' => $userId,
                ':enabled' => true,
                ':enabled_at' => date('Y-m-d H:i:s'),
            ]
        );

        return boolval($rows);
    }

    public function disable(int $userId): bool
    {
        // TODO: Update the record to mark 2FA as disabled.
        $rows = $this->execute(
            'UPDATE two_factor_auth
     SET enabled = :enabled
     WHERE user_id = :user_id',
            [
                ':enabled' => 0,
                ':user_id' => $userId
            ]
        );

        return boolval($rows);
    }

    public function isEnabled(int $userId): bool
    {
        // TODO: Check whether the user has 2FA enabled.
        $status = $this->selectOne(
            'SELECT enabled
             FROM two_factor_auth
             WHERE user_id = :user_id',
            [
                ':user_id' => $userId
            ]
        );

        return isset($status['enabled'])
            ? (bool) $status['enabled']
            : false;
    }

    public function getSecret(int $userId): ?string
    {
        // TODO: Return the TOTP secret for the given user.
        $secret = $this->selectOne(
            'SELECT secret
             FROM two_factor_auth
             WHERE user_id = :user_id',
            [
                ':user_id' => $userId
            ]
        );

        return $secret['secret'] ?? null;
    }
}
