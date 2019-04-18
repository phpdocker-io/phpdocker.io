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

use Symfony\Component\Validator\Constraints as Assert;

/**
 * PostgresOptions entity and validation
 *
 * @package App\Entity\ORM
 * @author  Luis A. Pabon Flores
 */
class PostgresOptions extends \PHPDocker\Project\ServiceOptions\Postgres
{
    /**
     * @var string
     *
     * @Assert\NotBlank(groups={"postgresOptions"})
     * @Assert\NotNull(groups={"postgresOptions"})
     * @Assert\Length(min=1, max=128)
     */
    protected $version = self::VERSION_111;

    /**
     * @var string
     *
     * @Assert\NotBlank(groups={"postgresOptions"})
     * @Assert\NotNull(groups={"postgresOptions"})
     * @Assert\Length(min=1, max=128)
     */
    protected $rootUser;

    /**
     * @var string
     *
     * @Assert\NotBlank(groups={"postgresOptions"})
     * @Assert\NotNull(groups={"postgresOptions"})
     * @Assert\Length(min=1, max=128)
     */
    protected $rootPassword;

    /**
     * @var string
     *
     * @Assert\NotBlank(groups={"postgresOptions"})
     * @Assert\NotNull(groups={"postgresOptions"})
     * @Assert\Length(min=1, max=128)
     */
    protected $databaseName;

    /**
     * Redirect hasPostgres to enabled.
     *
     * @param bool $hasPostgres
     *
     * @return PostgresOptions
     */
    public function setHasPostgres(bool $hasPostgres = false): self
    {
        return $this->setEnabled($hasPostgres);
    }

    /**
     * @return bool
     */
    public function hasPostgres(): bool
    {
        return $this->isEnabled();
    }
}
