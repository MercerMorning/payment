<?php
declare(strict_types=1);

namespace App\EventListener;

use App\Factory\JsonResponseFactory;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class ExceptionListener
{
    private JsonResponseFactory $jsonResponseFactory;

    /**
     * @param JsonResponseFactory $jsonResponseFactory
     */
    public function __construct(JsonResponseFactory $jsonResponseFactory)
    {
        $this->jsonResponseFactory = $jsonResponseFactory;
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        $event->setResponse($this->jsonResponseFactory->fail([
            $exception->getMessage()
        ]));
    }
}