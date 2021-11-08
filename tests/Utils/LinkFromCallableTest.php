<?php

namespace Tests\Utils;

use Chainer\Utils\LinkWrapper;
use Chainer\Utils\LinkFromCallable;
use PHPUnit\Framework\TestCase;
use Tests\Stubs\InvokableTestClass;
use Tests\Stubs\TestClass;

class LinkFromCallableTest extends TestCase
{
    /**
     * @test
     * @dataProvider callable
     */
    public function it_can_resolve_a_LinkClosure_from_a_proper_callable($case)
    {
        $this->assertInstanceOf(LinkWrapper::class, LinkFromCallable::resolve($case));
    }

    public function callable()
    {
        return [
            [[new TestClass(), "method"]],
            [[TestClass::class, "staticMethod"]],
            ["time"],
            [function () {
            }],
            [new InvokableTestClass()]
        ];
    }
}
