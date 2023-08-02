<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class ResourceNotDeletableException extends Exception
{
    public function __construct(string $message = '指定されたリソースは別のリソースで利用中のため削除できません')
    {
        parent::__construct($message);
    }

    public function render(Request $request): JsonResponse
    {
        return response()->json([
            'message' => $this->getMessage()
        ], Response::HTTP_CONFLICT);
    }
}
