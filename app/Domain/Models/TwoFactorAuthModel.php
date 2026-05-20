<?php

declare(strict_types=1);

namespace App\Domain\Models;

class TwoFactorAuthModel extends BaseModel
{
    public function findByUserId(int $userId): ?array
    {
        $sql = 'SELECT * FROM two_factor_auth WHERE user_id = :user_id';

        $result = $this->selectOne($sql, [
            ':user_id' => $userId,
        ]);

        return $result ?: null;
    }

    public function create(int $userId, string $secret): int
    {
        $this->execute(
            'INSERT INTO two_factor_auth (user_id, secret, enabled)
             VALUES (:user_id, :secret, 0)',
            [
                ':user_id' => $userId,
                ':secret' => $secret,
            ]
        );

        return (int) $this->lastInsertId();
    }

    public function updateSecret(int $userId, string $secret): bool
    {
        $rows = $this->execute(
            'UPDATE two_factor_auth
             SET secret = :secret,
                 updated_at = :updated_at
             WHERE user_id = :user_id',
            [
                ':user_id' => $userId,
                ':secret' => $secret,
                ':updated_at' => date('Y-m-d H:i:s'),
            ]
        );

        return $rows > 0;
    }

    public function enable(int $userId): bool
    {
        $rows = $this->execute(
            'UPDATE two_factor_auth
             SET enabled = 1,
                 enabled_at = :enabled_at
             WHERE user_id = :user_id',
            [
                ':user_id' => $userId,
                ':enabled_at' => date('Y-m-d H:i:s'),
            ]
        );

        return $rows > 0;
    }

    public function disable(int $userId): bool
    {
        $rows = $this->execute(
            'UPDATE two_factor_auth
             SET enabled = 0,
                 enabled_at = NULL
             WHERE user_id = :user_id',
            [
                ':user_id' => $userId,
            ]
        );

        return $rows > 0;
    }

    public function isEnabled(int $userId): bool
    {
        $status = $this->selectOne(
            'SELECT enabled
             FROM two_factor_auth
             WHERE user_id = :user_id',
            [
                ':user_id' => $userId,
            ]
        );

        if ($status === false || !isset($status['enabled'])) {
            return false;
        }

        return (int) $status['enabled'] === 1;
    }

    public function getSecret(int $userId): ?string
    {
        $row = $this->selectOne(
            'SELECT secret
             FROM two_factor_auth
             WHERE user_id = :user_id',
            [
                ':user_id' => $userId,
            ]
        );

        if ($row === false || empty($row['secret'])) {
            return null;
        }

        return (string) $row['secret'];
    }
}
