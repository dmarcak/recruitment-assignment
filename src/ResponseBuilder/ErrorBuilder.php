<?php

namespace App\ResponseBuilder;

class ErrorBuilder
{
    /**
     * @return array{error_message: string}
     */
    public function __invoke(string $message): array
    {
        return [
            'error_message' => $message,
        ];
    }
}
