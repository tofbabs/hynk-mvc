<?php
define('DEVELOPMENT_ENVIRONMENT', FALSE);

define('DEFAULT_CONROLLER', 'dashboard');
define('DEFAULT_ACTION', 'index');
define('NOT_FOUND_CONTROLLER', 'Notfound');

define('BASE_PATH', '/var/www/html/blacklist/');

define('TEMP_UPLOAD_PATH', BASE_PATH . 'temp/');
define('FILE_PATH', BASE_PATH . 'public/site/files/');
define('EMAIL_HEADER', "maspblacklist@gmail.com");

define('ROOT_URL', 'http://blacklist.atp-sevas.com/blacklist/');

define('DB_HOST','127.0.0.1');
define('DB_NAME','blacklist');
define('DB_USER','root');
define('DB_PASS','fileopen');

?>
