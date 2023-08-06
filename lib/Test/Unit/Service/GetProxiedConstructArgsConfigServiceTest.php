<?php
declare(strict_types=1);

namespace RunAsRoot\CliConstructorArgAutoProxy\Test\Unit;

use PHPUnit\Framework\TestCase;
use RunAsRoot\CliConstructorArgAutoProxy\Exception\ClassIsNotEligibleForProxyException;
use RunAsRoot\CliConstructorArgAutoProxy\Service\GetProxiedConstructArgsConfigService;
use RunAsRoot\CliConstructorArgAutoProxy\Validator\IsClassEligibleForProxyValidator;

/**
 * Powered by GitHub Copilot
 */
final class GetProxiedConstructArgsConfigServiceTest extends TestCase
{
    private IsClassEligibleForProxyValidator $proxyValidator;
    private GetProxiedConstructArgsConfigService $sut;

    protected function setUp(): void
    {
        $this->proxyValidator = $this->createMock(IsClassEligibleForProxyValidator::class);
        $this->sut = new GetProxiedConstructArgsConfigService($this->proxyValidator);
    }

    public function test_get(): void
    {
        $constructConfig = [
            ['some', 'Some\Class'],
            ['someOther', 'Some\OtherClass'],
        ];

        $this->proxyValidator->expects($this->exactly(2))
            ->method('validate')
            ->willReturnCallback(function () use (&$i) {
                switch ($i) {
                    case 0:
                        return ['Some\Class'];
                    case 1:
                        return ['Some\OtherClass'];
                }
                $i++;

                return [];
            })
            ->willReturnOnConsecutiveCalls(true, false);

        $this->assertEquals(
            [
                'some' => [
                    'instance' => 'Some\Class\Proxy',
                ],
                'someOther' => [
                    'instance' => 'Some\OtherClass\Proxy',
                ],
            ],
            $this->sut->get($constructConfig)
        );
    }

    public function test_get_with_no_eligible_classes(): void
    {
        $constructConfig = [
            ['some', 'Some\Class'],
            ['someOther', 'Some\OtherClass'],
        ];

        $this->proxyValidator->expects($this->exactly(2))
            ->method('validate')
            ->willReturnCallback(function () use (&$i) {
                switch ($i) {
                    case 0:
                        return ['Some\Class'];
                    case 1:
                        return ['Some\OtherClass'];
                }
                $i++;

                return [];
            })
            ->willThrowException(new ClassIsNotEligibleForProxyException());

        $this->assertEquals([], $this->sut->get($constructConfig));
    }

    public function testGetWithNoConstructConfig(): void
    {
        $this->assertEquals([], $this->sut->get([]));
    }
}
