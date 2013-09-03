<?php
/**
 * User: Igor Bubnevich aka Indrig
 * Date: 21.08.13
 * Time: 11:52
 */
return array(
    'view_helpers' => array(
        'invokables' => array(
            'table'                => 'Core\Table\View\Helper\Table',
            'tablecell'            => 'Core\Table\View\Helper\TableCell',
            'tablerow'             => 'Core\Table\View\Helper\TableRow',
            'tableheader'          => 'Core\Table\View\Helper\TableHeader',

            //Forms

            'tbform'               => 'Core\Form\View\Helper\Form',
            'tbformrow'            => 'Core\Form\View\Helper\FormRow',
            'tbformcollection'     => 'Core\Form\View\Helper\FormCollection',
        )
    ),
);