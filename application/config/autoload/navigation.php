<?php
return array(
    'navigation' => array(
        'default' => array(
            array(
                'label'     => 'Home',
                'route'     => 'home',
                'visible'   => false
            )
        ),
        'admin' => array(
            array(
                'label'     => 'User',
                'route'     => 'user'
            ),
            array(
                'label'     => 'Data',
                'route'     => 'user/signin'
            )
        )
    ),

);