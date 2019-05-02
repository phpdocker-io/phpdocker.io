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

use Symfony\Component\HttpFoundation\Request;

/**
 * CORS preflight detection.
 *
 * @author TAB
 */
trait CorsPreflightAwareTrait
{
    /**
     * Detects whether the incoming request is a CORS preflight request.
     *
     * @param Request $request
     *
     * @return bool
     */
    private function isCorsPreflight(Request $request): bool
    {
        return $request->getMethod() === 'OPTIONS' && $request->headers->has('Access-Control-Request-Method');
    }
}
