<?php
namespace AppBundle\Assert;

use AuronConsultingOSS\Docker\Project\ServiceOptions\Postgres;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Application type validator.
 *
 * @package   AppBundle\Assert
 * @copyright Auron Consulting Ltd
 */
class PostgresTypeValidator extends ConstraintValidator
{
    /**
     * Checks if the passed value is valid.
     *
     * @param mixed      $value      The value that should be validated
     * @param Constraint $constraint The constraint for the validation
     */
    public function validate($value, Constraint $constraint)
    {
        if ($value !== null && array_key_exists($value, Postgres::getChoices()) === false) {
            $this
                ->context
                ->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $this->formatValue($value))
                ->addViolation();
        }
    }
}
