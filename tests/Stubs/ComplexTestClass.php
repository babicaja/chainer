<?php

namespace Tests\Stubs;

class ComplexTestClass
{
    /**
     * @var TestClass
     */
    private $testClass;

    public function __construct(TestClass $testClass)
    {
        $this->testClass = $testClass;
    }
}
