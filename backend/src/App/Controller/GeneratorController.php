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

use App\Generator\Entity\Project;
use PHPDocker\Util\SlugifierInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;

class GeneratorController
{
    /**
     * @var SlugifierInterface
     */
    private $slugifier;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    public function __construct(SlugifierInterface $slugifier, SerializerInterface $serializer)
    {
        $this->slugifier  = $slugifier;
        $this->serializer = $serializer;
    }

    public function getGeneratorOptions(): JsonResponse
    {
        $project = new Project($this->slugifier);
        dd($this->serializer->serialize($project, 'json'));

        return new JsonResponse($this->serializer->serialize($project, 'json'));
    }
}
