<?php
declare(strict_types=1);

namespace App\EventListener;

use App\Factory\JsonResponseFactory;
use Doctrine\ORM\EntityNotFoundException;
use InvalidArgumentException;
use JsonException;
use RuntimeException;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Throwable;

class ExceptionListener
{
    private $supportedExceptions = [
        EntityNotFoundException::class,
        InvalidArgumentException::class,
        RuntimeException::class,
        JsonException::class
    ];
    private JsonResponseFactory $jsonResponseFactory;

    /**
     * @param JsonResponseFactory $jsonResponseFactory
     */
    public function __construct(JsonResponseFactory $jsonResponseFactory)
    {
        $this->jsonResponseFactory = $jsonResponseFactory;
    }

    public function addSupportedException(Throwable $throwable): void
    {
        $this->supportedExceptions[] = $throwable;
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        foreach ($this->supportedExceptions as $supportedException) {
            if ($exception instanceof  $supportedException) {
                $event->setResponse($this->jsonResponseFactory->fail([
                    $exception->getMessage()
                ]));
            }
        }
    }
}