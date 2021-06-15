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

namespace App\Services;

/**
 * Custom twig extensions
 */
class TwigCustomExtensions extends \Twig_Extension
{
    /**
     * @inheritdoc
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('unescape', [$this, 'unescape']),
        ];
    }

    /**
     * Unescape filter removes HTML entities back into chars.
     *
     * @param string $value
     *
     * @return mixed
     */
    public function unescape(string $value): string
    {
        return html_entity_decode($value);
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName(): string
    {
        return 'Twig custom extensions';
    }
}
