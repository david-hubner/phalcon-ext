<?php

/*
 * Phalcon Ext
 * Copyright (c) 2016 David Hübner
 * This source file is subject to the New BSD License
 * Licence is bundled with this package in the file docs/LICENSE.txt
 * Author: David Hübner <david.hubner@gmail.com>
 */

namespace PhalconExt\Validation\Validator;

use Phalcon\Validation,
    Phalcon\Validation\Exception;

/**
 * Validates exact string length
 *
 * @author     David Hübner <david.hubner at google.com>
 * @version    Release: @package_version@
 * @since      Release 1.0
 */
class StringLengthExact extends Validation\Validator
{

    /**
     * Value validation
     *
     * @author  David Hübner <david.hubner at google.com>
     * @param   \Phalcon\Validation $validation - validation object
     * @param   string $attribute - validated attribute
     * @return  bool
     * @throws  \Phalcon\Validation\Exception
     */
    public function validate(Validation $validation, $attribute)
    {
        if (!$this->hasOption('length')) {
            throw new Exception('Length must be set');
        }

        $allowEmpty = $this->getOption('allowEmpty');
        $value = $validation->getValue($attribute);

        if ($allowEmpty && ((is_scalar($value) && (string) $value === '') || is_null($value))) {
            return true;
        }

        $length = $this->getOption('length');

        if ((is_string($value) || is_numeric($value)) && mb_strlen($value) == $length) {
            return true;
        }

        $message = ($this->hasOption('message') ? $this->getOption('message') : 'Length must be ' . $length);

        $validation->appendMessage(
            new Validation\Message($message, $attribute, 'StringLengthExactValidator')
        );

        return false;
    }

}
