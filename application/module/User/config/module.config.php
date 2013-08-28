<?php
return array(
    'navigation' => array(
        'default' => array(
            'admin' => array(
                'pages' => array(
                    array(
                        'label'     => 'Users',
                        'route'     => 'user/admin',
                        'resource'  => 'Admin',
                        'pages'     => array(
                            array(
                                'label'     => 'Roles',
                                'route'     => 'user/admin/role',
                                'resource'  => 'Admin',
                                'pages'     => array(
                                    array(
                                        'label'     => 'Create',
                                        'route'     => 'user/admin/role/create',
                                        'resource'  => 'Admin',
                                    ),
                                    array(
                                        'label'     => 'Edit',
                                        'route'     => 'user/admin/role/edit',
                                        'resource'  => 'Admin',
                                    ),
                                )
                            ),
                            array(
                                'label'     => 'Settings',
                                'route'     => 'user/admin/setting',
                                'resource'  => 'Admin',
                            ),
                        )
                    )
                )
            )
        )
    ),
	'controllers' => array(
        'invokables' => array(
            'User\Controller\Index'     => 'User\Controller\IndexController',
            'User\Controller\Admin'     => 'User\Controller\AdminController',
            'User\Controller\Role'      => 'User\Controller\RoleController',
            'User\Controller\Setting'   => 'User\Controller\SettingController',
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
                            'create' => array(
                                'type'    => 'Literal',
                                'options' => array(
                                    'route'    => '/create',
                                    'defaults' => array(
                                        'action'        => 'create',
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
                                ),
                                'may_terminate' => true,
                                'child_routes' => array(
                                    'create' => array(
                                        'type'    => 'Literal',
                                        'options' => array(
                                            'route'    => '/create',
                                            'defaults' => array(
                                                'action'        => 'create',
                                            )
                                        )
                                    ),
                                    'edit'  => array(
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
                                    )
                                )
                            ),
                            'setting' => array(
                                'type'    => 'Literal',
                                'options' => array(
                                    'route'    => '/setting',
                                    'defaults' => array(
                                        'controller'    => 'User\Controller\Setting',
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
