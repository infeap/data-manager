<?php

return function (array $app): array {

    return [
        'debug' => true,
        'develop' => false,

        'php' => [

            /*
             * The default timezone should be set globally in php.ini in order to be synchronized between other
             * applications running on the same server, but can be set specificially on demand.
             */
            'date.timezone' => 'Europe/Berlin',
        ],
    ];
};
