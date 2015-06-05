<?php
/**
 * Created by PhpStorm.
 * User: Antony
 * Date: 6/1/2015
 * Time: 18:31
 */

require 'vendor/autoload.php';
date_default_timezone_set('Europe/Athens');

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$app = new \Slim\Slim();

// $log = new Logger('name');  //Because of the use statement, Logger is equal to Monolog\Logger
// $log->pushHandler(new StreamHandler('app.txt', Logger::WARNING));
// $log->addWarning('Oh No!');

$app->get('/hello/:name', function ($name) {
	echo "Hello, $name";
});

$app->run();

?>