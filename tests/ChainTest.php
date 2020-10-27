<?php

namespace Tests;

use BadMethodCallException;
use Chainer\Chain;
use PHPUnit\Framework\TestCase;
use ReflectionProperty;
use Tests\Stubs\InvokableTestClass;
use Tests\Stubs\PayloadLink;
use Tests\Stubs\ResponseLinkOne;
use Tests\Stubs\ResponseLinkTwo;
use Tests\Stubs\TestClass;

class ChainTest extends TestCase
{
    /** @test **/
    public function it_can_be_instantiated_with_a_Link()
    {
        $this->assertInstanceOf(Chain::class, new Chain(new PayloadLink()));
    }

    /**
     * @test
     * @dataProvider callable
     */
    public function it_can_be_instantiated_with_a_valid_callable($callable)
    {
        $this->assertInstanceOf(Chain::class, new Chain($callable));
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

    /** @test **/
    public function it_can_be_instantiated_statically_with_do()
    {
        $this->assertInstanceOf(Chain::class, Chain::do(PayloadLink::class));
    }

    /** @test **/
    public function it_will_throw_a_BadMethodCallException_if_a_static_call_is_something_other_then_do()
    {
        $this->expectException(BadMethodCallException::class);
        Chain::somethingOther();
    }

    /** @test **/
    public function it_can_chain_links_with_then()
    {
        $chain = Chain::do(ResponseLinkOne::class)->then(ResponseLinkTwo::class);
        $this->assertInstanceOf(Chain::class, $chain);

        $first = new ReflectionProperty(Chain::class, 'first');
        $current = new ReflectionProperty(Chain::class, 'current');

        $first->setAccessible(true);
        $current->setAccessible(true);

        $this->assertInstanceOf(ResponseLinkOne::class, $first->getValue($chain));
        $this->assertInstanceOf(ResponseLinkTwo::class, $current->getValue($chain));
    }

    /** @test * */
    public function it_can_execute_all_the_links_in_the_chain_with_run()
    {
        $response = Chain::do(ResponseLinkOne::class)->then(ResponseLinkTwo::class)->run();
        $this->assertArrayHasKey(ResponseLinkOne::class, $response);
        $this->assertArrayHasKey(ResponseLinkTwo::class, $response);
    }

    /** @test * */
    public function it_can_be_invoked_which_will_execute_all_the_links_in_the_chain()
    {
        $response = Chain::do(ResponseLinkOne::class)->then(ResponseLinkTwo::class)();
        $this->assertArrayHasKey(ResponseLinkOne::class, $response);
        $this->assertArrayHasKey(ResponseLinkTwo::class, $response);
    }
}
