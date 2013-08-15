<?php
namespace CsnUser; // Important for Doctrine othervise can not find the Entities

return array(
	'static_salt' => 'aFGQ475SDsdfsaf2342',
	'controllers' => array(
        'invokables' => array(
            'User\Controller\Index' => 'User\Controller\IndexController',
        ),
    ),	
    'router' => array(
        'routes' => array(
			'user' => array(
				'type'    => 'Literal',
				'options' => array(
					'route'    => '/user',
					'defaults' => array(
						'controller'    => 'User\Controller\Index',
						'action'        => 'index',
					),
				),
				'may_terminate' => true,
				'child_routes' => array(

					'signin' => array(
						'type'    => 'Literal',
						'options' => array(
							'route'    => '/signin',
							'defaults' => array(
								'action'        => 'signin',
							),
						),
					),
					'signout' => array(
						'type'    => 'Literal',
						'options' => array(
							'route'    => '/signout',
							'defaults' => array(
								'action'        => 'signout',
							),
						),
					),
					'signup' => array(
						'type'    => 'Literal',
						'options' => array(
							'route'    => '/signup',
							'defaults' => array(
								'action'        => 'index',
							),
						),
					),
					'forgotten-password' => array(
						'type'    => 'Literal',
						'options' => array(
							'route'    => '/forgotten-password',
							'defaults' => array(
								'action'        => 'forgottenPassword',
							)
						)
					)
				)
			)
		)
	),
    'controller_plugins' => array(
        'invokables' => array(
            'user' => 'User\Controller\Plugin\User'
        )
    ),
    'view_helpers' => array(
        'factories' => array(
            'user' => 'User\View\Helper\Service\UserFactory',
        )
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);
