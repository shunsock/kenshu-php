<?php

namespace Tests\Smorken\Sanitizer\Unit;

use PHPUnit\Framework\TestCase;
use Smorken\Sanitizer\Sanitize;
use Smorken\Sanitizer\Traits\SanitizeRequest;

class SanitizeRequestTest extends TestCase
{
    use SanitizeRequest;

    public function testArrayRule()
    {
        $request = $this->mockRequest();
        $request->expects($this->once())
                ->method('get')
                ->with($this->equalTo('bar'))
                ->willReturn(' <?php foo bar; > ');
        $request->expects($this->once())
                ->method('replace')
                ->with($this->equalTo(['bar' => '&lt;?php foo bar; &gt;']));
        self::sanitize(new Sanitize($this->getOptions()), $request, ['bar' => ['trim', 'string']]);
    }

    public function testCallableRule()
    {
        $request = $this->mockRequest();
        $request->expects($this->once())
                ->method('get')
                ->with($this->equalTo('bar'))
                ->willReturn('fiz');
        $request->expects($this->once())
                ->method('replace')
                ->with($this->equalTo(['bar' => 'callback fiz']));
        self::sanitize(new Sanitize($this->getOptions()), $request, [
            'bar' => function ($value) {
                return sprintf('callback %s', $value);
            },
        ]);
    }

    public function testComplexRules()
    {
        $request = $this->mockRequest();
        $request->expects($this->exactly(3))
                ->method('get')
                ->withConsecutive([$this->equalTo('arr')], [$this->equalTo('callable')], [$this->equalTo('simple')])
                ->will($this->onConsecutiveCalls(' <?php foo bar; > ', 'fiz', '123'));
        $request->expects($this->once())
                ->method('replace')
                ->with($this->equalTo([
                    'arr'      => '&lt;?php foo bar; &gt;',
                    'callable' => 'callback fiz',
                    'simple'   => '123',
                ]));
        self::sanitize(new Sanitize($this->getOptions()), $request, [
            'arr'      => ['trim', 'string'],
            'callable' => function ($value) {
                return sprintf('callback %s', $value);
            },
            'simple'   => 'int',
        ]);
    }

    public function testSimpleRule()
    {
        $request = $this->mockRequest();
        $request->expects($this->once())
                ->method('get')
                ->with($this->equalTo('bar'))
                ->willReturn('123foo');
        $request->expects($this->once())
                ->method('replace')
                ->with($this->equalTo(['bar' => '123']));
        self::sanitize(new Sanitize($this->getOptions()), $request, ['bar' => 'int']);
    }

    protected function getOptions()
    {
        return [
            'default'    => 'standard',
            'sanitizers' => [
                'standard' => \Smorken\Sanitizer\Actors\Standard::class,
            ],
        ];
    }

    protected function mockRequest()
    {
        $request = $this->getMockBuilder(\Illuminate\Http\Request::class)
                        ->setMethods(['get', 'replace'])
                        ->getMock();
        return $request;
    }
}
