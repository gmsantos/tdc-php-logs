<?php

// First slide - Hello World!

require_once __DIR__ . '/vendor/autoload.php';

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

$logger = new Logger('my_logger');
$logger->pushHandler(new StreamHandler(__DIR__.'/my_app.log'));

$logger->info('Hello World!');

// Second slide - Adding Handlers

use Monolog\Handler\RotatingFileHandler;
$logger->pushHandler(new RotatingFileHandler(__DIR__.'/error.log', 3, Logger::ERROR));

$logger->debug('Debug event');
$logger->error('Error event');

// Third slide - Adding Processors

use Monolog\Processor\IntrospectionProcessor;
$logger->pushProcessor(new IntrospectionProcessor(Logger::WARNING));

$logger->notice('Important event');
$logger->warning('Deprecated: Lorem Ipsum...');

// Fourth slide - Psr Log Processor

$data = ['user' => 'TDC'];

$logger->info('User '. $data['user'] .' logged', $data); // Sem PsrProcessor

use Monolog\Processor\PsrLogMessageProcessor;
$logger->pushProcessor(new PsrLogMessageProcessor());

$logger->info('User {user} logged', $data); // Com PsrProcessor

// Fifth slide - Customizing Handler Formatter

$rotatingFileHandler = $logger->popHandler();
$fileHandler = $logger->popHandler();
$htmlHandler = new StreamHandler(__DIR__.'/log.html', Logger::DEBUG);

use Monolog\Formatter\LineFormatter;
use Monolog\Formatter\JsonFormatter;
use Monolog\Formatter\HtmlFormatter;

$fileHandler->setFormatter(new LineFormatter("%level_name%: %message% %context% %extra%\n"));
$rotatingFileHandler->setFormatter(new JsonFormatter());
$htmlHandler->setFormatter(new HtmlFormatter());

$logger->setHandlers([
    $fileHandler,
    $rotatingFileHandler,
    $htmlHandler,
]);

$logger->error('Unhandled Expection: Lorem ipsum', ['user' => 'TDC']);
$logger->critical('User {user} is trying to hack us!', ['id' => 666, 'user' => 'TDC',]);
