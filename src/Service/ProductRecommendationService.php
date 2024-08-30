<?php

namespace App\Service;

use App\Entity\Answer;
use App\Entity\Product;
use Doctrine\Common\Collections\Collection;

final class ProductRecommendationService
{
    public function recommendProductsBasedOnAnswers(Collection $answers): array
    {
        /** @var Answer $answer */
        foreach ($answers as $answer) {
            if ($this->shouldAllProductsBeExcluded($answer)) {
                return [];
            }

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

    private function shouldAllProductsBeExcluded(Answer $answer): bool
    {
        if (in_array($answer->getId(), [Answer::EXCLUDE_ALL_PRODUCTS_ANSWERS_IDS])) {
            return true;
        }

        return false;
    }
}
