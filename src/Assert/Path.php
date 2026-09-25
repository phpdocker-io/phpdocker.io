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

namespace App\Assert;

use Symfony\Component\Validator\Constraint;

/**
 * Validation constraint for safe, bounded generated paths.
 *
 * @Annotation
 */
class Path extends Constraint
{
    public const string ABSOLUTE_DIR = 'absolute_dir';
    public const string RELATIVE_PHP = 'relative_php';
    public const string HOST_PATH = 'host_path';

    public string $message = 'This value is not a valid path';

    public function __construct(
        public string $type = self::HOST_PATH,
        ?array $groups = null,
        mixed $payload = null,
        mixed $options = null,
    ) {
        parent::__construct($options, $groups, $payload);
    }

    /**
     * Maps each supported path type to the regular expression its values must match.
     *
     * @return array<string, string>
     */
    public static function getRegexes(): array
    {
        return [
            self::ABSOLUTE_DIR => '\A/[A-Za-z0-9._-]+(?:/[A-Za-z0-9._-]+)*\z',
            self::RELATIVE_PHP => '\A[A-Za-z0-9._-]+(?:/[A-Za-z0-9._-]+)*\.php\z',
            self::HOST_PATH => '\A[A-Za-z0-9._/-]+\z',
        ];
    }
}
