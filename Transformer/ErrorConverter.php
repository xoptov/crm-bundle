<?php

namespace Perfico\DosalesBundle\Transformer;

use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\ConstraintViolationInterface;

class ErrorConverter
{
    /**
     * @var ValidatorInterface
     */
    protected $validator;

    /**
     * @param ValidatorInterface $validator
     */
    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param $object
     * @return array|bool
     */
    public function validate($object) {

        $errors = $this->validator->validate($object);
        if (count($errors)) {

            return $this->toArray($errors);
        } else {

            return false;
        }
    }

    /**
     * @param ConstraintViolationList $violationList
     * @return array
     */
    public function toArray(ConstraintViolationList $violationList)
    {
        $errors = [];
        /** @var $violation ConstraintViolationInterface */
        foreach($violationList as $violation) {
            $errors[$violation->getPropertyPath()] = $violation->getMessage();
        }

        return $errors;
    }
}