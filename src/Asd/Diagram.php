<?php

declare(strict_types=1);

namespace MaAlps\MaAlps\Asd;

use Koriym\AppStateDiagram\DrawDiagram;
use Koriym\AppStateDiagram\LabelName;
use Koriym\AppStateDiagram\Profile;
use MaAlps\MaAlps\Exception\DiagramCreateFailedException;

use function file_put_contents;
use function passthru;
use function str_replace;

final class Diagram implements DiagramInterface
{
    public function draw(string $profileFilePath): Created
    {
        $dotFile = $profileFilePath . '.dot';
        $dot = (new DrawDiagram(new LabelName()))(new Profile($profileFilePath, new LabelName()));
        file_put_contents($dotFile, $dot);
        $svgFile = str_replace('.dot', '.svg', $dotFile);
        $cmd = "dot -Tsvg {$dotFile} -o {$svgFile}";
        passthru($cmd, $status);
        if ($status !== 0) {
            throw new DiagramCreateFailedException($profileFilePath);
        }

        return new Created($profileFilePath, $dotFile, $svgFile);
    }
}
