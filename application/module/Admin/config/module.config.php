<?php
/**
 * User: Igor Bubnevich aka Indrig
 * Date: 20.08.13
 * Time: 14:53
 */
return array(
    'view_helpers' => array(
        'factories' => array(
            'adminNavBar' => 'Admin\View\Helper\Service\NavBarFactory',
        )
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);