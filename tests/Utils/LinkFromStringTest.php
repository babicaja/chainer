<?php

namespace Tests\Utils;

use Chainer\Exceptions\NotCallable;
use Chainer\Exceptions\NotResolvable;
use Chainer\Utils\LinkWrapper;
use Chainer\Utils\LinkFromString;
use PHPUnit\Framework\TestCase;
use Tests\Stubs\ComplexTestClass;
use Tests\Stubs\InvokableTestClass;
use Tests\Stubs\PayloadLink;
use Tests\Stubs\TestClass;

class LinkFromStringTest extends TestCase
{
    /**
     * @test
     * @dataProvider notResolvable
     */
    public function it_will_throw_a_NotResolvable_exception_if_the_passed_argument_is_not_a_resolvable_string($case)
    {
        $this->expectException(NotResolvable::class);
        LinkFromString::resolve($case);
    }

    public function notResolvable()
    {
        return [
            ["not-resolvable"],
            [ComplexTestClass::class]
        ];
    }

    /** @test */
    public function it_will_throw_a_NotCallable_exception_if_the_resolved_class_from_string_is_not_callable()
    {
        $this->expectException(NotCallable::class);
        LinkFromString::resolve(TestClass::class);
    }

    /** @test * */
    public function it_will_resolve_a_LinkClosure_from_a_string_which_resolves_to_an_invokable_class()
    {
        $this->assertInstanceOf(LinkWrapper::class, LinkFromString::resolve(InvokableTestClass::class));
    }
}
