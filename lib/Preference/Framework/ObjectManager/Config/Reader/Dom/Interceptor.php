<?php
declare(strict_types=1);

namespace RunAsRoot\CliConstructorArgAutoProxy\Preference\Framework\ObjectManager\Config\Reader\Dom;

use Magento\Framework\App\ObjectManager;
use Magento\Framework\ObjectManager\Config\Reader\Dom as OriginDom;
use RunAsRoot\CliConstructorArgAutoProxy\Plugin\Dom\EnrichCliConfigWithProxyPlugin;

class Interceptor extends OriginDom
{
    public function read($scope = null)
    {
        $result = parent::read($scope);

        return $this->runPlugin($result, $scope);
    }

    /**
     * Workaround for plugin execution.
     * You can not define plugin over Dom config reader, as it is created before Magento plugin functionality starts.
     */
    private function runPlugin(array $result, ?string $scope): array
    {
        /** @var EnrichCliConfigWithProxyPlugin $enrichPlugin */
        $enrichPlugin = ObjectManager::getInstance()->get(EnrichCliConfigWithProxyPlugin::class);
        return $enrichPlugin->afterRead($this, $result, $scope);
    }
}