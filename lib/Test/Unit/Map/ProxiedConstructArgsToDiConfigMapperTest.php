<?php
declare(strict_types=1);

namespace RunAsRoot\CliConstructorArgAutoProxy\Test\Unit\Map;

use PHPUnit\Framework\TestCase;
use RunAsRoot\CliConstructorArgAutoProxy\Mapper\ProxiedConstructArgsToDiConfigMapper;

/**
 * Powered by GitHub Copilot
 */
final class ProxiedConstructArgsToDiConfigMapperTest extends TestCase
{
    private ProxiedConstructArgsToDiConfigMapper $sut;

    protected function setUp(): void
    {
        $this->sut = new ProxiedConstructArgsToDiConfigMapper();
    }

    /**
     * @dataProvider mapDataProvider
     */
    public function test_map(array $diConfig, string $instanceClassName, array $proxiedConstructArgsConfig, array $expected): void
    {
        $result = $this->sut->map($diConfig, $instanceClassName, $proxiedConstructArgsConfig);
        $this->assertEquals($expected, $result);
    }

    public function mapDataProvider(): array
    {
        return [
            'case1' => [
                'diConfig' => [
                    'instance1' => [
                        'arguments' => [
                            'arg1' => 'value1',
                            'arg2' => 'value2',
                        ],
                    ],
                ],
                'instanceClassName' => 'instance1',
                'proxiedConstructArgsConfig' => [
                    'arg3' => 'value3',
                    'arg4' => 'value4',
                ],
                'expected' => [
                    'instance1' => [
                        'arguments' => [
                            'arg1' => 'value1',
                            'arg2' => 'value2',
                            'arg3' => 'value3',
                            'arg4' => 'value4',
                        ],
                    ],
                ],
            ],
            'case2' => [
                'diConfig' => [
                    'instance1' => [],
                ],
                'instanceClassName' => 'instance1',
                'proxiedConstructArgsConfig' => [
                    'arg3' => 'value3',
                    'arg4' => 'value4',
                ],
                'expected' => [
                    'instance1' => [
                        'arguments' => [
                            'arg4' => 'value4',
                            'arg3' => 'value3',
                        ],
                    ],
                ]
            ],
            'case3' => [
                'diConfig' => [
                    'instance1' => [
                        'arguments' => [
                            'arg1' => 'value1',
                            'arg2' => 'value2',
                        ],
                    ],
                ],
                'instanceClassName' => 'instance1',
                'proxiedConstructArgsConfig' => [],
                'expected' => [
                    'instance1' => [
                        'arguments' => [
                            'arg1' => 'value1',
                            'arg2' => 'value2',
                        ],
                    ],
                ],
            ],
            'case4' => [
                'diConfig' => [
                    'instance1' => [],
                ],
                'instanceClassName' => 'instance1',
                'proxiedConstructArgsConfig' => [],
                'expected' => [
                    'instance1' => [
                        'arguments' => [],
                    ],
                ],
            ],

        ];
    }
}