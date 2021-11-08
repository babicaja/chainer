<?php

namespace Tests\Utils;

use Chainer\Chain;
use Chainer\Utils\LinkWrapper;
use Composer\Package\Link;
use PHPUnit\Framework\TestCase;
use Tests\Stubs\InvokableTestClass;
use Tests\Stubs\PayloadLink;
use Tests\Stubs\ResponseLinkOne;
use Tests\Stubs\ResponseLinkTwo;
use Tests\Stubs\TestClass;

class LinkWrapperTest extends TestCase
{
    private LinkWrapper $wrappedResponseLink;
    private LinkWrapper $wrappedPayloadLink;
    private ResponseLinkTwo $responseLink;
    private PayloadLink $payloadLink;

    protected function setUp(): void
    {
        parent::setUp();

        $this->wrappedResponseLink = new LinkWrapper(new ResponseLinkOne());
        $this->wrappedPayloadLink = new LinkWrapper(new PayloadLink());
        $this->responseLink = new ResponseLinkTwo();
        $this->payloadLink = new PayloadLink();
    }

    /** @test **/
    public function it_can_run_its_own_logic_with_handle()
    {
        $this->assertArrayHasKey(ResponseLinkOne::class, $this->wrappedResponseLink->handle([]));
    }

    /** @test **/
    public function it_can_chain_another_link_with_then()
    {
        $this->assertInstanceOf(LinkWrapper::class, $this->wrappedResponseLink->then($this->responseLink));
    }

    /** @test **/
    public function the_link_in_the_chain_can_be_set_by_a_FQN()
    {
        $this->assertInstanceOf(LinkWrapper::class, $this->wrappedResponseLink->then(ResponseLinkTwo::class));
    }

    /** @test **/
    public function the_link_in_the_chain_can_be_a_closure()
    {
        $this->assertInstanceOf(LinkWrapper::class, $this->wrappedResponseLink->then(function () {
        }));
    }

    /** @test **/
    public function it_can_execute_all_the_links_in_the_chain_with_run()
    {
        $this->wrappedResponseLink->then($this->responseLink);
        $response = $this->wrappedResponseLink->run([]);
        $this->assertArrayHasKey(ResponseLinkOne::class, $response);
        $this->assertArrayHasKey(ResponseLinkTwo::class, $response);
    }

    /** @test **/
    public function it_will_pass_the_payload_through_the_chained_links()
    {
        $this->wrappedPayloadLink->then($this->payloadLink);
        $this->assertInstanceOf(TestClass::class, $this->wrappedPayloadLink->run(new TestClass()));
    }

    /**
     * @test
     * @dataProvider callable
     */
    public function it_can_execute_the_callable_logic($callable)
    {
        $linkClosure = new LinkWrapper($callable);
        $this->assertEquals(null, $linkClosure->handle());
    }

    public function callable()
    {
        return [
            [[new TestClass(), "method"]],
            [[TestClass::class, "staticMethod"]],
            [function () {
            }],
            [new InvokableTestClass()],
            [Chain::do(function () {
            })]
        ];
    }
}
