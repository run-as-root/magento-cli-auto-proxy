<?php
declare(strict_types=1);

namespace RunAsRoot\CliConstructorArgAutoProxy\Test\Unit;

use Magento\Framework\Code\Reader\ClassReaderInterface;
use PHPUnit\Framework\TestCase;
use RunAsRoot\CliConstructorArgAutoProxy\Mapper\ProxiedConstructArgsToDiConfigMapper;
use RunAsRoot\CliConstructorArgAutoProxy\Service\EnrichCliConfigWithProxyService;
use RunAsRoot\CliConstructorArgAutoProxy\Service\GetProxiedConstructArgsConfigService;

/**
 * Powered by Github Copilot
 */
class EnrichCliConfigWithProxyServiceTest extends TestCase
{
    private ClassReaderInterface $classReader;
    private GetProxiedConstructArgsConfigService $argsConfigService;
    private ProxiedConstructArgsToDiConfigMapper $diConfigMapper;
    private EnrichCliConfigWithProxyService $sut;

    protected function setUp(): void
    {
        $this->classReader = $this->createMock(ClassReaderInterface::class);
        $this->argsConfigService = $this->createMock(GetProxiedConstructArgsConfigService::class);
        $this->diConfigMapper = $this->createMock(ProxiedConstructArgsToDiConfigMapper::class);
        $this->sut = new EnrichCliConfigWithProxyService(
            $this->argsConfigService,
            $this->classReader,
            $this->diConfigMapper
        );
    }

    public function testExecute(): void
    {
        $diConfig = [
            'some' => 'config',
        ];

        $this->assertEquals($diConfig, $this->sut->execute($diConfig));
    }

    public function testExecuteWithCliCommands(): void
    {
        $diConfig = [
            'some' => 'config',
            'Magento\Framework\Console\CommandListInterface' => [
                'arguments' => [
                    'commands' => [
                        [
                            'instance' => 'Some\CliCommand',
                        ],
                    ],
                ],
            ],
        ];

        $this->classReader->expects($this->once())
            ->method('getConstructor')
            ->with('Some\CliCommand')
            ->willReturn([]);

        $this->argsConfigService->expects($this->once())
            ->method('get')
            ->with([])
            ->willReturn([]);

        $this->diConfigMapper->expects($this->once())
            ->method('map')
            ->with($diConfig, 'Some\CliCommand', [])
            ->willReturn($diConfig);

        $this->assertEquals($diConfig, $this->sut->execute($diConfig));
    }

    public function testExecuteWithCliCommandsAndNoConstruct(): void
    {
        $diConfig = [
            'some' => 'config',
            'Magento\Framework\Console\CommandListInterface' => [
                'arguments' => [
                    'commands' => [
                        [
                            'instance' => 'Some\CliCommand',
                        ],
                    ],
                ],
            ],
        ];

        $this->classReader->expects($this->once())
            ->method('getConstructor')
            ->with('Some\CliCommand')
            ->willReturn(null);

        $this->argsConfigService->expects($this->never())
            ->method('get');

        $this->diConfigMapper->expects($this->never())
            ->method('map');

        $this->assertEquals($diConfig, $this->sut->execute($diConfig));
    }

    public function testExecuteWithCliCommandsAndNoInstance(): void
    {
        $diConfig = [
            'some' => 'config',
            'Magento\Framework\Console\CommandListInterface' => [
                'arguments' => [
                    'commands' => [
                        [
                            'some' => 'config',
                        ],
                    ],
                ],
            ],
        ];

        $this->classReader->expects($this->never())
            ->method('getConstructor');

        $this->argsConfigService->expects($this->never())
            ->method('get');

        $this->diConfigMapper->expects($this->never())
            ->method('map');

        $this->assertEquals($diConfig, $this->sut->execute($diConfig));
    }

    public function testExecuteWithCliCommandsAndNoCommands(): void
    {
        $diConfig = [
            'some' => 'config',
            'Magento\Framework\Console\CommandListInterface' => [
                'arguments' => [
                    'some' => 'config',
                ],
            ],
        ];

        $this->classReader->expects($this->never())
            ->method('getConstructor');

        $this->argsConfigService->expects($this->never())
            ->method('get');

        $this->diConfigMapper->expects($this->never())
            ->method('map');

        $this->assertEquals($diConfig, $this->sut->execute($diConfig));
    }

    public function testExecuteWithCliCommandsAndNoArguments(): void
    {
        $diConfig = [
            'some' => 'config',
            'Magento\Framework\Console\CommandListInterface' => [
                'some' => 'config',
            ],
        ];

        $this->classReader->expects($this->never())
            ->method('getConstructor');

        $this->argsConfigService->expects($this->never())
            ->method('get');

        $this->diConfigMapper->expects($this->never())
            ->method('map');

        $this->assertEquals($diConfig, $this->sut->execute($diConfig));
    }

    public function testExecuteWithCliCommandsAndNoCommandListInterface(): void
    {
        $diConfig = [
            'some' => 'config',
        ];

        $this->classReader->expects($this->never())
            ->method('getConstructor');

        $this->argsConfigService->expects($this->never())
            ->method('get');

        $this->diConfigMapper->expects($this->never())
            ->method('map');

        $this->assertEquals($diConfig, $this->sut->execute($diConfig));
    }

    public function testExecuteWithCliCommandsAndNoArgumentsKey(): void
    {
        $diConfig = [
            'some' => 'config',
            'Magento\Framework\Console\CommandListInterface' => [
                'some' => 'config',
            ],
        ];

        $this->classReader->expects($this->never())
            ->method('getConstructor');

        $this->argsConfigService->expects($this->never())
            ->method('get');

        $this->diConfigMapper->expects($this->never())
            ->method('map');

        $this->assertEquals($diConfig, $this->sut->execute($diConfig));
    }

    public function testExecuteWithCliCommandsAndNoCommandsKey(): void
    {
        $diConfig = [
            'some' => 'config',
            'Magento\Framework\Console\CommandListInterface' => [
                'arguments' => [
                    'some' => 'config',
                ],
            ],
        ];

        $this->classReader->expects($this->never())
            ->method('getConstructor');

        $this->argsConfigService->expects($this->never())
            ->method('get');

        $this->diConfigMapper->expects($this->never())
            ->method('map');

        $this->assertEquals($diConfig, $this->sut->execute($diConfig));
    }

    public function testExecuteWithCliCommandsAndNoInstanceKey(): void
    {
        $diConfig = [
            'some' => 'config',
            'Magento\Framework\Console\CommandListInterface' => [
                'arguments' => [
                    'commands' => [
                        [
                            'some' => 'config',
                        ],
                    ],
                ],
            ],
        ];

        $this->classReader->expects($this->never())
            ->method('getConstructor');

        $this->argsConfigService->expects($this->never())
            ->method('get');

        $this->diConfigMapper->expects($this->never())
            ->method('map');

        $this->assertEquals($diConfig, $this->sut->execute($diConfig));
    }
}