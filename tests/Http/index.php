<?php

declare(strict_types=1);

use MaAlps\MaAlps\Bootstrap;

require dirname(__DIR__, 2) . '/vendor/autoload.php';
exit((new Bootstrap())('test-hal-api-app', $GLOBALS, $_SERVER));
