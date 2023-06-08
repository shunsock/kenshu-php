<?php
/**
 * Created by IntelliJ IDEA.
 * User: scoce95461
 * Date: 5/11/17
 * Time: 9:43 AM
 */

include_once __DIR__ . '/../../../../../src/Http/helpers.php';

class ArrayToQueryStringTest extends \PHPUnit_Framework_TestCase
{

    public function testEmptyArray()
    {
        $r = qs_url('foo', []);
        $this->assertEquals('foo', $r);
    }

    public function testSimpleArray()
    {
        $r = qs_url('foo', ['a' => 'b', 'c' => 'd', 'e' => 'f']);
        $this->assertEquals('foo?a=b&c=d&e=f', $r);
    }

    public function testMultiDimArray()
    {
        $r = qs_url('foo', ['a' => 'b', 'c' => ['d' => 'e', 'f' => 'g']]);
        $this->assertEquals('foo?a=b&c%5Bd%5D=e&c%5Bf%5D=g', $r);
    }

    public function testMultiDimArrayComplex()
    {
        $r = qs_url('foo', ['a' => 'b', 'c' => ['d' => ['e' => 'f'], 'g' => 'h']]);
        $this->assertEquals('foo?a=b&c%5Bd%5D%5Be%5D=f&c%5Bg%5D=h', $r);
    }

    public function testEscapesKey()
    {
        $r = qs_url('foo', ['<script>alert();</script>' => 'b']);
        $this->assertEquals('foo?%26lt%3Bscript%26gt%3Balert%28%29%3B%26lt%3B%2Fscript%26gt%3B=b', $r);
    }

    public function testEscapesAndEncodesValue()
    {
        $r = qs_url('foo', ['a' => '<script>alert("Do some bad stuff");</script>\';--']);
        $this->assertEquals('foo?a=%26lt%3Bscript%26gt%3Balert%28%26quot%3BDo+some+bad+stuff%26quot%3B%29%3B%26lt%3B%2Fscript%26gt%3B%26%23039%3B%3B--', $r);
    }
}
