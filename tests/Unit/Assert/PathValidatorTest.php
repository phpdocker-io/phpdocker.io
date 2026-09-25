<?php
declare(strict_types=1);

namespace App\Tests\Unit\Assert;

use App\Assert\Path;
use App\Assert\PathValidator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Symfony\Component\Validator\ConstraintValidatorInterface;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

/**
 * @extends ConstraintValidatorTestCase<PathValidator>
 */
class PathValidatorTest extends ConstraintValidatorTestCase
{
    protected function createValidator(): ConstraintValidatorInterface
    {
        return new PathValidator();
    }

    /**
     * @return array<string, array{string, string}>
     */
    public static function validPathsProvider(): array
    {
        return [
            'absolute dir'        => [Path::ABSOLUTE_DIR, '/application'],
            'absolute nested'     => [Path::ABSOLUTE_DIR, '/var/www/myapp'],
            'relative php'        => [Path::RELATIVE_PHP, 'public/index.php'],
            'relative php nested' => [Path::RELATIVE_PHP, 'app/src/index.php'],
            'host path dot'       => [Path::HOST_PATH, '.'],
            'host path relative'  => [Path::HOST_PATH, 'src/app'],
            'host path absolute'  => [Path::HOST_PATH, '/var/www'],
        ];
    }

    #[Test]
    #[DataProvider('validPathsProvider')]
    public function validPathsProduceNoViolations(string $type, string $value): void
    {
        $this->validator->validate($value, new Path(type: $type));
        $this->assertNoViolation();
    }

    /**
     * @return array<string, array{string, string}>
     */
    public static function invalidPathsProvider(): array
    {
        return [
            'space in host path'          => [Path::HOST_PATH, '/var/www/my app'],
            'traversal host path'         => [Path::HOST_PATH, '../etc'],
            'traversal absolute'          => [Path::ABSOLUTE_DIR, '/var/../etc'],
            'space absolute'              => [Path::ABSOLUTE_DIR, '/var/www myapp'],
            'absolute without leading slash' => [Path::ABSOLUTE_DIR, 'var/www'],
            'php missing extension'       => [Path::RELATIVE_PHP, 'public/index'],
            'php space'                   => [Path::RELATIVE_PHP, 'public/my index.php'],
            'php traversal'               => [Path::RELATIVE_PHP, 'public/../index.php'],
        ];
    }

    #[Test]
    #[DataProvider('invalidPathsProvider')]
    public function invalidPathsProduceOneViolation(string $type, string $value): void
    {
        $constraint = new Path(type: $type);
        $this->validator->validate($value, $constraint);

        $this->buildViolation($constraint->message)
            ->setParameter('{{ value }}', '"' . $value . '"')
            ->assertRaised();
    }

    #[Test]
    public function nonStringValueProducesNoViolations(): void
    {
        $this->validator->validate(null, new Path(type: Path::HOST_PATH));
        $this->assertNoViolation();
    }

    #[Test]
    public function emptyStringProducesOneViolation(): void
    {
        $constraint = new Path(type: Path::HOST_PATH);
        $this->validator->validate('', $constraint);

        $this->buildViolation($constraint->message)
            ->setParameter('{{ value }}', '""')
            ->assertRaised();
    }
}
