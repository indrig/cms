<?php
return array(
    'caches' => array(
        'Cache\Default' => array(
            'adapter'   => 'filesystem',
            'ttl'       => 86400,
            'options'   => array(
            'cache_dir' => __DIR__.'/../../data/cache'
            )
        ),
    ),
);