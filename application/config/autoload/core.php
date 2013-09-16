<?php
/**
 * User: Igor Bubnevich aka Indrig
 * Date: 21.08.13
 * Time: 11:52
 */
return array(
    'view_helpers' => array(
        'invokables' => array(
            'table'                => 'Engine\Table\View\Helper\Table',
            'tablecell'            => 'Engine\Table\View\Helper\TableCell',
            'tablerow'             => 'Engine\Table\View\Helper\TableRow',
            'tableheader'          => 'Engine\Table\View\Helper\TableHeader',

            //Forms

            'tbform'               => 'Engine\Form\View\Helper\Form',
            'tbformrow'            => 'Engine\Form\View\Helper\FormRow',
            'tbformcollection'     => 'Engine\Form\View\Helper\FormCollection',
        )
    ),
);