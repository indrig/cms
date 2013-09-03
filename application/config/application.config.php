<?php
return array(

    // This should be an array of module namespaces used in the application.
    'modules' => array(
        //CMS Modules
        'Main',
        'User',
        'Admin'
    ),


    // These are various options for the listeners attached to the ModuleManager
    'module_listener_options' => array(
        'config_cache_enabled' => false,
        'config_cache_key' => "cms",
        'module_map_cache_enabled' => false,
        'module_map_cache_key' => "cms",

        // The path in which to cache merged configuration.
        'cache_dir' =>  './data/cache',

        'module_paths' => array(
            './module',
            './vendor',
        ),
        'config_glob_paths' => array(
            './config/autoload/{,*}.php',
        ),
    )
);
