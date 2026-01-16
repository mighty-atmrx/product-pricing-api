<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\PriceInputDto;
use App\DTO\Request\CalculatePriceRequest;
use App\Service\PriceCalculatorService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

final class PriceController extends AbstractController
{
    public function __construct(
        private readonly PriceCalculatorService $service
    ){
    }

    #[Route('/calculate-price', name: 'app_price', methods: ['POST'])]
    public function index(#[MapRequestPayload] CalculatePriceRequest $request): JsonResponse
    {
        $dto = new PriceInputDto(
            productId: (int) $request->price->product,
            taxNumber: $request->price->taxNumber,
            couponCode: $request->price->couponCode,
        );

        $result = $this->service->calculate($dto);
        return $this->json($result, Response::HTTP_OK);
    }
}
