<?php

return [

    /*
     * Recipient
     *
     * Specify here the recipients to receive the dusk screenshots,
     * multiple recipients can be comma separated
     */
    'recipient' => env('DUSK_FAILURES_RECIPIENT', null),

    /*
     * Path
     *
     * Specify here the path to the Laravel Dusk screenshots folder
     */
    'path' => 'tests/Browser/screenshots'

];
