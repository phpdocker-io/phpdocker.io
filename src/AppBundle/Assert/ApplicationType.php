<?php
namespace AppBundle\Assert;

use Symfony\Component\Validator\Constraint;

/**
 * Validation constraint for application types.
 *
 * @package   AppBundle\Assert
 * @copyright Auron Consulting Ltd
 */
class ApplicationType extends Constraint
{
    /**
     * @var string
     */
    public $message = 'This value is not a supported application type';
}
