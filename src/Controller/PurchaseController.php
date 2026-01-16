<?php

namespace App\Controller;

use App\DTO\PriceInputDto;
use App\DTO\Request\PurchaseRequest;
use App\Service\PaymentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

final class PurchaseController extends AbstractController
{
    public function __construct(
        private readonly PaymentService $service,
    ) {
    }

    #[Route('/purchase', name: 'app_purchase', methods: ['POST'])]
    public function index(#[MapRequestPayload] PurchaseRequest $request): JsonResponse
    {
        $dto = new PriceInputDto(
            productId: is_numeric($request->price->product) ? (int) $request->price->product : null,
            taxNumber: $request->price->taxNumber,
            couponCode: $request->price->couponCode,
        );

        $this->service->processPayment($request->getPaymentProcessorAsEnum(), $dto);
        return $this->json(['message' => 'Purchase successful'], Response::HTTP_OK);
    }
}
