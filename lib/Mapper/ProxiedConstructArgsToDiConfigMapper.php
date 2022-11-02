<?php
declare(strict_types=1);

namespace Vpodorozh\CliConstructorArgAutoProxy\Mapper;

class ProxiedConstructArgsToDiConfigMapper
{
    public function map(array $diConfig, string $instanceClassName, array $proxiedConstructArgsConfig): array
    {
        $cliInstanceConfig = $diConfig[$instanceClassName] ?? [];
        $cliInstanceConfig['arguments'] = isset($cliInstanceConfig['arguments']) ?
            array_merge($cliInstanceConfig['arguments'], $proxiedConstructArgsConfig) : $proxiedConstructArgsConfig;

        $diConfig[$instanceClassName] = $cliInstanceConfig;

        return $diConfig;
    }
}