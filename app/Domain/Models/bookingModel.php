<?php

declare(strict_types=1);


namespace App\Domain\Models;

use App\Helpers\Core\PDOService;

class bookingModel extends BaseModel
{

    public function __construct(PDOService $db_service)
    {
        parent::__construct($db_service);
    }

    /**
     * Retrieve all cafes from the database.
     * @return array List of all cafes
     */



    public function createBooking(int $userId, int $showingId, array $seat_id, array $seats, float $price): void
    {
        // 1. Create transaction
        $sql = "INSERT INTO transactions (user_id, status, created_at, updated_at)
            VALUES (:user_id, 'pending', NOW(), NOW())";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['user_id' => $userId]);
        $transactionId = $this->pdo->lastInsertId();

        // 2. Create one reservation per seat
        $sql = "INSERT INTO reservations (transaction_id, showing_id, seat_id, price)
            VALUES (:transaction_id, :showing_id, :seat_id, :price)";

        foreach ($seat_id as $seat) {
            //var_dump($seat);

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                'transaction_id' => $transactionId,
                'showing_id'     => $showingId,
                'seat_id'        => $seat,
                'price'          => $price
            ]);
        }
    }

    public function getTransactionsByUserId(int $userId): array
    {
        $sql = "SELECT * FROM transactions
                WHERE user_id = :user_id
                ORDER BY created_at DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':user_id' => $userId]);

        return $stmt->fetchAll();
    }

    /**
     * Get all transactions with their nested reservations for a given user.
     */
    public function getBookingsByUserId(int $userId): array
    {
        $sql = "SELECT
                    t.transaction_id,
                    t.user_id,
                    t.status,
                    t.created_at,
                    t.updated_at,
                    r.reservation_id,
                    r.showing_id,
                    r.seat_id,
                    r.price
                FROM transactions t
                LEFT JOIN reservations r ON r.transaction_id = t.transaction_id
                WHERE t.user_id = :user_id
                ORDER BY t.created_at DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':user_id' => $userId]);

        $rows = $stmt->fetchAll();

        // Group reservations under their parent transaction
        $transactions = [];

        foreach ($rows as $row) {
            $txId = $row['transaction_id'];

            if (!isset($transactions[$txId])) {
                $transactions[$txId] = [
                    'transaction_id' => $row['transaction_id'],
                    'user_id'        => $row['user_id'],
                    'status'         => $row['status'],
                    'created_at'     => $row['created_at'],
                    'updated_at'     => $row['updated_at'],
                    'reservations'   => [],
                ];
            }

            if ($row['reservation_id'] !== null) {
                $transactions[$txId]['reservations'][] = [
                    'reservation_id' => $row['reservation_id'],
                    'showing_id'     => $row['showing_id'],
                    'seat_id'        => $row['seat_id'],
                    'price'          => $row['price'],
                ];
            }
        }

        return array_values($transactions);
    }
    public function getFullBookingsByUserId(int $userId): array
    {
        $sql = "SELECT
                t.transaction_id,
                t.status,
                t.created_at        AS booked_at,

                sh.showing_id,
                sh.room,
                sh.start_time,
                sh.end_time,
                sh.base_price,

                r.reservation_id,
                r.price             AS price_paid,

                s.seat_id,
                s.row_label,
                s.seat_number

            FROM transactions t
            JOIN reservations r  ON r.transaction_id = t.transaction_id
            JOIN showings sh     ON sh.showing_id    = r.showing_id
            JOIN seats s         ON s.seat_id        = r.seat_id

            WHERE t.user_id = :user_id
            ORDER BY t.created_at DESC, sh.start_time ASC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':user_id' => $userId]);
        $rows = $stmt->fetchAll();

        // Group by transaction → showing → seats
        $transactions = [];

        foreach ($rows as $row) {
            $txId      = $row['transaction_id'];
            $showingId = $row['showing_id'];

            if (!isset($transactions[$txId])) {
                $transactions[$txId] = [
                    'transaction_id' => $txId,
                    'status'         => $row['status'],
                    'booked_at'      => $row['booked_at'],
                    'showings'       => [],
                ];
            }

            if (!isset($transactions[$txId]['showings'][$showingId])) {
                $transactions[$txId]['showings'][$showingId] = [
                    'showing_id' => $showingId,
                    'room'       => $row['room'],
                    'start_time' => $row['start_time'],
                    'end_time'   => $row['end_time'],
                    'base_price' => $row['base_price'],
                    'seats'      => [],
                ];
            }

            $transactions[$txId]['showings'][$showingId]['seats'][] = [
                'reservation_id' => $row['reservation_id'],
                'seat_id'        => $row['seat_id'],
                'row_label'      => $row['row_label'],
                'seat_number'    => $row['seat_number'],
                'price_paid'     => $row['price_paid'],
            ];
        }

        // Re-index nested arrays
        foreach ($transactions as &$tx) {
            $tx['showings'] = array_values($tx['showings']);
        }

        return array_values($transactions);
    }
    /**
     * Get seats by an array of seat IDs.
     * @param array $seatIds
     * @return array
     */
    public function getSeatsByIds(array $seatIds): array
    {
        if (empty($seatIds)) {
            return [];
        }

        $placeholders = implode(',', array_fill(0, count($seatIds), '?'));

        $sql = "SELECT seat_id, room_id, row_label, seat_number
            FROM seats
            WHERE seat_id IN ($placeholders)
            ORDER BY row_label, seat_number";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array_values($seatIds));

        return $stmt->fetchAll();
    }
    /**
     * @return array{booking_count: int, ticket_count: int, total_spent: float}
     */
    public function getBookingStatsByUserId(int $userId): array
    {
        $sql = "SELECT
                    COUNT(DISTINCT t.transaction_id) AS booking_count,
                    COUNT(r.reservation_id) AS ticket_count,
                    COALESCE(SUM(CASE WHEN t.status = 'completed' THEN r.price ELSE 0 END), 0) AS total_spent
                FROM transactions t
                LEFT JOIN reservations r ON r.transaction_id = t.transaction_id
                WHERE t.user_id = :user_id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':user_id' => $userId]);
        $row = $stmt->fetch() ?: [];

        return [
            'booking_count' => (int) ($row['booking_count'] ?? 0),
            'ticket_count' => (int) ($row['ticket_count'] ?? 0),
            'total_spent' => (float) ($row['total_spent'] ?? 0),
        ];
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getRecentBookingsForUser(int $userId, int $limit = 5): array
    {
        $sql = "SELECT
                    t.transaction_id,
                    t.status,
                    t.created_at AS booked_at,
                    sh.showing_id,
                    sh.room,
                    sh.start_time,
                    s.title,
                    s.title_fr,
                    COUNT(r.reservation_id) AS seat_count,
                    COALESCE(SUM(r.price), 0) AS total_amount
                FROM transactions t
                INNER JOIN reservations r ON r.transaction_id = t.transaction_id
                INNER JOIN showings sh ON sh.showing_id = r.showing_id
                INNER JOIN shows s ON s.show_id = sh.show_id
                WHERE t.user_id = :user_id
                GROUP BY t.transaction_id, t.status, t.created_at,
                         sh.showing_id, sh.room, sh.start_time, s.title, s.title_fr
                ORDER BY t.created_at DESC
                LIMIT " . (int) $limit;

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':user_id' => $userId]);

        return $stmt->fetchAll();
    }

    public function getTicketCountByUserId(int $userId): int
    {
        $sql = "SELECT COUNT(r.reservation_id) AS ticket_count
            FROM reservations r
            JOIN transactions t ON t.transaction_id = r.transaction_id
            WHERE t.user_id = :user_id
            AND t.status != 'cancelled'";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':user_id' => $userId]);

        return (int) $stmt->fetchColumn();
    }
    public function getBookedSeatIds(int $showingId): array
    {
        $sql = "SELECT r.seat_id
            FROM reservations r
            JOIN transactions t ON t.transaction_id = r.transaction_id
            WHERE r.showing_id = :showing_id
            AND t.status != 'cancelled'";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':showing_id' => $showingId]);

        return array_column($stmt->fetchAll(), 'seat_id');
    }

    /**
     * Gets all transactions from db
     * @return array
     */
    public function getAllTransactions(): array
    {
        $sql = "SELECT t.*, u.id, u.first_name, u.last_name, u.username, u.email FROM transactions t
        LEFT JOIN users u ON t.user_id = u.id";

        return $this->selectAll($sql);
    }

    public function findById(?int $bookingId): array
    {
        $sql = "SELECT * FROM reservations WHERE reservation_id = :bookingId";
        $params = [];
        $params[':bookingId'] = $bookingId;

        return $this->selectAll($sql, $params);
    }
}
