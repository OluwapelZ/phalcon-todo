<?php

require dirname(__DIR__) . '/vendor/autoload.php';

use App\Bootstrap\ApiServicesBootStrap;
use App\Bootstrap\LogServicesBootstrap;
use App\Bootstrap\MiddlewareBootstrap;
use App\Bootstrap\RouteBootstrap;
use App\Constants\ResponseCodes;
use App\Constants\ResponseMessages;
use PhalconUtils\Bootstrap\Bootstrap;
use PhalconUtils\Bootstrap\OAuthRouteBootstrap;
use PhalconUtils\Bootstrap\OAuthServiceBootstrap;
use PhalconUtils\Constants\HttpStatusCodes;

date_default_timezone_set('UTC');

ini_set('display_errors', "On");
error_reporting(E_ALL);

//include Composer Auto Loader
include __DIR__ . "/../vendor/autoload.php";

//$envFile = ((getenv('APPLICATION_ENV') == 'test') ? '.env.test' : '.env');
$dotenv = new Dotenv\Dotenv(dirname(__DIR__) . DIRECTORY_SEPARATOR . 'env', '.env.circleci');
$dotenv->load();

$config = include __DIR__ . "/../App/config/config.php";

ini_set('display_errors', (($config->debug) ? "On" : "Off"));

$env = getenv('APPLICATION_ENV');

//include Phalcon Loader
include __DIR__ . "/../App/config/loader.php";

// Instantiate application & DI with the Phalcon Framework
$di = new Phalcon\DI\FactoryDefault\Cli();
$app = new Phalcon\Mvc\Micro($di);

/**
 * connect with route
 */
include __DIR__ . "/../App/endpoints/todo.php";


// Bootstrap components
//$bootstrap = new Bootstrap(
//    new LogServicesBootstrap,
//    new ApiServicesBootStrap,
//    new OAuthServiceBootstrap,
//    new MiddlewareBootstrap,
//    new RouteBootstrap,
//    new OAuthRouteBootstrap
//);
//
//$bootstrap->run($app, $di, $config);


////handle invalid routes
//$app->notFound(function () use ($app) {
//    $message = ResponseMessages::getMessageFromCode(ResponseCodes::METHOD_NOT_IMPLEMENTED);
//    $code = ResponseCodes::METHOD_NOT_IMPLEMENTED;
//    send($app, $message, $code, 501);
//});
//
//// Handle invalid routes
//function send($app, $message, $code, $httpStatusCode)
//{
//    $app->response->setStatusCode($httpStatusCode, HttpStatusCodes::getMessage($httpStatusCode))->sendHeaders();
//    $app->response->setContentType('application/json');
//    $app->response->setJsonContent(
//        array(
//            'status' => 'error',
//            'message' => $message,
//            'code' => $code
//        )
//    );
//    $app->response->send();
//    exit;
//}
//
//
////handle errors and exceptions
//$app->error(function ($exception) use ($app) {
//    $app->response->setContentType('application/json');
//    $app->response->setStatusCode(500, HttpStatusCodes::getMessage(500))->sendHeaders();
//    $app->response->setJsonContent(
//        [
//            'status' => 'error',
//            'message' => ResponseMessages::getMessageFromCode(ResponseCodes::UNEXPECTED_ERROR),
//            'code' => ResponseCodes::UNEXPECTED_ERROR,
//            'ex' => $exception->getMessage()
//        ]
//    );
//
//    $app->response->send();
//});


//$app->handle();
