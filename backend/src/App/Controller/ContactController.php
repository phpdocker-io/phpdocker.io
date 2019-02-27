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

namespace App\Controller;

use App\Contact\Message;
use App\Http\Error;
use App\Http\ErrorResponse;
use PHPDocker\Contact\DispatcherInterface as EmailDispatcher;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\SerializerInterface as Serializer;
use Symfony\Component\Validator\Validator\ValidatorInterface as Validator;

class ContactController
{
    /**
     * @var EmailDispatcher
     */
    private $emailDispatcher;

    /**
     * @var Serializer
     */
    private $serializer;

    /**
     * @var Validator
     */
    private $validator;

    public function __construct(EmailDispatcher $emailDispatcher, Serializer $serializer, Validator $validator)
    {
        $this->emailDispatcher = $emailDispatcher;
        $this->serializer      = $serializer;
        $this->validator       = $validator;
    }

    public function process(Request $request): JsonResponse
    {
        try {
            dump($request->getContent());
            $message    = $this->serializer->deserialize($request->getContent(), Message::class, 'json');
            $violations = $this->validator->validate($message);

            if ($violations->count() > 0) {
                return new ErrorResponse($violations, 400);
            }
        } catch (NotEncodableValueException $ex) {
            return new ErrorResponse([new Error('empty-body', 'Request body is empty')], 400);
        }

        return new JsonResponse(['success' => true]);
    }
}
