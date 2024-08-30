<?php

namespace App\Service;

use App\Entity\Answer;
use App\Entity\Product;
use Doctrine\Common\Collections\Collection;

final class ProductRecommendationService
{
    public function recommendProducts(Collection $answers): array
    {
        $answerIds = array_map(
            fn(Answer $answer) => $answer->getId(),
            $answers->toArray()
        );

        if (array_intersect($answerIds, Answer::EXCLUDE_ALL_PRODUCTS_ANSWER_IDS)) {
            return [];
        }

        /** @var Answer $answer */
        foreach ($answers as $answer) {
            return match ($answer->getId()) {
                6 => [Product::SILDENAFIL_50, Product::TADALAFIL_10], // Related to question no. 2
                19 => [Product::SILDENAFIL_50],
                20, 24 => [Product::TADALAFIL_20],
                21 => [Product::TADALAFIL_10],
                22, 23 => [Product::SILDENAFIL_100],
                25 => [Product::SILDENAFIL_100, Product::TADALAFIL_20],
                default => [],
            };
        }

        return [];
    }
}
