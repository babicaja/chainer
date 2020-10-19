<?php

namespace Tests\Helpers;

use Chainer\Exceptions\NotCallable;
use Chainer\Utils\LinkFromCallable;
use Chainer\Utils\LinkClosure;
use PHPUnit\Framework\TestCase;
use Tests\Stubs\InvokableTestClass;
use Tests\Stubs\TestClass;

class LinkFromCallableTest extends TestCase
{
    /**
     * @test
     * @param $case
     * @throws NotCallable
     * @dataProvider notCallable
     */
    public function it_will_throw_a_not_callable_exception_if_the_passed_argument_is_not_callable($case)
    {
        $this->expectException(NotCallable::class);
        LinkFromCallable::resolve($case);
    }

    public function notCallable()
    {
        return [
            ["not-a-callable"],
            [["not-a-callable"]]
        ];
    }

    /**
     * @test
     * @param $case
     * @throws NotCallable
     * @dataProvider callable
     */
    public function it_can_resolve_a_LinkClosure_from_a_proper_callable($case)
    {
        $this->assertInstanceOf(LinkClosure::class, LinkFromCallable::resolve($case));
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
