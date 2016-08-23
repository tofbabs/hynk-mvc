<?php


include_once '/var/www/html/blacklist/system/config/config.php';
require_once '/var/www/html/blacklist/vendor/autoload.php';


function __autoloader($className) {
    $paths = array(
        BASE_PATH."/lib/",
        BASE_PATH."/site/controller/",
        BASE_PATH."/admin/controller/",
        BASE_PATH."/common/",
        BASE_PATH."/common/model/",
        BASE_PATH."/common/worker/"
    );
    foreach($paths as $path){
        if(file_exists($path.$className.".class.php")){
            echo $path.$className.".class.php" . PHP_EOL;
            require_once($path.$className.".class.php");
            break;
        }
    }
}


spl_autoload_register('__autoloader');

Utils::setErrorLogging();
Utils::sendmail('tofunmi@tm30.net','Testing','Is it working',EMAIL_HEADER);

Database::getInstance('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8', DB_USER, DB_PASS);

$settings = [
    'REDIS_BACKEND'     => '127.0.0.1:6379',    // Set Redis Backend Info
    'REDIS_BACKEND_DB'  => '0',                 // Use Redis DB 0
    'COUNT'             => '1',                 // Run 1 worker
    'INTERVAL'          => '1',                 // Run every 5 seconds
    'QUEUE'             => '*',                 // Look in all queues
    'PREFIX'            => 'cm',              // Prefix queues with test
];

foreach ($settings as $key => $value) {
    putenv(sprintf('%s=%s', $key, $value));
}

// Register Events
// Resque_Event::listen('beforePerform', 'checkCampaignStatus');

// Resque_Job_DontPerform

