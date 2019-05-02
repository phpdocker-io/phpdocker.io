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

declare(strict_types=1);

namespace App\Middleware\Traits;

use function preg_match;

/**
 * There are a number of paths that ideally we'd like to skip most of our custom listeners on. Stuff like the web debug
 * profiler, the swagger.yaml endpoint etc. This trait brings in awareness of that.
 *
 * @author TAB
 */
trait IgnoredListenerPathsTrait
{
    /**
     * Request paths we'll be skipping our app's code - for instance, the dev profiler.
     */
    private $pathRegex = '/^\/(_profiler|_wdt|_error|env)/';

    /**
     * Works out whether a path must be ignored, as per regex.
     *
     * @param string $path
     *
     * @return bool
     */
    private function isPathIgnored(string $path): bool
    {
        return preg_match($this->pathRegex, $path) > 0;
    }
}
