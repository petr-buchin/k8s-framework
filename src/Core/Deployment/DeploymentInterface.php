<?php

namespace Dealroadshow\K8S\Framework\Core\Deployment;

use Dealroadshow\K8S\Framework\Core\LabelSelector\LabelSelectorConfigurator;
use Dealroadshow\K8S\Framework\Core\ManifestInterface;
use Dealroadshow\K8S\Framework\Core\Pod\PodTemplateSpecInterface;

interface DeploymentInterface extends PodTemplateSpecInterface, ManifestInterface
{
    public function labelSelector(LabelSelectorConfigurator $selector): void;
}
