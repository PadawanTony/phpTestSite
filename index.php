<?php
/**
 * Created by PhpStorm.
 * User: Antony
 * Date: 6/1/2015
 * Time: 18:31
 */

require 'vendor/autoload.php';
date_default_timezone_set('Europe/Athens');

$log = new Monolog\Logger('name');
$log->pushHandler(new Monolog\Handler\StreamHandler('app.txt', Monolog\Logger::WARNING));

$log->addWarning('Foo');

echo "Hello World";



?>