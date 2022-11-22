<?php
declare(strict_types=1);

namespace RunAsRoot\CliConstructorArgAutoProxy\Test\Unit\Preference\Framework\ObjectManager\Config\Reader\Dom;

use Magento\Framework\App\ObjectManager;
use Magento\Framework\Config\FileResolverInterface;
use Magento\Framework\Config\ValidationStateInterface;
use Magento\Framework\ObjectManager\Config\Mapper\Dom;
use Magento\Framework\ObjectManager\Config\SchemaLocator;
use Monolog\Test\TestCase;
use RunAsRoot\CliConstructorArgAutoProxy\Plugin\Dom\EnrichCliConfigWithProxyPlugin;
use RunAsRoot\CliConstructorArgAutoProxy\Preference\Framework\ObjectManager\Config\Reader\Dom\Interceptor;

final class InterceptorTest extends TestCase
{
    private FileResolverInterface $fileResolver;
    private Interceptor $sut;

    protected function setUp(): void
    {
        $this->fileResolver = $this->createMock(FileResolverInterface::class);
        $converter = $this->createMock(Dom::class);
        $schemaLocator = $this->createMock(SchemaLocator::class);
        $validationState = $this->createMock(ValidationStateInterface::class);

        $this->sut = new Interceptor(
            $this->fileResolver,
            $converter,
            $schemaLocator,
            $validationState
        );
    }

    public function test_read(): void
    {
        $this->fileResolver->method('get')->willReturn([]);

        $pluginMock = $this->createMock(EnrichCliConfigWithProxyPlugin::class);
        $pluginRes = ['some' => 'result'];
        $pluginMock->method('afterRead')->willReturn($pluginRes);

        $objMock = $this->createMock(\Magento\Framework\ObjectManagerInterface::class);
        $objMock->method('get')->with(EnrichCliConfigWithProxyPlugin::class)
            ->willReturn($pluginMock);

        ObjectManager::setInstance($objMock);

        $this->assertEquals($pluginRes, $this->sut->read('global'));
    }
}