<?php

namespace App\Domain\Models;

use App\Helpers\Core\PDOService;

class ReviewsModel extends BaseModel
{
    public function __construct(PDOService $db_service)
    {
        parent::__construct($db_service);
    }

    public function getReviewsByShowId(int $showId): array
    {
        $sql = "
            SELECT r.*, u.username
            FROM reviews r
            JOIN users u ON r.user_id = u.id
            WHERE r.show_id = :showId
            ORDER BY r.created_at DESC
        ";

        return $this->selectAll($sql, ['showId' => $showId]);
    }

    public function addReview(
        int $userId,
        int $showId,
        int $rating,
        string $comment
    ): bool {
        $sql = "
            INSERT INTO reviews (
                user_id,
                show_id,
                rating,
                comment
            )
            VALUES (
                :user_id,
                :show_id,
                :rating,
                :comment
            )
        ";

        return $this->execute($sql, [
            'user_id' => $userId,
            'show_id' => $showId,
            'rating' => $rating,
            'comment' => $comment
        ]);
    }

    public function getAverageRating(int $showId): array|false
    {
        $sql = "
            SELECT
                AVG(rating) AS average_rating,
                COUNT(*) AS total_reviews
            FROM reviews
            WHERE show_id = :showId
        ";

        return $this->selectOne($sql, ['showId' => $showId]);
    }

    public function deleteReview(int $reviewId): bool
    {
        $sql = "
            DELETE FROM reviews
            WHERE review_id = :reviewId
        ";

        return $this->execute($sql, [
            'reviewId' => $reviewId
        ]);
    }
}
