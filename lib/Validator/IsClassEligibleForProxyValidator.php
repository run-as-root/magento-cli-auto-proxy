<?php
declare(strict_types=1);

namespace RunAsRoot\CliConstructorArgAutoProxy\Validator;

use RunAsRoot\CliConstructorArgAutoProxy\Enum\ProxyClassEntityInterfaceEnum;
use RunAsRoot\CliConstructorArgAutoProxy\Exception\ClassIsNotEligibleForProxyException;

class IsClassEligibleForProxyValidator
{
    /**
     * @throws ClassIsNotEligibleForProxyException
     */
    public function validate(?string $className): void
    {
        if ($className === '' || $className === null) {
            throw new ClassIsNotEligibleForProxyException('Class name is empty');
        }

        if (strpos($className, ProxyClassEntityInterfaceEnum::PROXY_CLASS_SUFFIX) > 0) {
            throw new ClassIsNotEligibleForProxyException('Class is already a Proxy');
        }

        // skipp - in case Proxy exists and is not a child of original class
        if (!is_a(
            $className . ProxyClassEntityInterfaceEnum::PROXY_CLASS_SUFFIX,
            $className,
            true
        )) {
            throw new ClassIsNotEligibleForProxyException(
                'Proxy already exists and is not a child of original class: ' . $className
            );
        }
    }
}