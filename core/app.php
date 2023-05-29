<?php

require "../vendor/autoload.php";

use Monolog\Logger;
use Logtail\Monolog\LogtailHandler;

// Load BaseModel and all models from models directory
require dirname(__FILE__).'/base_model.php';
foreach (glob(dirname(__FILE__).'/../models/*.php') as $filename) {
    require $filename;
}

/**
 * App
 * provides interface for database manipulation, accessing config and rendering views
 */
class App
{

    private $directory;
    public $db;
    public $config;
    public $logger;

    public function __construct()
    {
        // Save current directory path
        $this->directory = dirname(__FILE__);

        // Load configuration options
        $this->config = require $this->directory.'/config.php';

        // Load database instance and tell it to connect with given config
        $this->db = require $this->directory.'/database.php';
        $this->db->connect($this->config->database);

        $this->logger = new Logger($this->config->logging['source']);
        $this->logger->pushHandler(new LogtailHandler($this->config->logging['token']));

        session_start();
    }

    /**
     * Renders given view with given set of variables
     *
     * param $viewfile: path of the view file relative to the views direcotry, without the ending .php
     * param $vars: array of variables to be accessed insede the views
     */
    public function renderView($viewfile, $vars = array())
    {
        // set header
        header('X-Frame-Options: DENY');

        // Render array to usable variables
        foreach ($vars as $key => $value) {
            $$key = $value;
        }

        // Start capturing of output
        ob_start();
        include '../views/'.$viewfile.'.php';
        // Assign output to $content which will be rendered in layout
        $content = ob_get_contents();
        // Stop output capturing
        ob_end_clean();
        // Render $content in layout
        include '../views/layout.php';
    }

    // Function to log errors to your logging service
    public function log_error($severity, $message, $file, $line)
    {
        $this->logger->critical($message, [
            'severity' => $severity,
            'file' => $file,
            'line' => $line,
        ]);
    }

}

function generateCSRFToken()
{
    return md5(uniqid(mt_rand(), true));;
}

function escape($string)
{
    if ($string === null) {
        return null;
    }

    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

function isAjax()
{
    if (strtolower($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') == 'xmlhttprequest') {
        return true;
    }

    return false;
}

$app = new App();

function handle_fatal_error()
{
    global $app;
    $error = error_get_last();
    if ($error !== null && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
        // Clear any existing output
        ob_clean();

        // Display a generic error message
        echo 'Internal error';

        // Log the error using the existing $app instance
        $app->log_error($error['type'], $error['message'], $error['file'], $error['line']);

        // Prevent PHP from displaying the actual error message
        exit();
    }
}

// Register shutdown function to handle fatal errors
register_shutdown_function('handle_fatal_error');

// Set error handler to handle non-fatal errors
set_error_handler(function ($severity, $message, $file, $line) {
    global $app;
    // Log the error using the existing $app instance
    $app->log_error($severity, $message, $file, $line);

    echo 'An error occurred. Please try again later.';

    // Prevent PHP from displaying the actual error message
    return true;
});

return $app;
