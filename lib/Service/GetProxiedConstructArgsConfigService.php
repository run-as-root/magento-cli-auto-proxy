<?php
declare(strict_types=1);

namespace RunAsRoot\CliConstructorArgAutoProxy\Service;

use RunAsRoot\CliConstructorArgAutoProxy\Enum\ProxyClassEntityInterfaceEnum;
use RunAsRoot\CliConstructorArgAutoProxy\Validator\IsClassEligibleForProxyValidator;

class GetProxiedConstructArgsConfigService
{
    private IsClassEligibleForProxyValidator $proxyValidator;

    public function __construct(IsClassEligibleForProxyValidator $proxyValidator)
    {
        $this->proxyValidator = $proxyValidator;
    }

    public function get(array $constructConfig): array
    {
        $proxiedConstructorParams = [];

        foreach ($constructConfig as $constructorArgument) {
            list($paramName, $className) = $constructorArgument;

            try {
                $this->proxyValidator->validate($className);
            } catch (\Exception $exception) {
                continue;
            }

            $proxiedConstructorParams[$paramName] = [
                'instance' => $className . ProxyClassEntityInterfaceEnum::PROXY_CLASS_SUFFIX
            ];
        }

        return $proxiedConstructorParams;
    }
}