<?php

declare(strict_types=1);

namespace MaAlps\MaAlps\Alps;

use Koriym\AppStateDiagram\DrawDiagram;
use Koriym\AppStateDiagram\LabelName;
use Koriym\AppStateDiagram\Profile;
use MaAlps\MaAlps\Attribute\AlpsDir;

use function file_put_contents;
use function passthru;
use function sprintf;
use function str_replace;

final class Diagram implements DiagramInterface
{
    public function __construct(
        #[AlpsDir] private readonly string $alpsDir
    ) {
    }

    public function __invoke(string $profile, string $id): Created
    {
        $dotFile = sprintf('%s/alps.%s.dot', $this->alpsDir, $id);
        $dot = (new DrawDiagram(new LabelName()))(new Profile($profile, new LabelName()));
        file_put_contents($dotFile, $dot);
        $svgFile = str_replace('.dot', '.svg', $dotFile);
        $cmd = "dot -Tsvg {$dotFile} -o {$svgFile}";
        passthru($cmd, $status);

        return new Created($status === 0, $svgFile);
    }
}
