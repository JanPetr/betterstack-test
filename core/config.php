<?php

/**
 * Config
 * provides interface for user's configuration options
 */
class Config {
	
	private $directory;
	public $database;
    public $logging;
	
	public function __construct() {
		// Save current directory path
		$this->directory = dirname(__FILE__);

        // Read user's database config
        require $this->directory.'/../config/database.php';
        $this->database = $database;

        // Read user's database config
        require $this->directory.'/../config/logging.php';
        $this->logging = $logging;
	}
	
}

return new Config();
