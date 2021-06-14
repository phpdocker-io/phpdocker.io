<?php
/**
 * Copyright 2016 Luis Alberto Pabon Flores
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
 */

namespace App\Entity\Generator;

use AppBundle\Assert as CustomAssert;
use PHPDocker\Project\ServiceOptions\Application;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Validation for Application options
 *
 * @package AppBundle\Entity\ORM
 * @author  Luis A. Pabon Flores
 */
class ApplicationOptions extends Application
{
    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @CustomAssert\ApplicationType()
     */
    protected $applicationType;

    /**
     * @var int
     *
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Type(type="integer")
     * @Assert\Range(min="2", max="2147483647")
     */
    protected $uploadSize;
}
