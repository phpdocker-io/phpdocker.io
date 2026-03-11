<?php
declare(strict_types=1);

namespace App\Tests\Unit\Assert;

use App\Assert\PostgresType;
use App\Assert\PostgresTypeValidator;
use PHPUnit\Framework\Attributes\Test;
use Symfony\Component\Validator\ConstraintValidatorInterface;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

/**
 * @extends ConstraintValidatorTestCase<PostgresTypeValidator>
 */
class PostgresTypeValidatorTest extends ConstraintValidatorTestCase
{
    protected function createValidator(): ConstraintValidatorInterface
    {
        return new PostgresTypeValidator();
    }

    #[Test]
    public function validPostgresVersionProducesNoViolations(): void
    {
        $this->validator->validate('15', new PostgresType());
        $this->assertNoViolation();
    }

    #[Test]
    public function invalidVersionStringProducesOneViolation(): void
    {
        $constraint = new PostgresType();
        $this->validator->validate('99', $constraint);

        $this->buildViolation($constraint->message)
            ->setParameter('{{ value }}', '"99"')
            ->assertRaised();
    }

    #[Test]
    public function nullValueProducesNoViolations(): void
    {
        $this->validator->validate(null, new PostgresType());
        $this->assertNoViolation();
    }
}
