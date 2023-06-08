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
        $r = array_to_query_string([]);
        $this->assertEquals('', $r);
    }

    public function testSimpleArray()
    {
        $r = array_to_query_string(['a' => 'b', 'c' => 'd', 'e' => 'f']);
        $this->assertEquals('?a=b&c=d&e=f', $r);
    }

    public function testSimpleArrayNoPrepend()
    {
        $r = array_to_query_string(['a' => 'b', 'c' => 'd', 'e' => 'f'], false);
        $this->assertEquals('a=b&c=d&e=f', $r);
    }

    public function testSimpleArraySeparator()
    {
        $r = array_to_query_string(['a' => 'b', 'c' => 'd', 'e' => 'f'], true, '^');
        $this->assertEquals('?a=b^c=d^e=f', $r);
    }

    public function testSimpleArrayStart()
    {
        $r = array_to_query_string(['a' => 'b', 'c' => 'd', 'e' => 'f'], true, '&', '+');
        $this->assertEquals('+a=b&c=d&e=f', $r);
    }

    public function testMultiDimArray()
    {
        $r = array_to_query_string(['a' => 'b', 'c' => ['d' => 'e', 'f' => 'g']]);
        $this->assertEquals('?a=b&c[d]=e&c[f]=g', $r);
    }

    public function testMultiDimArrayComplex()
    {
        $r = array_to_query_string(['a' => 'b', 'c' => ['d' => ['e' => 'f'], 'g' => 'h']]);
        $this->assertEquals('?a=b&c[d][e]=f&c[g]=h', $r);
    }

    public function testEscapesKey()
    {
        $r = array_to_query_string(['<script>alert();</script>' => 'b']);
        $this->assertEquals('?&lt;script&gt;alert();&lt;/script&gt;=b', $r);
    }

    public function testEscapesAndEncodesValue()
    {
        $r = array_to_query_string(['a' => '<script>alert("Do some bad stuff");</script>\';--']);
        $this->assertEquals('?a=%26lt%3Bscript%26gt%3Balert%28%26quot%3BDo+some+bad+stuff%26quot%3B%29%3B%26lt%3B%2Fscript%26gt%3B%26%23039%3B%3B--', $r);
    }
}
