<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Indrig
 * Date: 03.08.13
 * Time: 12:35
 * To change this template use File | Settings | File Templates.
 */
namespace Core\Web\Form\View;

use Core\Web\Form\AbstractElement;

abstract class AbstractView
{
    /**
    * Standard boolean attributes, with expected values for enabling/disabling
    *
    * @var array
    */
    protected $booleanAttributes = array(
        'autocomplete' => array('on' => 'on',        'off' => 'off'),
        'autofocus'    => array('on' => 'autofocus', 'off' => ''),
        'checked'      => array('on' => 'checked',   'off' => ''),
        'disabled'     => array('on' => 'disabled',  'off' => ''),
        'multiple'     => array('on' => 'multiple',  'off' => ''),
        'readonly'     => array('on' => 'readonly',  'off' => ''),
        'required'     => array('on' => 'required',  'off' => ''),
        'selected'     => array('on' => 'selected',  'off' => ''),
    );



    /**
     * Create a string of all attribute/value pairs
     *
     * Escapes all attribute values
     *
     * @param  array $attributes
     * @return string
     */
    public function createAttributesString(array $attributes)
    {
        $strings    = array();
        foreach ($attributes as $key => $value)
        {
            //if($booleanAttributes isset($key))
            $strings[] = sprintf('%s="%s"', $key, $value);
        }
        return implode(' ', $strings);
    }
}
