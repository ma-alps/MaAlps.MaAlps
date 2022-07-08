<?php

declare(strict_types=1);

namespace MaAlps\MaAlps\Asd;

use MaAlps\MaAlps\Attribute\AlpsDir;

use function str_replace;

final class HttpLinkFactory implements HttpLinkFactoryInterface
{
    public function __construct(
        #[AlpsDir] private readonly string $alpsDir,
        private readonly string $host = 'http://localhost:8080'
    ) {
    }

    public function __invoke(Created $created): AlpsLink
    {
        $url = fn ($path) => str_replace($this->alpsDir, $this->host, $path);

        return new AlpsLink(
            $url($created->profileFile),
            $url($created->dotFile),
            $url($created->svgFile)
        );
    }
}
