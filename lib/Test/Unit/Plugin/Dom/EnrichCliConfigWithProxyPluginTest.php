<?php
declare(strict_types=1);

namespace RunAsRoot\CliConstructorArgAutoProxy\Test\Unit\Plugin\Dom;

use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use RunAsRoot\CliConstructorArgAutoProxy\Plugin\Dom\EnrichCliConfigWithProxyPlugin;
use RunAsRoot\CliConstructorArgAutoProxy\Preference\Framework\ObjectManager\Config\Reader\Dom\Interceptor;
use RunAsRoot\CliConstructorArgAutoProxy\Service\EnrichCliConfigWithProxyService;

final class EnrichCliConfigWithProxyPluginTest extends TestCase
{
    private EnrichCliConfigWithProxyService $service;
    private LoggerInterface $logger;
    private EnrichCliConfigWithProxyPlugin $sut;

    protected function setUp(): void
    {
        $this->service = $this->createMock(EnrichCliConfigWithProxyService::class);
        $this->logger = $this->createMock(LoggerInterface::class);
        $this->sut = new EnrichCliConfigWithProxyPlugin($this->service, $this->logger);
    }

    public function test_after_read(): void
    {
        $subject = $this->createMock(Interceptor::class);
        $result = ['foo' => 'bar'];
        $scope = 'global';

        $this->service->expects($this->once())->method('execute')->with($result)
            ->willReturn(['abc' => 'def']);
        $this->logger->expects($this->never())->method('error');

        $this->assertSame(['abc' => 'def'], $this->sut->afterRead($subject, $result, $scope));
    }

    public function test_after_read_with_non_global_scope(): void
    {
        $subject = $this->createMock(Interceptor::class);
        $result = ['foo' => 'bar'];
        $scope = 'foo';

        $this->service->expects($this->never())->method('execute');
        $this->logger->expects($this->never())->method('error');

        $this->assertSame($result, $this->sut->afterRead($subject, $result, $scope));
    }

    public function test_after_read_with_exception(): void
    {
        $subject = $this->createMock(Interceptor::class);
        $result = ['foo' => 'bar'];
        $scope = 'global';

        $this->service->expects($this->once())->method('execute')
            ->with($result)->willThrowException(new \ReflectionException('foo'));
        $this->logger->expects($this->once())->method('error');

        $this->assertSame($result, $this->sut->afterRead($subject, $result, $scope));
    }
}