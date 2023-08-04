<?php
declare(strict_types=1);

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 *
 * @author Radoje Albijanic <radoje.albijanic@gmail.com>
 */
#[\Attribute(\Attribute::TARGET_PROPERTY)]
class EntityExist extends Constraint
{
    public $message = 'Entity "%entity%" with property "%property%": "%value%" does not exist.';
    public $property = 'id';
    public $entity;

    public function __construct($entity = null, $property = null, $message = null, $options = null, array $groups = null, $payload = null)
    {
        parent::__construct($options, $groups, $payload);

        $this->entity = $entity ?? $this->entity;
        $this->property = $property ?? $this->property;
        $this->message = $message ?? $this->message;
    }

    public function validatedBy(): string
    {
        return EntityExistValidator::class;
    }
}