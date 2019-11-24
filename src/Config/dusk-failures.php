<?php

return [

    /*
     * Recipient
     *
     * Specify here the recipients to receive the dusk screenshots,
     * multiple recipients can be comma separated.
     */
    'recipient' => env('DUSK_FAILURES_RECIPIENT', ''),

    /*
     * Screenshot Path
     *
     * Specify here the path to the Laravel Dusk screenshots folder.
     */
    'screenshot_path' => 'tests/Browser/screenshots',

    /*
     * Console Path
     *
     * Specify here the path to the Laravel Dusk console folder.
     */
    'console_path' => 'tests/Browser/console',

];
