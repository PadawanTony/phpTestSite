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

//Uncomment these 4 lines to use Logger
// $log = new Logger('name');  //Because of the use statement, Logger is equal to Monolog\Logger
// $log->pushHandler(new StreamHandler('app.txt', Logger::WARNING));
// $log->addWarning('Oh No!');

$app = new \Slim\Slim( array(
	'view' => new \Slim\Views\Twig()
));


$view = $app->view();
$view->parserOptions = array(
	'debug' => true,
);
$view->parserExtensions = array(
	new \Slim\Views\TwigExtension(),
);


$app->get('/', function() use($app) {
	$app->render('about.twig');
})->name('about');

$app->get('/contact', function() use($app) {
	$app->render('contact.twig');
})->name('contact');

$app->post('/contact', function() use($app) {
	$name = $app->request->post('name');
	$email = $app->request->post('email');
	$msg = $app->request->post('msg');

	if( !empty($name) && !empty($email) && !empty($msg) ) {
		$cleanName = filter_var($name, FILTER_SANITIZE_STRING);
		$cleanEmail = filter_var($name, FILTER_SANITIZE_EMAIL);
		$cleanMsg = filter_var($name, FILTER_SANITIZE_STRING);
	} else {
		$app->redirect('/contact');
	}

	$transport = Swift_MailTransport::newInstance();
	$mailer = Swift_Mailer::newInstance($transport);

	$message = Swift_Message::newInstance();
	$message->setSubject("Email from our Website");
	$message->setFrom(array(
		$cleanEmail => $cleanName
	));
	$message->setTo(array('anthonykalogeropoulos@gmail.com' => "Anthony Kalos"));
	$message->setBody($cleanMsg);

	$result = $mailer->send($message);

	if ($result > 0) {
		$app->redirect('/');
	} else {
		$app->redirect('/contact');
	}
});

$app->run();

?>