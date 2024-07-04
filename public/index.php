<?php

use Nouracea\Nouramework\Http\Kernel;
use Nouracea\Nouramework\Http\Request;

define('BASE_PATH', dirname(__DIR__));

require_once BASE_PATH.'/vendor/autoload.php';

$container = require BASE_PATH.'/config/services.php';

$kernel = $container->get(Kernel::class);

$request = Request::createFromGlobals();
$response = $kernel->handle($request);

$response->send();
