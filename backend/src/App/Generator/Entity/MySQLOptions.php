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

use PHPDocker\Project\ServiceOptions\MySQL;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * MySQLOptions entity and validation
 *
 * @package App\Entity\ORM
 * @author  Luis A. Pabon Flores
 */
class MySQLOptions extends MySQL
{
    /**
     * @var string
     *
     * @Assert\NotBlank(groups={"mysqlOptions"})
     * @Assert\NotNull(groups={"mysqlOptions"})
     * @Assert\Length(min=1, max=128)
     */
    protected $version = self::VERSION_80;

    /**
     * @var string
     *
     * @Assert\NotBlank(groups={"mysqlOptions"})
     * @Assert\NotNull(groups={"mysqlOptions"})
     * @Assert\Length(min=1, max=128)
     */
    protected $rootPassword;

    /**
     * @var string
     *
     * @Assert\NotBlank(groups={"mysqlOptions"})
     * @Assert\NotNull(groups={"mysqlOptions"})
     * @Assert\Length(min=1, max=128)
     */
    protected $databaseName;

    /**
     * @var string
     *
     * @Assert\NotBlank(groups={"mysqlOptions"})
     * @Assert\NotNull(groups={"mysqlOptions"})
     * @Assert\Length(min=1, max=128)
     */
    protected $username;

    /**
     * @var string
     *
     * @Assert\NotBlank(groups={"mysqlOptions"})
     * @Assert\NotNull(groups={"mysqlOptions"})
     * @Assert\Length(min=1, max=128)
     */
    protected $password;

    /**
     * Redirect hasMysql to enabled.
     *
     * @param bool $hasMysql
     *
     * @return self
     */
    public function setHasMysql(bool $hasMysql = false): self
    {
        return $this->setEnabled($hasMysql);
    }

    /**
     * @return bool
     */
    public function hasMysql(): bool
    {
        return $this->isEnabled();
    }
}
