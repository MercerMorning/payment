<?php

namespace App\Controller\Api\v1;

use App\Controller\Common\ValidationErrorsAdapterTrait;
use App\DTO\PurchaseDTO;
use App\Factory\CalculateCouponDiscountStrategyFactory;
use App\Form\PurchaseType;
use App\Service\CalculatePurchasePriceService;
use App\Service\MakePurchasePriceService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PurchaseController extends AbstractController
{
    use ValidationErrorsAdapterTrait;
    private FormFactoryInterface $formFactory;
    private MakePurchasePriceService $makePurchasePriceService;

    private CalculateCouponDiscountStrategyFactory $factory;

    /**
     * @param FormFactoryInterface $formFactory
     * @param MakePurchasePriceService $makePurchasePriceService
     */
    public function __construct(
        FormFactoryInterface $formFactory,
        MakePurchasePriceService $makePurchasePriceService,
        CalculateCouponDiscountStrategyFactory $factory
    )
    {
        $this->formFactory = $formFactory;
        $this->makePurchasePriceService = $makePurchasePriceService;
        $this->factory = $factory;
    }


    #[Route('/api/v1/calculate-price', name: 'app_api_v1_calculate_price')]
    public function index(Request $request): JsonResponse
    {
        $data = $request->request->all();
        $form = $this->formFactory->create(PurchaseType::class, new PurchaseDTO());
        $form->submit($data);
        if (!$form->isValid()) {
            return $this->json([
                'message' => 'fail',
                'errors' => $this->getErrorMessages($form)
            ], Response::HTTP_BAD_REQUEST);
        }
        $this->makePurchasePriceService->make($form->getData());
        return $this->json([
            'message' => 'ok'
        ], Response::HTTP_CREATED);
    }
}
