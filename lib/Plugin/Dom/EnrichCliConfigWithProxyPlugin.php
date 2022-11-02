<?php
declare(strict_types=1);

namespace Vpodorozh\CliConstructorArgAutoProxy\Plugin\Dom;

use Psr\Log\LoggerInterface;
use ReflectionException;
use Vpodorozh\CliConstructorArgAutoProxy\Service\EnrichCliConfigWithProxyService;

class EnrichCliConfigWithProxyPlugin
{
    private EnrichCliConfigWithProxyService $enrichCliConfigWithProxyService;
    private LoggerInterface $logger;

    public function __construct(
        EnrichCliConfigWithProxyService $enrichCliConfigWithProxyService,
        LoggerInterface $logger
    ) {
        $this->enrichCliConfigWithProxyService = $enrichCliConfigWithProxyService;
        $this->logger = $logger;
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterRead($subject, array $result, ?string $scope): array
    {
        if ($scope !== 'global') {
            return $result;
        }

        try {
            return $this->enrichCliConfigWithProxyService->execute($result);
        } catch (ReflectionException $exception) {
            $this->logger->error((string) $exception);
            return $result;
        }
    }
}