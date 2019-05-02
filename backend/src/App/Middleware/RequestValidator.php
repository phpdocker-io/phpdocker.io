<?php
declare(strict_types=1);
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

namespace App\Middleware;

use App\Middleware\Traits\CorsPreflightAwareTrait;
use App\Middleware\Traits\IgnoredListenerPathsTrait;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

/**
 * Validates incoming request against our OpenApi schema.
 */
class RequestValidator
{
    use CorsPreflightAwareTrait;
    use IgnoredListenerPathsTrait;

    public function onKernelRequest(GetResponseEvent $event): void
    {
        $request = $event->getRequest();

        // Ensure we don't do anything on excluded paths
        if ($this->isPathIgnored($request->getPathInfo()) === true) {
            return;
        }

        // CORS preflight: bypass everything here
        if ($this->isCorsPreflight($request) === true) {
            return;
        }
    }
}
