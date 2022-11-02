<?php
declare(strict_types=1);

namespace Vpodorozh\CliConstructorArgAutoProxy\Service;

use Magento\Framework\Code\Reader\ClassReaderInterface;
use Magento\Framework\Console\CommandListInterface;
use ReflectionException;
use Vpodorozh\CliConstructorArgAutoProxy\Mapper\ProxiedConstructArgsToDiConfigMapper;

class EnrichCliConfigWithProxyService
{
    private ClassReaderInterface $classReader;
    private GetProxiedConstructArgsConfigService $argsConfigService;
    private ProxiedConstructArgsToDiConfigMapper $diConfigMapper;

    public function __construct(
        GetProxiedConstructArgsConfigService $argsConfigService,
        ClassReaderInterface $classReader,
        ProxiedConstructArgsToDiConfigMapper $diConfigMapper
    ) {
        $this->classReader = $classReader;
        $this->argsConfigService = $argsConfigService;
        $this->diConfigMapper = $diConfigMapper;
    }

    /**
     * @throws ReflectionException
     */
    public function execute(array $diConfig): array
    {
        $cliCommandsList = $diConfig[CommandListInterface::class]['arguments']['commands'] ?? null;

        if ($cliCommandsList === null) {
            return $diConfig;
        }

        foreach ($cliCommandsList as $cliCommandConfig) {

            $cliInstanceClassName = $cliCommandConfig['instance'] ?? null;
            if ($cliInstanceClassName === null) {
                continue;
            }

            $constructConfig = $this->classReader->getConstructor($cliInstanceClassName);
            if ($constructConfig === null) {
                continue;
            }

            $proxiedConstructArgsConfig = $this->argsConfigService->get($constructConfig);
            $diConfig = $this->diConfigMapper->map($diConfig, $cliInstanceClassName, $proxiedConstructArgsConfig);
        }

        return $diConfig;
    }
}