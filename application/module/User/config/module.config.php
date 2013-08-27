<?php
namespace CsnUser; // Important for Doctrine othervise can not find the Entities

return array(
    'navigation' => array(
        'default' => array(
            'admin' => array(
                'pages' => array(
                    array(
                        'label'     => 'Users',
                        'route'     => 'user/admin',
                        'resource'  => 'Admin'
                    )
                )
            )
        )
    ),
	'static_salt' => 'aFGQ475SDsdfsaf2342',
	'controllers' => array(
        'invokables' => array(
            'User\Controller\Index' => 'User\Controller\IndexController',
            'User\Controller\Admin' => 'User\Controller\AdminController',
            'User\Controller\Role' => 'User\Controller\RoleController',
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
								'action'        => 'signup',
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
					),
                    'admin' => array(
                        'type'    => 'Literal',
                        'options' => array(
                            'route'    => '/'.ROUTE_ADMIN,
                            'defaults' => array(
                                'controller'    => 'User\Controller\Admin',
                                'action'        => 'index',
                            )
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'edit' => array(
                                'type'    => 'Segment',
                                'options' => array(
                                    'route'    => '/edit[/:id]',
                                    'constraints' => array(
                                        'id'     => '[0-9]+',
                                    ),
                                    'defaults' => array(
                                        'action'        => 'edit',
                                    )
                                )
                            ),

                            'role' => array(
                                'type'    => 'Literal',
                                'options' => array(
                                    'route'    => '/role',
                                    'defaults' => array(
                                        'controller'    => 'User\Controller\Role',
                                        'action'        => 'index',
                                    )
                                )
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

    'translator' => array(
        'locale' => 'ru',
        'translation_file_patterns' => array(
            array(
                'type'     => 'PhpArray',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.php',
            ),
        ),
    ),
);
