<?php

declare(strict_types=1);

namespace MaAlps\MaAlps\Module;

use BEAR\Dotenv\Dotenv;
use BEAR\Package\AbstractAppModule;
use MaAlps\MaAlps\Auth\FakeUserIdVerifier;
use MaAlps\MaAlps\Auth\UserIdVerifierInterface;
use Ray\AuraSqlModule\AuraSqlModule;

use function dirname;
use function getenv;

class TestModule extends AbstractAppModule
{
    protected function configure(): void
    {
        (new Dotenv())->load(dirname(__DIR__, 2));
        $this->install(
            new AuraSqlModule(
                (string) getenv('MA_DB_DSN') . '_test',
                (string) getenv('MA_DB_USER'),
                (string) getenv('MA_DB_PASS'),
                (string) getenv('MA_DB_SLAVE')
            )
        );
        $this->bind(UserIdVerifierInterface::class)->to(FakeUserIdVerifier::class);
    }
}
