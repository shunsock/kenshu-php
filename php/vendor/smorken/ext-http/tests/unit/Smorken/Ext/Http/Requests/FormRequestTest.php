<?php
use Mockery as m;
use Smorken\Sanitizer\Contracts\Sanitize;

class FormRequestTest extends PHPUnit_Framework_TestCase
{

    public function tearDown()
    {
        m::close();
    }

    public function testAuthorizeDefaultsToTrue()
    {
        $sut = new FormRequestStub();
        $this->assertTrue($sut->authorize());
    }

    public function testRulesDoesSanitization()
    {
        $sut = new FormRequestStub();
        $s = m::mock(Sanitize::class);
        $r = $sut->rules($s, new ProviderStub());
        $this->assertEquals(['foo' => 'required'], $r);
        $this->assertEquals(['foo' => 'bar'], $sut->all());
    }
}

class FormRequestStub extends \Smorken\Ext\Http\Requests\Request
{

    public function rules(Sanitize $s, ProviderStub $provider)
    {
        return $this->sanitizeAndGetRules($s, $provider);
    }

    protected function doSanitize($input, \Smorken\Sanitizer\Contracts\Sanitize $s)
    {
        return ['foo' => 'bar'];
    }
}

class ProviderStub
{
    public function getModel()
    {
        return new ModelStub();
    }
}

class ModelStub
{
    public function rules()
    {
        return [
            'foo' => 'required',
        ];
    }
}
