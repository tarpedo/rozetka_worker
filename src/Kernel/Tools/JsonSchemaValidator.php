<?php

declare(strict_types=1);

namespace App\Kernel\Tools;

class JsonSchemaValidator
{
    private \Opis\JsonSchema\Validator $validator;

    public function __construct()
    {
        $this->validator = new \Opis\JsonSchema\Validator();
    }

    public function isValid(string $schema, array $data): array
    {
        $result = $this->validator->validate(
            json_decode(json_encode($data), false),
            $schema,
        );

        $errors = [];
        if ($result->hasError()) {
            $flatError = (new \Opis\JsonSchema\Errors\ErrorFormatter())->formatFlat($result->error());
            $errors = array_map(
                static fn(string $errorMsg) => $errorMsg,
                $flatError
            );
        }

        return $errors;
    }
}
