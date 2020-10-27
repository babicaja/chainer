<?php

namespace Tests\Utils;

use Chainer\Chain;
use Chainer\Exceptions\NotSupported;
use Chainer\Link;
use Chainer\Utils\LinkResolver;
use PHPUnit\Framework\TestCase;
use Tests\Stubs\InvokableTestClass;
use Tests\Stubs\PayloadLink;
use Tests\Stubs\TestClass;

class LinkResolverTest extends TestCase
{
    /**
     * @test
     * @dataProvider notSupported
     */
    public function it_will_throw_the_NotSupprted_exception_if_the_type_is_not_supported($case)
    {
        $this->expectException(NotSupported::class);
        LinkResolver::resolve($case);
    }

    public function notSupported()
    {
        return [
            [new TestClass()],
            [[]],
            [['content']],
            [null],
            [1],
            [true]
        ];
    }

    /**
     * @test
     * @dataProvider supported
     */
    public function it_will_resolve_a_Link_from_supported_types($case)
    {
        $this->assertInstanceOf(Link::class, LinkResolver::resolve($case));
    }

    public function supported()
    {
        return [
            [PayloadLink::class],
            [new PayloadLink()],
            [function () {
            }],
            [fn () => true ],
            [InvokableTestClass::class],
            [new InvokableTestClass()],
            [Chain::do(fn()=>true)],
            [[TestClass::class, 'staticMethod']],
            [[new TestClass(), 'method']]
        ];
    }
}
