<?php

declare(strict_types=1);

namespace App\Domain\Models;

class TrustedDeviceModel extends BaseModel
{
    public function create(int $userId, string $deviceToken, array $deviceInfo): int
    {
        $sql = "
            INSERT INTO trusted_devices (
                user_id,
                device_token,
                device_name,
                user_agent,
                ip_address,
                last_used_at,
                expires_at,
                created_at
            ) VALUES (
                :user_id,
                :device_token,
                :device_name,
                :user_agent,
                :ip_address,
                NOW(),
                :expires_at,
                NOW()
            )
        ";

        $this->execute($sql, [
            ':user_id' => $userId,
            ':device_token' => $deviceToken,
            ':device_name' => $deviceInfo['name'] ?? 'Unknown Device',
            ':user_agent' => $deviceInfo['user_agent'] ?? null,
            ':ip_address' => $deviceInfo['ip_address'] ?? null,
            ':expires_at' => $deviceInfo['expires_at'] ?? null,
        ]);

        return (int) $this->lastInsertId();
    }

    public function isValid(string $deviceToken, int $userId): bool
    {
        $sql = "
            SELECT id
            FROM trusted_devices
            WHERE device_token = :token
              AND user_id = :user_id
              AND (expires_at IS NULL OR expires_at > NOW())
            LIMIT 1
        ";

        $result = $this->selectOne($sql, [
            ':token' => $deviceToken,
            ':user_id' => $userId
        ]);

        return !empty($result);
    }

    public function updateLastUsed(string $deviceToken): bool
    {
        $sql = "
            UPDATE trusted_devices
            SET last_used_at = NOW()
            WHERE device_token = :token
        ";

        $rows = $this->execute($sql, [
            ':token' => $deviceToken
        ]);

        return (bool) $rows;
    }

    public function getAllByUserId(int $userId): array
    {
        $sql = "
            SELECT *
            FROM trusted_devices
            WHERE user_id = :user_id
              AND (expires_at IS NULL OR expires_at > NOW())
            ORDER BY last_used_at DESC
        ";

        return $this->selectAll($sql, [
            ':user_id' => $userId
        ]);
    }

    public function revoke(int $deviceId, int $userId): bool
    {
        $sql = "
            DELETE FROM trusted_devices
            WHERE id = :id
              AND user_id = :user_id
        ";

        $rows = $this->execute($sql, [
            ':id' => $deviceId,
            ':user_id' => $userId
        ]);

        return (bool) $rows;
    }

    public function revokeAll(int $userId): bool
    {
        $sql = "
            DELETE FROM trusted_devices
            WHERE user_id = :user_id
        ";

        $rows = $this->execute($sql, [
            ':user_id' => $userId
        ]);

        return (bool) $rows;
    }
}
