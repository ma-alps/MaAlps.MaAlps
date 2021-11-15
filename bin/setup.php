<?php

declare(strict_types=1);

use BEAR\Dotenv\Dotenv;

require_once dirname(__DIR__) . '/vendor/autoload.php';

if (! getenv('MA_DB_DSN')) {
    (new Dotenv())->load(dirname(__DIR__));
}

chdir(dirname(__DIR__));
passthru('chmod 775 var/tmp');
passthru('chmod 775 var/log');

// db
$pdo = new PDO('mysql:host=' . getenv('MA_DB_HOST'), getenv('MA_DB_USER'), getenv('MA_DB_PASS'));
$pdo->exec('CREATE DATABASE IF NOT EXISTS ' . getenv('MA_DB_NAME'));
$pdo->exec('DROP DATABASE IF EXISTS ' . getenv('MA_DB_NAME') . '_test');
$pdo->exec('CREATE DATABASE ' . getenv('MA_DB_NAME') . '_test');
passthru('./vendor/bin/phinx migrate -c var/phinx/phinx.php -e development');
passthru('./vendor/bin/phinx migrate -c var/phinx/phinx.php -e test');
