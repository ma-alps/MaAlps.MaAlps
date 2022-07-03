<?php

declare(strict_types=1);

use MaAlps\MaAlps\Bootstrap;

require dirname(__DIR__) . '/autoload.php';
exit((new Bootstrap())(PHP_SAPI === 'cli-server' ? 'hal-api-app' : 'prod-hal-api-app', $GLOBALS, $_SERVER));
