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
    public function getTopRatedShows(int $limit = 5): array
    {
        $sql = "
    SELECT
        s.show_id,
        s.title,
        p.poster_image,

        AVG(r.rating) AS average_rating,
        COUNT(r.review_id) AS total_reviews,

        fr.comment AS featured_comment,
        fr.rating AS featured_rating,
        u.username AS featured_user

    FROM shows s

    JOIN reviews r
        ON s.show_id = r.show_id

    LEFT JOIN posters p
        ON s.show_id = p.show_id
        AND p.is_primary = 1

    LEFT JOIN reviews fr
        ON fr.review_id = (
            SELECT r2.review_id
            FROM reviews r2
            WHERE r2.show_id = s.show_id
            ORDER BY r2.rating DESC, r2.created_at DESC
            LIMIT 1
        )

    LEFT JOIN users u
        ON fr.user_id = u.id

    GROUP BY s.show_id

    ORDER BY average_rating DESC, total_reviews DESC

    LIMIT " . (int)$limit;

        return $this->selectAll($sql);
    }
}
