<?php

namespace Tests\Smorken\Sanitizer\Unit;

use Smorken\Sanitizer\Sanitize;

class MockSanitizer extends \Smorken\Sanitizer\Actors\Base
{

    protected function fake($value)
    {
        return 'bar';
    }

    protected function withParams($value, $param)
    {
        return $value.$param;
    }
}

class SanitizeTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @var Sanitize
     */
    protected $sut;

    public function setUp(): void
    {
        parent::setUp();
        $this->sut = new Sanitize($this->getOptions());
    }

    public function testCallUsesDefaultSanitizer()
    {
        $test = 'foo';
        $this->assertEquals($test, $this->sut->string($test));
    }

    public function testCallWithParams()
    {
        $test = 'foo';
        $param = 'bar';
        $this->assertEquals('foobar', $this->sut->with_params($test, 'mock', $param));
    }

    public function testCallWithSpecificSanitizer()
    {
        $test = 'foo';
        $this->assertEquals('bar', $this->sut->fake($test, 'mock'));
    }

    public function testDefaultMethodCallsWithSimpleString()
    {
        $test = 'foo';
        $this->assertEquals($test, $this->sut->get()
                                             ->sanitize('string', $test));
    }

    public function testExplicitMethodCallToAnotherSanitizer()
    {
        $test = 'foo';
        $this->assertEquals('bar', $this->sut->get('mock')
                                             ->sanitize('fake', $test));
    }

    public function testExplicitMethodCallsWithSimpleString()
    {
        $test = 'foo';
        $this->assertEquals($test, $this->sut->get('standard')
                                             ->sanitize('string', $test));
    }

    public function testExplicitWithParams()
    {
        $test = 'foo';
        $param = 'bar';
        $this->assertEquals('foobar', $this->sut->get('mock')
                                                ->sanitize('with_params', $test, $param));
    }

    public function testGetSanitizerWithInvalidTypeThrowsException()
    {
        $this->expectException('\Smorken\Sanitizer\SanitizerException');
        $this->sut->get('standard')
                  ->foo('bar');
    }

    public function testInvalidSanitizerThrowsException()
    {
        $this->expectException('\Smorken\Sanitizer\SanitizerException');
        $this->sut->get('foo');
    }

    public function testMagicGetCallsSanitizer()
    {
        $this->assertEquals('bar', $this->sut->fake('foobar'));
    }

    public function testSanitizeMethodWithAnotherSanitizer()
    {
        $test = 'foo';
        $this->assertEquals('bar', $this->sut->sanitize('fake', $test, 'mock'));
    }

    public function testSanitizeMethodWithDefault()
    {
        $test = 'foo';
        $this->assertEquals($test, $this->sut->sanitize('string', $test));
    }

    public function testSanitizeWithInvalidSanitizerThrowsException()
    {
        $this->expectException('\Smorken\Sanitizer\SanitizerException');
        $this->sut->sanitize('foo', 'bar');
    }

    protected function getOptions()
    {
        return [
            'default'    => 'standard',
            'sanitizers' => [
                'standard' => \Smorken\Sanitizer\Actors\Standard::class,
                'mock'     => MockSanitizer::class,
            ],
        ];
    }
}
