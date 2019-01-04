<?php
/**
 * Created by PhpStorm.
 * User: darko.lesendric
 * Date: 9/27/2018
 * Time: 10:58 PM.
 */

namespace App\Util\Helpers;

use Symfony\Component\Form\FormInterface;

class FormHelper
{
    public static function getFormErrors(FormInterface $form)
    {
        $errors = [];
        foreach ($form->getErrors() as $key => $error) {
            if ($form->isRoot()) {
                $errors['#form'][] = $error->getMessage();
            } else {
                $errors[] = $error->getMessage();
            }
        }
        foreach ($form->all() as $child) {
            if (!$child->isSubmitted() || !$child->isValid()) {
                foreach ($child->getErrors(true, true) as $e) {
                    $errors['#'.$child->getName()] = $e->getMessage();
                }
            }
        }

        return $errors;
    }
}
