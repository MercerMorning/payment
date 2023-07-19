<?php

namespace App\Controller\Common;

use Symfony\Component\Form\FormInterface;

trait FormErrorsAdapterTrait
{
    private function getErrorMessages(FormInterface $form)
    {
        $errors = [];

        foreach ($form->getErrors() as $error) {
            $errors[] = $error->getMessage();
        }

        foreach ($form->all() as $child) {
            if (!$child->isValid()) {
                $errors[$child->getName()] = $this->getErrorMessages($child);
            }
        }

        return $errors;
    }
}