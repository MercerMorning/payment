<?php
declare(strict_types=1);

namespace App\Controller\Api\v1;

use App\Controller\Common\FormErrorsAdapterTrait;
use App\DTO\PurchaseDTO;
use App\Factory\JsonResponseFactory;
use App\Form\PurchaseType;
use App\Service\CalculatePurchasePriceService;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CalculatePriceController extends AbstractController
{
    use FormErrorsAdapterTrait;
    private FormFactoryInterface $formFactory;
    private CalculatePurchasePriceService $calculatePurchaseService;
    private JsonResponseFactory $jsonResponseFactory;

    /**
     * @param FormFactoryInterface $formFactory
     * @param CalculatePurchasePriceService $calculatePurchaseService
     * @param JsonResponseFactory $jsonResponseFactory
     */
    public function __construct(FormFactoryInterface $formFactory, CalculatePurchasePriceService $calculatePurchaseService, JsonResponseFactory $jsonResponseFactory)
    {
        $this->formFactory = $formFactory;
        $this->calculatePurchaseService = $calculatePurchaseService;
        $this->jsonResponseFactory = $jsonResponseFactory;
    }


    /**
     * @throws \JsonException
     * @throws EntityNotFoundException
     */
    #[Route('/api/v1/calculate-price', name: 'app_api_v1_calculate_price')]
    public function index(Request $request)
    {
        $data = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
        $form = $this->formFactory->create(PurchaseType::class, new PurchaseDTO());
        $form->submit($data);
        if (!$form->isValid()) {
            return $this->jsonResponseFactory->fail($this->getErrorMessages($form));
        }
        $amount = $this->calculatePurchaseService->calculate($form->getData());
        return $this->jsonResponseFactory->success([
            'amount' => $amount
        ]);
    }
}
