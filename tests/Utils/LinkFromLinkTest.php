<?php

namespace Tests\Utils;

use Chainer\Link;
use Chainer\Utils\LinkFromLink;
use PHPUnit\Framework\TestCase;
use Tests\Stubs\ResponseLinkOne;
use Tests\Stubs\ResponseLinkTwo;

class LinkFromLinkTest extends TestCase
{
    /**
     * @test
     * @dataProvider linkInstance
     */
    public function it_can_resolve_a_Link_from_a_Link_instance($case)
    {
        $this->assertInstanceOf(Link::class, LinkFromLink::resolve($case));
    }

    public function linkInstance()
    {
        return [
            [new ResponseLinkOne()],
            [new ResponseLinkTwo()],
        ];
    }
}
