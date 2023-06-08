<?php

namespace Tests\Smorken\Sanitizer\Unit;

class StandardSanitizerTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @var \Smorken\Sanitizer\Actors\Standard
     */
    protected $sut;

    public function setUp(): void
    {
        parent::setUp();
        $this->sut = new \Smorken\Sanitizer\Actors\Standard();
    }

    public function testAlphaNumDashSpaceStripsInvalidChars()
    {
        $test = '_f42f- <script>';
        $this->assertEquals('_f42f- script', $this->sut->sanitize('alphaNumDashSpace', $test));
    }

    public function testAlphaNumDashesStripsInvalidChars()
    {
        $test = '_f42f-<script>';
        $this->assertEquals('_f42f-script', $this->sut->sanitize('alphaNumDash', $test));
    }

    public function testAlphaNumStripsInvalidChars()
    {
        $test = '_f42f<script>';
        $this->assertEquals('f42fscript', $this->sut->sanitize('alphaNum', $test));
    }

    public function testAlphaStripsInvalidChars()
    {
        $test = '_f42f-<script>';
        $this->assertEquals('ffscript', $this->sut->sanitize('alpha', $test));
    }

    public function testBoolConvertsToBool()
    {
        $test = 0;
        $this->assertFalse($this->sut->sanitize('bool', $test));
    }

    public function testBooleanConvertsToBool()
    {
        $test = 1;
        $this->assertTrue($this->sut->sanitize('boolean', $test));
    }

    public function testCallThrowsExceptionOnInvalidSanitizerName()
    {
        $test = 'foo';
        $this->expectException('\Smorken\Sanitizer\SanitizerException');
        $this->sut->foo($test);
    }

    public function testConvertsToCamelCaseWithCall()
    {
        $test = 'foo';
        $this->assertEquals($test, $this->sut->alphaNum($test));
    }

    public function testConvertsToCamelCaseWithFullMethod()
    {
        $test = 'foo';
        $this->assertEquals($test, $this->sut->sanitize('alpha_num', $test));
    }

    public function testFloatConvertsNonFloatToZero()
    {
        $test = 'f42f<script>';
        $this->assertEquals(0.0, $this->sut->sanitize('float', $test));
    }

    public function testFloatConvertsPartialFloat()
    {
        $test = '42f<script>';
        $this->assertEquals(42, $this->sut->sanitize('int', $test));
    }

    public function testIntConvertsNonInt()
    {
        $test = 'f42f<script>';
        $this->assertEquals(42, $this->sut->sanitize('int', $test));
    }

    public function testSanitizeBladeViewNameWithInvalidChars()
    {
        $view = 'foo.bar_baz../\\<?php';
        $this->assertEquals('foo.bar_baz..php', $this->sut->bladeViewName($view));
    }

    public function testSanitizeClassName()
    {
        $classname = '\Foo\Bar\Class_Name^';
        $this->assertEquals('\Foo\Bar\Class_Name', $this->sut->phpClassName($classname));
    }

    public function testSanitizeClassNameConstant()
    {
        $classname = \Smorken\Sanitizer\Sanitize::class;
        $this->assertEquals('Smorken\Sanitizer\Sanitize', $this->sut->phpClassName($classname));
    }

    public function testSanitizeEmailWithInvalidChars()
    {
        $email = 'john(.doe)@exa//mple.com';
        $this->assertEquals('john.doe@example.com', $this->sut->email($email));
    }

    public function testSanitizeUrl()
    {
        $url = 'http://www.foobar.com/$-_.+!*\'(),{}|\\^~[]`"><#%;/?:@&=';
        $this->assertEquals('http://www.foobar.com/$-_.+!*\'(),{}|\\^~[]`"><#%;/?:@&=', $this->sut->url($url));
    }

    public function testSanitizeUrlWithInvalidChars()
    {
        $url = 'http://www.foo��bar.co�m';
        $this->assertEquals('http://www.foobar.com', $this->sut->url($url));
    }

    public function testSimpleStringWithCall()
    {
        $test = 'foo';
        $this->assertEquals($test, $this->sut->string($test));
    }

    public function testSimpleStringWithConvertedHtmlFullMethod()
    {
        $test = 'foo<script>';
        $this->assertEquals('foo&lt;script&gt;', $this->sut->sanitize('string', $test));
    }

    public function testSimpleStringWithFullMethod()
    {
        $test = 'foo';
        $this->assertEquals($test, $this->sut->sanitize('string', $test));
    }

    public function testStripTagsMultipleTags()
    {
        $test = '<foo>Bar</foo><script>alert("Hello");</script>';
        $this->assertEquals('', $this->sut->sanitize('strip_tags', $test, ['foo', 'script']));
    }

    public function testStripTagsSingleTag()
    {
        $test = '<foo>Bar</foo><script>alert("Hello");</script>';
        $this->assertEquals('<foo>Bar</foo>', $this->sut->sanitize('strip_tags', $test, 'script'));
    }

    public function testThrowExceptionOnInvalidSanitizerName()
    {
        $test = 'foo';
        $this->expectException('\Smorken\Sanitizer\SanitizerException');
        $this->sut->sanitize('foo', $test);
    }
}
