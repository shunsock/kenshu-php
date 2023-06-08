<?php
return [
    'default'          => 'standard',
    'sanitizers'       => [
        'standard' => \Smorken\Sanitizer\Actors\Standard::class,
        'sis'      => \Smorken\Sanitizer\Actors\RdsCds::class,
        'xss'      => \Smorken\Sanitizer\Actors\Xss::class,
    ],
];
