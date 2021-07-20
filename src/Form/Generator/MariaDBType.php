<?php
declare(strict_types=1);

/**
 * Copyright 2016 Luis Alberto Pabón Flores
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

namespace App\Form\Generator;

use App\PHPDocker\Project\ServiceOptions\MariaDB;

/**
 * Form for Mariadb options.
 */
class MariaDBType extends AbstractMySQLType
{
    /**
     * @inheritdoc
     */
    protected function getHasOptionFieldName(): string
    {
        return 'hasMariadb';
    }

    /**
     * @inheritdoc
     */
    protected function getHasOptionLabel(): string
    {
        return 'Enable MariaDB';
    }

    /**
     * @inheritdoc
     * @return array<string, string>
     */
    protected function getVersionChoices(): array
    {
        return array_flip(MariaDB::getChoices());
    }

    /**
     * @inheritdoc
     */
    protected function getHasOptionFunctionName(): string
    {
        return 'hasMariadb';
    }

    /**
     * @inheritdoc
     */
    protected function getValidationGroup(): string
    {
        return 'mariadbOptions';
    }
}
