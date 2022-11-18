<?php
declare(strict_types=1);

namespace RunAsRoot\CliConstructorArgAutoProxy\Test\Unit;

use PHPUnit\Framework\TestCase;
use RunAsRoot\CliConstructorArgAutoProxy\Exception\ClassIsNotEligibleForProxyException;
use RunAsRoot\CliConstructorArgAutoProxy\Service\GetProxiedConstructArgsConfigService;
use RunAsRoot\CliConstructorArgAutoProxy\Validator\IsClassEligibleForProxyValidator;

/**
 * Powered by Github Copilot
 */
class GetProxiedConstructArgsConfigServiceTest extends TestCase
{
    private IsClassEligibleForProxyValidator $proxyValidator;
    private GetProxiedConstructArgsConfigService $sut;

    protected function setUp(): void
    {
        $this->proxyValidator = $this->createMock(IsClassEligibleForProxyValidator::class);
        $this->sut = new GetProxiedConstructArgsConfigService($this->proxyValidator);
    }

    public function testGet(): void
    {
        $constructConfig = [
            ['some', 'Some\Class'],
            ['someOther', 'Some\OtherClass'],
        ];

        $this->proxyValidator->expects($this->exactly(2))
            ->method('validate')
            ->withConsecutive(['Some\Class'], ['Some\OtherClass'])
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

    public function testGetWithNoEligibleClasses(): void
    {
        $constructConfig = [
            ['some', 'Some\Class'],
            ['someOther', 'Some\OtherClass'],
        ];

        $this->proxyValidator->expects($this->exactly(2))
            ->method('validate')
            ->withConsecutive(['Some\Class'], ['Some\OtherClass'])
            ->willThrowException(new ClassIsNotEligibleForProxyException());

        $this->assertEquals([], $this->sut->get($constructConfig));
    }

    public function testGetWithNoConstructConfig(): void
    {
        $this->assertEquals([], $this->sut->get([]));
    }
}