<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Browser-accessible Artisan commands (/command)
    |--------------------------------------------------------------------------
    |
    | When enabled, admins can run a small whitelist of Artisan commands from
    | the web UI. Keep false in production unless you understand the risks.
    |
    */
    'allow_web_commands' => env('ALLOW_WEB_COMMANDS', false),

    /*
    | Allow the /command routes outside the local environment. When false, only
    | APP_ENV=local may use web commands (still requires ALLOW_WEB_COMMANDS).
    |
    */
    'allow_web_commands_in_production' => env('ALLOW_WEB_COMMANDS_IN_PRODUCTION', false),

];
