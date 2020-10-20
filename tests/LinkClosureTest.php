<?php

namespace Tests;

use Chainer\Utils\LinkClosure;
use PHPUnit\Framework\TestCase;
use Tests\Stubs\InvokableTestClass;
use Tests\Stubs\TestClass;

class LinkClosureTest extends TestCase
{
    /**
     * @test
     * @dataProvider callable
     */
    public function it_can_execute_the_callable_logic($callable)
    {
        $linkClosure = new LinkClosure($callable);
        $this->assertEquals(null, $linkClosure->handle());
    }

    public function callable()
    {
        return [
            [[new TestClass(), "method"]],
            [[TestClass::class, "staticMethod"]],
            [function () {
            }],
            [new InvokableTestClass()]
        ];
    }
}
