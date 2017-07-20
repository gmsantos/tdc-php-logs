<?php

require_once __DIR__ . '/vendor/autoload.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter\LineFormatter;

$logger = new Logger('my_logger');

$handler = new StreamHandler(__DIR__.'/my_app.log');
$handler->setFormatter(new LineFormatter("[%datetime%] %level_name%: %message%\n"));

$logger->pushHandler($handler);

// Not so clear logs
$logger->info('foi');
$logger->debug('vai');
$logger->notice('passou!!');

foreach (range(2,4) as $value) {
    $logger->debug($value);
}

// Not informative
$logger->warning('Unable to sync Sale Order');

// Hard to group errors
for ($i = 1; $i <= 3; $i++) {
    $logger->error(
        sprintf(
            'Allowed memory size of %s bytes exhausted (tried to allocate %s bytes)',
            random_int(1, PHP_INT_MAX),
            random_int(1, PHP_INT_MAX)
        )
    );
}
