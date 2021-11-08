<?php

namespace Tests\Utils;

use Chainer\Chain;
use Chainer\Utils\LinkWrapper;
use Chainer\Utils\LinkFromChain;
use PHPUnit\Framework\TestCase;

class LinkFromChainTest extends TestCase
{
    /**
     * @test
     * @dataProvider chainInstance
     */
    public function it_can_resolve_a_Link_from_a_Link_instance($case)
    {
        $this->assertInstanceOf(LinkWrapper::class, LinkFromChain::resolve($case));
    }

    public function chainInstance()
    {
        return [
            [Chain::do(function () {
            })],
            [new Chain(function () {
            })],
        ];
    }
}
