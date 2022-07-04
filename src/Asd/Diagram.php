<?php

declare(strict_types=1);

namespace MaAlps\MaAlps\Asd;

use Koriym\AppStateDiagram\DrawDiagram;
use Koriym\AppStateDiagram\LabelName;
use Koriym\AppStateDiagram\Profile;
use MaAlps\MaAlps\Exception\DiagramCreateFailedException;

use function file_put_contents;
use function passthru;

final class Diagram implements DiagramInterface
{
    public function draw(string $profileFilePath): Created
    {
        $created = Created::fromProfile($profileFilePath);
        $dot = (new DrawDiagram(new LabelName()))(new Profile($profileFilePath, new LabelName()));
        file_put_contents($created->dotFile, $dot);
        $cmd = "dot -Tsvg {$created->dotFile} -o {$created->svgFile}";
        passthru($cmd, $status);
        if ($status !== 0) {
            throw new DiagramCreateFailedException($profileFilePath, $cmd);
        }

        return $created;
    }
}
