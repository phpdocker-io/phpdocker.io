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

namespace App\Generator\Entity;

use PHPDocker\Interfaces\SlugifierInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Project entity and validation.
 *
 * @package App\Entity\ORM
 * @author  Luis A. Pabon Flores
 */
class Project extends \PHPDocker\Project\Project
{
    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Length(min=1, max=128)
     */
    protected $name;

    /**
     * @var int
     *
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Type(type="integer")
     * @Assert\Range(min="1025", max="65500")
     */
    protected $basePort;

    /**
     * @var MySQLOptions
     *
     * @Assert\Valid()
     */
    protected $mysqlOptions;

    /**
     * @var PhpOptions
     *
     * @Assert\Valid()
     */
    protected $phpOptions;

    /**
     * @var bool
     *
     * @Assert\Type(type="bool")
     */
    protected $hasMemcached = false;

    /**
     * @var bool
     *
     * @Assert\Type(type="bool")
     */
    protected $hasRedis = false;

    /**
     * @var bool
     *
     * @Assert\Type(type="bool")
     */
    protected $hasMailhog = false;

    public function __construct(SlugifierInterface $slugifier)
    {
        parent::__construct($slugifier);

        // Override some of the options with our own tweaked versions
        $this->mysqlOptions         = new MySQLOptions();
        $this->mariadbOptions       = new MariaDBOptions();
        $this->postgresOptions      = new PostgresOptions();
        $this->phpOptions           = new PhpOptions();
        $this->elasticsearchOptions = new ElasticsearchOptions();
    }
}
