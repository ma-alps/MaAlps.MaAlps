<?php

declare(strict_types=1);

namespace MaAlps\MaAlps\Module;

use BEAR\Dotenv\Dotenv;
use BEAR\Package\AbstractAppModule;
use BEAR\Package\PackageModule;
use MaAlps\MaAlps\Asd\Diagram;
use MaAlps\MaAlps\Asd\DiagramInterface;
use MaAlps\MaAlps\Asd\Profile;
use MaAlps\MaAlps\Attribute\AlpsDir;
use Ray\AuraSqlModule\AuraSqlModule;
use Ray\IdentityValueModule\IdentityValueModule;
use Ray\MediaQuery\DbQueryConfig;
use Ray\MediaQuery\MediaQueryModule;
use Ray\MediaQuery\Queries;

use function dirname;
use function getenv;

class AppModule extends AbstractAppModule
{
    protected function configure(): void
    {
        (new Dotenv())->load(dirname(__DIR__, 2));
        $this->install(
            new AuraSqlModule(
                (string) getenv('MA_DB_DSN'),
                (string) getenv('MA_DB_USER'),
                (string) getenv('MA_DB_PASS'),
                (string) getenv('MA_DB_SLAVE')
            )
        );
        $this->install(
            new MediaQueryModule(
                Queries::fromDir($this->appMeta->appDir . '/src/Query'),
                [
                    new DbQueryConfig($this->appMeta->appDir . '/var/sql'),
                ]
            )
        );
        $this->install(new IdentityValueModule());
        $this->bind()->annotatedWith(AlpsDir::class)->toInstance($this->appMeta->appDir . '/var/alps');
        $this->bind(DiagramInterface::class)->to(Diagram::class);
        $this->bind(Profile::class);
        $this->install(new PackageModule());
    }
}
