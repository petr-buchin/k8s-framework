<?php

namespace Dealroadshow\K8S\Framework\Core\Container;

use Dealroadshow\K8S\Data\Collection\StringList;
use Dealroadshow\K8S\Data\Container;
use Dealroadshow\K8S\Framework\Core\Container\Env\EnvConfigurator;
use Dealroadshow\K8S\Framework\Core\Container\Image\Image;
use Dealroadshow\K8S\Framework\Core\Container\Image\ImagePullPolicy;
use Dealroadshow\K8S\Framework\Core\Container\Lifecycle\LifecycleConfigurator;
use Dealroadshow\K8S\Framework\Core\Container\Lifecycle\Probes\ProbesConfigurator;
use Dealroadshow\K8S\Framework\Core\Container\Ports\PortsConfigurator;
use Dealroadshow\K8S\Framework\Core\Container\Resources\ResourcesConfigurator;
use Dealroadshow\K8S\Framework\Core\Container\Security\SecurityContextConfigurator;
use Dealroadshow\K8S\Framework\Core\Container\VolumeMount\VolumeMountsConfigurator;

interface ContainerInterface
{
    public function name(): string;
    public function args(StringList $args): void;
    public function command(StringList $command): void;
    public function env(EnvConfigurator $env): void;
    public function volumeMounts(VolumeMountsConfigurator $mounts): void;
    public function resources(ResourcesConfigurator $resources): void;
    public function ports(PortsConfigurator $ports): void;
    public function lifecycle(LifecycleConfigurator $lifecycle): void;
    public function probes(ProbesConfigurator $probes): void;
    public function securityContext(SecurityContextConfigurator $context): void;
    public function image(): Image;
    public function imagePullPolicy(): ?ImagePullPolicy;
    public function workingDir(): ?string;
    public function configureContainer(Container $container): void;
}
