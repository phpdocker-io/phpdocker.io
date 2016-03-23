<?php
namespace AppBundle\Assert;

use Symfony\Component\Validator\Constraint;

/**
 * Validation constraint for postgresql types.
 *
 * @package   AppBundle\Assert
 * @copyright Auron Consulting Ltd
 */
class PostgresType extends Constraint
{
    /**
     * @var string
     */
    public $message = 'This value is not a supported Postgres version';
}
