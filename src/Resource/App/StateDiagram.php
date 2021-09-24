<?php

declare(strict_types=1);

namespace MaAlps\MaAlps\Resource\App;

use BEAR\AppMeta\AbstractAppMeta;
use BEAR\Resource\ResourceObject;
use BEAR\Streamer\StreamTransferInject;
use JsonException;
use Koriym\AppStateDiagram\DrawDiagram;
use Koriym\AppStateDiagram\LabelName;
use Koriym\AppStateDiagram\Profile;
use Koriym\HttpConstants\StatusCode;
use Psr\Log\LoggerInterface;
use RuntimeException;

use function file_exists;
use function file_put_contents;
use function fopen;
use function fwrite;
use function is_resource;
use function json_encode;
use function passthru;
use function rewind;
use function simplexml_load_string;
use function stream_get_meta_data;
use function tmpfile;
use function unlink;

use const JSON_THROW_ON_ERROR;

class StateDiagram extends ResourceObject
{
    use StreamTransferInject;

    public $headers = ['Content-Type' => 'image/svg+xml'];

    public function __construct(
        private AbstractAppMeta $meta,
        private LoggerInterface $logger,
    ) {
    }

    /**
     * Finishing file streaming deletes the resource.
     */
    public function __destruct()
    {
        // Calling onGet sets resource to the property `body`, but may not other http methods.
        if (! isset($this->body) || ! is_resource($this->body)) {
            return;
        }

        $path = stream_get_meta_data($this->body)['uri'];
        if (unlink($path) !== false) {
            return;
        }

        $this->logger->error("failed to unlink. path: {$path}");
    }

    /**
     * @throws JsonException
     */
    public function onGet(string $profileFile): static
    {
        $profileJson = $this->sanitizeProfile(maybeXml: $profileFile);

        $this->body = $this->generateSvgWithDot(
            dot: $this->mapProfileJsonToDot($profileJson)
        );

        $this->code = StatusCode::CREATED;

        return $this;
    }

    /**
     * @throws JsonException
     */
    private function sanitizeProfile(string $maybeXml): string
    {
        /* todo うまくいかぬ
         * passthru でapp-state-diagramを呼び出す実装だと、不要なファイルが生成される(index.htmlなど)
         * この辺の回避をできるかなと思い、app-state-diagramの実装を直接呼ぶ実装を考えたが、いくつか問題が出た。
         * スキーマに外部リンクを含んでいるケースを考慮していなかったので、onGetの時点で文字列だけ受け取る実装にするには、外部スキーマをインライン化しておく必要がある
         * また、app-state-diagramの実装を直接呼び出す実装にするには、xmlからjsonに変換する部分の実装が必要（かも？app-state-diagram側に実装があれば呼び出せるかも）
         * */
        $xml = simplexml_load_string($maybeXml);
        if ($xml === false) {
            return $maybeXml; // regard it as json
        }

        return json_encode(value: xmlToArray($xml), flags: JSON_THROW_ON_ERROR);
    }

    private function mapProfileJsonToDot(string $profileJson): string
    {
        try {
            $fp = tmpfile();
            if ($fp === false) {
                throw new RuntimeException('failed to open tmp file');
            }

            if (fwrite($fp, $profileJson) === false) {
                throw new RuntimeException('failed to write profile to tmp file');
            }

            // fwrite put the position of file pointer to the tail of it.
            if (rewind($fp) === false) {
                throw new RuntimeException('failed to rewind fp');
            }

            $labelName = new LabelName();
            $tmpFilePath = stream_get_meta_data($fp)['uri'];

            return (new DrawDiagram(labelName: $labelName))(
                profile: new Profile(
                    alpsFile: $tmpFilePath,
                    labelName: $labelName,
                )
            );
        } finally {
            if (isset($tmpFilePath) && file_exists($tmpFilePath)) {
                unlink($tmpFilePath);
            }
        }
    }

    /**
     * @return resource
     */
    private function generateSvgWithDot(string $dot)
    {
        try {
            $dotFilePath = stream_get_meta_data(tmpfile())['uri'];
            $svgFilePath = stream_get_meta_data(tmpfile())['uri'];

            if (file_put_contents(filename: $dotFilePath, data: $dot) === false) {
                throw new RuntimeException('failed to write dot file');
            }

            $status = null;
            passthru("dot -Tsvg {$dotFilePath} -o {$svgFilePath}", $status);
            if ($status !== 0) {
                throw new RuntimeException('dot command result indicates error');
            }

            if (! file_exists($svgFilePath)) {
                throw new RuntimeException('failed to generate svg file');
            }

            $svgFp = fopen($svgFilePath, 'rb');
            if ($svgFp === false) {
                throw new RuntimeException('failed to open svg file');
            }

            return $svgFp;
        } finally {
            if (isset($dotFilePath) && file_exists($dotFilePath) && (unlink($dotFilePath) === false)) {
                $this->logger->error('failed to unlink. path: ' . $dotFilePath);
            }
        }
    }
}
