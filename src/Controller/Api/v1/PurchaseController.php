<?php
declare(strict_types=1);

namespace App\Controller\Api\v1;

use App\Controller\Common\FormErrorsAdapterTrait;
use App\DTO\PurchaseDTO;
use App\Factory\JsonResponseFactory;
use App\Form\PurchaseType;
use App\Service\MakePurchaseService;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PurchaseController extends AbstractController
{
    use FormErrorsAdapterTrait;
    private FormFactoryInterface $formFactory;
    private MakePurchaseService $makePurchasePriceService;
    private JsonResponseFactory $jsonResponseFactory;

    /**
     * @param FormFactoryInterface $formFactory
     * @param MakePurchaseService $makePurchasePriceService
     * @param JsonResponseFactory $jsonResponseFactory
     */
    public function __construct(FormFactoryInterface $formFactory, MakePurchaseService $makePurchasePriceService, JsonResponseFactory $jsonResponseFactory)
    {
        $this->formFactory = $formFactory;
        $this->makePurchasePriceService = $makePurchasePriceService;
        $this->jsonResponseFactory = $jsonResponseFactory;
    }

    /**
     * @throws \JsonException
     * @throws EntityNotFoundException
     */
    #[Route('/api/v1/purchase', name: 'app_api_v1_purchase')]
    public function index(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
        $form = $this->formFactory->create(PurchaseType::class, new PurchaseDTO());
        $form->submit($data);
        if (!$form->isValid()) {
            return $this->jsonResponseFactory->fail($this->getErrorMessages($form));
        }
        $this->makePurchasePriceService->make($form->getData());
        return $this->jsonResponseFactory->success();
    }
}
