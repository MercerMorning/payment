<?php

namespace App\Controller\Api\v1;

use App\Controller\Common\FormErrorsAdapterTrait;
use App\DTO\PurchaseDTO;
use App\Factory\CalculateCouponDiscountStrategyFactory;
use App\Factory\JsonResponseFactory;
use App\Form\PurchaseType;
use App\Service\MakePurchasePriceService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PurchaseController extends AbstractController
{
    use FormErrorsAdapterTrait;
    private FormFactoryInterface $formFactory;
    private MakePurchasePriceService $makePurchasePriceService;
    private JsonResponseFactory $jsonResponseFactory;

    /**
     * @param FormFactoryInterface $formFactory
     * @param MakePurchasePriceService $makePurchasePriceService
     * @param JsonResponseFactory $jsonResponseFactory
     */
    public function __construct(FormFactoryInterface $formFactory, MakePurchasePriceService $makePurchasePriceService, JsonResponseFactory $jsonResponseFactory)
    {
        $this->formFactory = $formFactory;
        $this->makePurchasePriceService = $makePurchasePriceService;
        $this->jsonResponseFactory = $jsonResponseFactory;
    }

    #[Route('/api/v1/purchase', name: 'app_api_v1_purchase')]
    public function index(Request $request): JsonResponse
    {
        $data = $request->request->all();
        $form = $this->formFactory->create(PurchaseType::class, new PurchaseDTO());
        $form->submit($data);
        if (!$form->isValid()) {
            return $this->jsonResponseFactory->fail($this->getErrorMessages($form));
        }
        $this->makePurchasePriceService->make($form->getData());
        return $this->jsonResponseFactory->success();
    }
}
