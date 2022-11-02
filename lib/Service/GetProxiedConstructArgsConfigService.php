<?php
declare(strict_types=1);

namespace Vpodorozh\CliConstructorArgAutoProxy\Service;

use Vpodorozh\CliConstructorArgAutoProxy\Enum\ProxyClassEntityInterfaceEnum;
use Vpodorozh\CliConstructorArgAutoProxy\Validator\IsClassEligibleForProxyValidator;

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