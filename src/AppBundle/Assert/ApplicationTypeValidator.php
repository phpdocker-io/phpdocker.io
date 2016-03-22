<?php
namespace AppBundle\Assert;

use AuronConsultingOSS\Docker\Project\ServiceOptions\Application;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Application type validator.
 *
 * @package   AppBundle\Assert
 * @copyright Auron Consulting Ltd
 */
class ApplicationTypeValidator extends ConstraintValidator
{
    /**
     * Checks if the passed value is valid.
     *
     * @param mixed      $value      The value that should be validated
     * @param Constraint $constraint The constraint for the validation
     */
    public function validate($value, Constraint $constraint)
    {
        if ($value !== null && array_key_exists($value, Application::getChoices()) === false) {
            $this
                ->context
                ->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $this->formatValue($value))
                ->addViolation();
        }
    }
}
