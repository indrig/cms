<?php
return array(
    'caches' => array(
        'Cache\Default' => array(
            'adapter'   => 'filesystem',
            'ttl'       => 86400,
            'options'   => array(
                'cache_dir' => __DIR__.'/../../data/cache'
            ),
            'plugins' => array(
                // Don't throw exceptions on cache errors

                // We store database rows on filesystem so we need to serialize them
                'Serializer'
            )
        ),

    ),
);