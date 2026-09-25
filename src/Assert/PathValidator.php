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
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Generated path config validator.
 */
class PathValidator extends ConstraintValidator
{
    /**
     * Checks if the passed value is valid.
     */
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (is_string($value) === false) {
            return;
        }

        assert($constraint instanceof Path);

        $regex = Path::getRegexes()[$constraint->type] ?? null;

        if ($regex === null || str_contains($value, '..') || preg_match('#' . $regex . '#', $value) !== 1) {
            $this
                ->context
                ->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $this->formatValue($value))
                ->addViolation();
        }
    }
}
