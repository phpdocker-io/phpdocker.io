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

namespace App\Generator\Form;

use App\Entity\Generator\MySQLOptions;
use PHPDocker\Project\ServiceOptions\MySQL;

/**
 * Form for MySQL options.
 *
 * @package App\Form\Generator
 * @author  Luis A. Pabon Flores
 */
class MySQLType extends AbstractMySQLType
{
    /**
     * @inheritdoc
     */
    protected function getDataClass(): string
    {
        return MySQLOptions::class;
    }

    /**
     * @inheritdoc
     */
    protected function getHasOptionFieldName(): string
    {
        return 'hasMysql';
    }

    /**
     * @inheritdoc
     */
    protected function getHasOptionLabel(): string
    {
        return 'Enable MySQL';
    }

    /**
     * @inheritdoc
     */
    protected function getVersionChoices(): array
    {
        return array_flip(MySQL::getChoices());
    }

    /**
     * @inheritdoc
     */
    protected function getHasOptionFunctionName(): string
    {
        return 'hasMysql';
    }

    /**
     * @inheritdoc
     */
    protected function getValidationGroup(): string
    {
        return 'mysqlOptions';
    }
}
