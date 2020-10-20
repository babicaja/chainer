<?php

namespace Tests;

use Chainer\Exceptions\NotSupported;
use Chainer\Utils\LinkClosure;
use PHPUnit\Framework\TestCase;
use Tests\Stubs\PayloadLink;
use Tests\Stubs\ResponseLinkOne;
use Tests\Stubs\ResponseLinkTwo;
use Tests\Stubs\TestClass;

class LinkTest extends TestCase
{
    /**
     * @var ResponseLinkOne
     */
    private $linkOne;

    /**
     * @var ResponseLinkOne
     */
    private $linkTwo;

    protected function setUp(): void
    {
        parent::setUp();

        $this->linkOne = new ResponseLinkOne();
        $this->linkTwo = new ResponseLinkTwo();
    }

    /** @test **/
    public function it_can_run_its_own_logic_with_execute()
    {
        $this->assertArrayHasKey(ResponseLinkOne::class, $this->linkOne->handle([]));
    }

    /** @test **/
    public function it_can_chain_another_link_with_then()
    {
        $this->assertInstanceOf(ResponseLinkTwo::class, $this->linkOne->then($this->linkTwo));
    }

    /** @test **/
    public function the_link_in_the_chain_can_be_set_by_a_FQN()
    {
        $this->assertInstanceOf(ResponseLinkTwo::class, $this->linkOne->then(ResponseLinkTwo::class));
    }

    /** @test **/
    public function the_link_in_the_chain_can_be_a_closure()
    {
        $this->assertInstanceOf(LinkClosure::class, $this->linkOne->then(function () {
        }));
    }

    /** @test **/
    public function it_can_execute_all_the_links_in_the_chain_with_run()
    {
        $this->linkOne->then($this->linkTwo);
        $response = $this->linkOne->run([]);
        $this->assertArrayHasKey(ResponseLinkOne::class, $response);
        $this->assertArrayHasKey(ResponseLinkTwo::class, $response);
    }

    /** @test **/
    public function it_will_pass_the_payload_through_the_chained_links()
    {
        $payloadLink = new PayloadLink();
        $payloadLink->then(new PayloadLink())->then(new PayloadLink());
        $this->assertInstanceOf(TestClass::class, $payloadLink->run(new TestClass()));
    }

    /** @test **/
    public function it_will_throw_a_NotSupported_exception_if_the_argument_passed_to_then_is_not_supported()
    {
        $this->expectException(NotSupported::class);
        $this->linkOne->then([]);
    }
}
