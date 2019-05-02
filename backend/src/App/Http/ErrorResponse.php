<?php
/**
 * Copyright 2019 Luis Alberto Pabón Flores
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 */

namespace App\Http;

use InvalidArgumentException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\ConstraintViolationInterface;

/**
 * Represents a JSON error response.
 *
 * @package App\Http
 */
class ErrorResponse extends JsonResponse
{
    /**
     * Enforce taking a list of errors and the HTTP status code.
     *
     * @param Error[]|ConstraintViolationInterface[] $errors
     * @param int                                    $status
     * @param array                                  $headers
     */
    public function __construct(iterable $errors, int $status, array $headers = [])
    {
        $parsedErrors = [];
        foreach ($errors as $error) {
            switch (true) {
                case $error instanceof Error:
                    $parsedErrors[] = $error->toArray();
                    break;

                case $error instanceof ConstraintViolationInterface:
                    $parsedErrors[] = (new Error(
                        'validation-error',
                        $error->getMessage(),
                        $error->getPropertyPath()
                    ))->toArray();
                    break;

                default:
                    throw new InvalidArgumentException('Unsupported error type');
            }
        }

        parent::__construct(json_encode(['errors' => $parsedErrors]), $status, $headers, true);
    }
}
