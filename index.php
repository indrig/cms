<?php
/**
 * This makes our life easier when dealing with paths. Everything is relative
 * to the application root now.
 */


// Decline static file requests back to the PHP built-in webserver
if (php_sapi_name() === 'cli-server' && is_file(__DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH))) {
    return false;
}

// Setup autoloading
require 'application/bootstrap.php';

try
{
    // Run the application!
    Application::app()->run();
}
catch (Exception $e)
{
    echo $e;
    include __DIR__.'/application/view/error/internal_error.phtml';
}