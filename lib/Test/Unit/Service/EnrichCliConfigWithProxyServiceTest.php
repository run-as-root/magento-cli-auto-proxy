<?php
declare(strict_types=1);

namespace RunAsRoot\CliConstructorArgAutoProxy\Test\Unit;

use Magento\Framework\Code\Reader\ClassReaderInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use RunAsRoot\CliConstructorArgAutoProxy\Mapper\ProxiedConstructArgsToDiConfigMapper;
use RunAsRoot\CliConstructorArgAutoProxy\Service\EnrichCliConfigWithProxyService;
use RunAsRoot\CliConstructorArgAutoProxy\Service\GetProxiedConstructArgsConfigService;

/**
 * Powered by GitHub Copilot
 */
final class EnrichCliConfigWithProxyServiceTest extends TestCase
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

    public function test_execute(): void
    {
        $diConfig = [
            'some' => 'config',
        ];

        $this->assertEquals($diConfig, $this->sut->execute($diConfig));
    }

    public function test_execute_with_cli_commands(): void
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

    public function test_execute_with_cli_commands_and_no_construct(): void
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

    public function test_execute_with_cli_commands_and_no_instance(): void
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

    public function test_execute_with_cli_commands_and_no_commands(): void
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

    public function test_execute_with_cli_commands_and_no_arguments(): void
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

    public function test_execute_with_cli_commands_and_no_command_list_interface(): void
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

    public function test_execute_with_cli_commands_and_no_arguments_key(): void
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

    public function test_execute_with_cli_commands_and_no_commands_key(): void
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

    public function test_execute_with_cli_commands_and_no_instance_key(): void
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