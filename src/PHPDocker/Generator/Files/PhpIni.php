<?php
declare(strict_types=1);
/*
 * Copyright 2021 Luis Alberto Pabón Flores
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

namespace App\PHPDocker\Generator\Files;

use App\PHPDocker\Interfaces\ProjectFileInterface;
use App\PHPDocker\Project\Project;
use Twig\Environment;

class PhpIni implements ProjectFileInterface
{
    public function __construct(private Environment $twig, private Project $project)
    {

    }

    public function getContents(): string
    {
        $data = ['maxUploadSize' => $this->project->getApplicationOptions()->getUploadSize()];

        return $this->twig->render('php-ini-overrides.ini.twig', $data);
    }

    public function getFilename(): string
    {
        return 'php-fpm' . DIRECTORY_SEPARATOR . 'php-ini-overrides.ini';
    }
}