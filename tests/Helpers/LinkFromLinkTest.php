<?php

namespace Tests\Helpers;

use Chainer\Exceptions\NotLinkInstance;
use Chainer\Link;
use Chainer\Utils\LinkFromLink;
use PHPUnit\Framework\TestCase;
use Tests\Stubs\ResponseLinkOne;
use Tests\Stubs\ResponseLinkTwo;
use Tests\Stubs\TestClass;

class LinkFromLinkTest extends TestCase
{
    /**
     * @test
     * @param $case
     * @throws NotLinkInstance
     * @dataProvider notLinkInstance
     */
    public function it_will_throw_a_NotLinkInstance_exception_if_the_passed_argument_is_not_a_Link($case)
    {
        $this->expectException(NotLinkInstance::class);
        LinkFromLink::resolve($case);
    }

    public function notLinkInstance()
    {
        return [
            ["not-a-link"],
            [["not-a-link"]],
            [new TestClass()]
        ];
    }

    /**
     * @test
     * @param $case
     * @throws NotLinkInstance
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
