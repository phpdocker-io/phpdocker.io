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

namespace PHPDocker\Generator;

use Michelf\MarkdownExtra;
use PHPDocker\Zip\Archiver;

/**
 * Factory for generator. If not provided, it will spawn and inject default dependencies.
 *
 * @package PHPDocker\Generator
 * @author  Luis A. Pabon Flores
 */
class Factory
{
    /**
     * Location for
     */
    const DEFAULT_TEMPLATE_LOCATION = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'Template';

    /**
     * Builds and returns a Generator. Will spawn all dependencies also, if not already supplied by consumer.
     *
     * @param Archiver          $archiver
     * @param \Twig_Environment $twig
     * @param MarkdownExtra     $markdownExtra
     *
     * @return Generator
     */
    public static function create(
        Archiver $archiver = null,
        \Twig_Environment $twig = null,
        MarkdownExtra $markdownExtra = null
    ): Generator {
        if ($archiver === null) {
            $archiver = new Archiver();
        }

        if ($twig === null) {
            $loader = new \Twig_Loader_Filesystem(self::DEFAULT_TEMPLATE_LOCATION);
            $twig   = new \Twig_Environment($loader);
        }

        if ($markdownExtra === null) {
            $markdownExtra = new MarkdownExtra();
        }

        return new Generator($archiver, $twig, $markdownExtra);
    }
}
