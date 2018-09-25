<?php

use Rareloop\Lumberjack\Application;
use App\Exceptions\Handler;
use Rareloop\Lumberjack\Exceptions\HandlerInterface;

$autoloader = require_once('autoload.php');

$autoloader('App\\', dirname(__DIR__) . '/app/');

$app = new Application(dirname(__DIR__));

$app->bind(HandlerInterface::class, $app->make(Handler::class));

return $app;
