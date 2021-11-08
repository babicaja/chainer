<?php

namespace Tests\Utils;

use Chainer\Chain;
use Chainer\Utils\LinkResolver;
use Chainer\Utils\LinkWrapper;
use PHPUnit\Framework\TestCase;
use Tests\Stubs\InvokableTestClass;
use Tests\Stubs\PayloadLink;
use Tests\Stubs\TestClass;

class LinkResolverTest extends TestCase
{
    /**
     * @test
     * @dataProvider supported
     */
    public function it_will_resolve_a_Link_from_supported_types($case)
    {
        $this->assertInstanceOf(LinkWrapper::class, LinkResolver::resolve($case));
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
