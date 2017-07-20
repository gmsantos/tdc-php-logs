<?php

require_once __DIR__ . '/vendor/autoload.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter\LineFormatter;
use Monolog\Processor\PsrLogMessageProcessor;
use Monolog\Processor\IntrospectionProcessor;
use Monolog\Processor\TagProcessor;


$logger = new Logger('my_logger');

$handler = new StreamHandler(__DIR__.'/my_app.log');
$handler->setFormatter(new LineFormatter("[%datetime%] %level_name%: %message% %context% %extra%\n"));

$logger->pushHandler($handler);

// Add some processors
$logger->pushProcessor(new PsrLogMessageProcessor());
$logger->pushProcessor(new IntrospectionProcessor(Logger::WARNING));
//$logger->pushProcessor(new TagProcessor(['integration', 'product'])); // Add tags :)

// Make it clear what is happening
$logger->info('Starting csv file import', ['file' => '/path/file.csv']);
$logger->debug('Reading csv file');
$logger->notice('Skip header', ['line' => 1]);

foreach (range(2,4) as $value) {
    $logger->debug('Loading row {line}', ['line' => $value, 'data' => ['some' => 'data']]);
}

// context makes the diference
$logger->warning('Unable to sync Sale Order', ['id' => 123]);
