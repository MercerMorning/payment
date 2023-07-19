<?php
declare(strict_types=1);

namespace App\Factory;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class JsonResponseFactory
{
    public function success(array $data = []) :JsonResponse
    {
        return new JsonResponse(['message' => 'ok', 'data' => $data],Response::HTTP_CREATED);
    }

    public function fail(array $errors) :JsonResponse
    {
        return new JsonResponse(['message' => 'fail', 'errors' => $errors],Response::HTTP_BAD_REQUEST);
    }

}