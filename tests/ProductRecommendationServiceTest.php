<?php

namespace App\Tests;

use App\Entity\Answer;
use App\Entity\Product;
use App\Service\ProductRecommendationService;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use PHPUnit\Framework\TestCase;

class ProductRecommendationServiceTest extends TestCase
{
    private ProductRecommendationService $productRecommendationService;

    protected function setUp(): void
    {
        $this->productRecommendationService = new ProductRecommendationService();
    }

    private function answersDataProvider(): array
    {
        $excludedProductsAnswer = (new Answer())->setId(2);
        $excludedProductsAnswer2 = (new Answer())->setId(16);

        $multipleProductsAnswer = (new Answer())->setId(6);
        $multipleProductsAnswer2 = (new Answer())->setId(25);

        $singleProductAnswer = (new Answer())->setId(21);

        return [
            'nothing_should_be_returned' => [
                new ArrayCollection([
                    $excludedProductsAnswer, $excludedProductsAnswer2
                ]),
                [],
            ],
            'nothing_should_be_returned_2' => [
                new ArrayCollection([
                    $multipleProductsAnswer, $excludedProductsAnswer2
                ]),
                [],
            ],
            'multiple_products' => [
                new ArrayCollection([
                    $multipleProductsAnswer2, $singleProductAnswer
                ]),
                [Product::SILDENAFIL_100, Product::TADALAFIL_20],
            ],
            'single_product' => [
                new ArrayCollection([
                    $singleProductAnswer
                ]),
                [Product::TADALAFIL_10],
            ],
            'empty' => [
                new ArrayCollection([]),
                [],
            ],
        ];
    }

    /**
     * @dataProvider answersDataProvider
     */
    public function testRecommendProducts(Collection $answers, array $expected): void
    {
        $result = $this->productRecommendationService->recommendProducts($answers);

        $this->assertEquals($expected, $result);
    }
}
