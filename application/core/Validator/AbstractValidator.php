<?php
/**
 * User: Igor Bubnevich aka Indrig
 * Date: 12.08.13
 * Time: 18:07
 */
namespace Core\Validator;

abstract class AbstractValidator
{
    abstract public function isValid($value);
}