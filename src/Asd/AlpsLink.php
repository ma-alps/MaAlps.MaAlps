<?php

declare(strict_types=1);

namespace MaAlps\MaAlps\Asd;

use JetBrains\PhpStorm\Immutable;
use Stringable;

use function sprintf;

#[Immutable]
final class AlpsLink implements Stringable
{
    /**
     * @see https://developer.mozilla.org/ja/docs/Web/HTTP/Headers/Link
     */
    private const LINK_TEMPLATE = '<%s>; rel="alps_profile", <%s>; rel="alps_dot", <%s>; rel="alps_svg"';

    public function __construct(
        private readonly string $profileFile,
        private readonly string $dotFile,
        private readonly string $svgFile,
    ) {
    }

    public function __toString(): string
    {
        return sprintf(
            self::LINK_TEMPLATE,
            $this->profileFile,
            $this->dotFile,
            $this->svgFile
        );
    }
}
