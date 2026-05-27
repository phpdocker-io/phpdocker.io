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

namespace App\PHPDocker\Project\ServiceOptions;

use InvalidArgumentException;

enum ElasticsearchVersion: string
{
    case V65 = '6.5.4';
    case V56 = '5.6';

    /**
     * @return array<string, string>
     */
    public static function choices(): array
    {
        $choices = [];

        foreach (self::cases() as $version) {
            $choices[$version->value] = $version->label();
        }

        return $choices;
    }

    /**
     * @return string[]
     */
    public static function values(): array
    {
        return array_map(static fn (self $version): string => $version->value, self::cases());
    }

    public static function fromString(string $version): self
    {
        return self::tryFrom($version) ?? throw new InvalidArgumentException(sprintf('Version %s is not supported', $version));
    }

    private function label(): string
    {
        return match ($this) {
            self::V65 => '6.5.x',
            self::V56 => '5.6.x',
        };
    }
}
