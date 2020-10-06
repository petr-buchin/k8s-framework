<?php

namespace Dealroadshow\K8S\Framework\ResourceMaker;

use Dealroadshow\K8S\API\Apps\Deployment;
use Dealroadshow\K8S\Framework\App\AppInterface;
use Dealroadshow\K8S\Framework\Core\Deployment\DeploymentInterface;
use Dealroadshow\K8S\Framework\Core\LabelSelector\LabelSelectorConfigurator;
use Dealroadshow\K8S\Framework\Core\ManifestInterface;
use Dealroadshow\K8S\Framework\Core\Pod\PodTemplateSpecProcessor;

class DeploymentMaker extends AbstractResourceMaker
{
    private PodTemplateSpecProcessor $specProcessor;

    public function __construct(PodTemplateSpecProcessor $specProcessor)
    {
        $this->specProcessor = $specProcessor;
    }

    /**
     * @param ManifestInterface|DeploymentInterface $manifest
     * @param AppInterface                          $app
     *
     * @return Deployment
     */
    public function makeResource(ManifestInterface $manifest, AppInterface $app): Deployment
    {
        $deployment = new Deployment();

        $labelSelector = new LabelSelectorConfigurator($deployment->spec()->selector());
        $manifest->labelSelector($labelSelector);

        $app->metadataHelper()->configureMeta($manifest, $deployment);
        $this->specProcessor->process($manifest, $deployment->spec()->template(), $app);

        foreach ($deployment->spec()->selector()->matchLabels()->all() as $name => $value) {
            $deployment->metadata()->labels()->add($name, $value);
            $deployment->spec()->template()->metadata()->labels()->add($name, $value);
        }

        return $deployment;
    }

    protected function supportsClass(): string
    {
        return DeploymentInterface::class;
    }
}
