<?php

namespace Dealroadshow\K8S\Framework\App;

use Dealroadshow\K8S\APIResourceInterface;
use Dealroadshow\K8S\Framework\Core\ManifestFile;
use Dealroadshow\K8S\Framework\Helper\Metadata\MetadataHelperInterface;
use Dealroadshow\K8S\Framework\Helper\Names\NamesHelperInterface;

abstract class AbstractApp implements AppInterface
{
    protected string $appEnv;
    protected MetadataHelperInterface $metadataHelper;
    protected NamesHelperInterface $namesHelper;
    protected array $files = [];

    public function __construct(MetadataHelperInterface $metadataHelper, NamesHelperInterface $namesHelper)
    {
        $metadataHelper->setApp($this);
        $namesHelper->setApp($this);

        $this->metadataHelper = $metadataHelper;
        $this->namesHelper = $namesHelper;
    }

    public function addManifestFile(string $fileNameWithoutExtension, APIResourceInterface $resource): void
    {
        if (array_key_exists($fileNameWithoutExtension, $this->files)) {
            throw new \LogicException(
                sprintf(
                    'Filename "%s" for app "%s" is already reserved by "%s" instance',
                    $fileNameWithoutExtension,
                    $this->name(),
                    get_class($this->files[$fileNameWithoutExtension])
                )
            );
        }
        $this->files[$fileNameWithoutExtension] = new ManifestFile($fileNameWithoutExtension, $resource);
    }

    public function env(): string
    {
        return $this->appEnv;
    }

    public function manifestFiles(): iterable
    {
        return $this->files;
    }

    public function metadataHelper(): MetadataHelperInterface
    {
        return $this->metadataHelper;
    }

    public function namesHelper(): NamesHelperInterface
    {
        return $this->namesHelper;
    }

    public function setEnv(string $env): void
    {
        $this->appEnv = $env;
    }
}
