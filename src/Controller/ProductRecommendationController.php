<?php

namespace App\Controller;

use App\Entity\Response;
use App\Service\ProductRecommendationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
final class ProductRecommendationController extends AbstractController
{
    public function __construct(private readonly ProductRecommendationService $productRecommendationService) {}

    public function __invoke(Response $response): JsonResponse
    {
        return $this->json([
            $this->productRecommendationService->recommendProductsBasedOnAnswers($response->getAnswers()),
        ], SymfonyResponse::HTTP_CREATED);
    }
}
