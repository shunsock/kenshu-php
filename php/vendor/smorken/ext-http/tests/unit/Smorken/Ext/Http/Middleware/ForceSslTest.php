<?php
/**
 * Created by IntelliJ IDEA.
 * User: scoce95461
 * Date: 6/16/16
 * Time: 11:02 AM
 */
namespace Smorken\Ext\Http\Middleware {
    use Mockery as m;

    function redirect()
    {
        return new RedirectStub();
    }

    function app()
    {
        return new AppStub();
    }

    class ForceSslTest extends \PHPUnit_Framework_TestCase
    {

        public function tearDown()
        {
            m::close();
        }

        public function testForceSslAlreadySecureContinues()
        {
            list($sut, $request, $next) = $this->getSutAndMocks();
            $request->shouldReceive('secure')->andReturn(true);
            $r = $sut->handle($request, $next);
            $this->assertEquals('next', $r);
        }

        public function testForceSslNotSecureRedirects()
        {
            $next = function($request) {
                return 'next';
            };
            $request = m::mock('Illuminate\Http\Request');
            $request->shouldReceive('secure')->andReturn(false);
            $request->shouldReceive('path')->andReturn('foo/path');
            $sut = new ForceSsl();
            $r = $sut->handle($request, $next);
            $this->assertEquals('next', $r);
        }

        public function testForceSslNotSecureAndEnvSkipSetContinues()
        {
            AppStub::$environment = 'local';
            $next = function($request) {
                return 'next';
            };
            $request = m::mock('Illuminate\Http\Request');
            $request->shouldReceive('secure')->andReturn(false);
            $request->shouldReceive('path')->andReturn('foo/path');
            $sut = new ForceSsl();
            $r = $sut->handle($request, $next);
            $this->assertEquals('next', $r);
        }

        protected function getSutAndMocks()
        {
            $next = function($request) {
                return 'next';
            };
            $request = m::mock('Illuminate\Http\Request');
            $sut = new ForceSsl();
            return [$sut, $request, $next];
        }
    }

    class AppStub
    {
        public static $environment = 'testing';

        public function environment()
        {
            return self::$environment;
        }
    }

    class RedirectStub
    {
        public function secure($url)
        {
            return 'secure ' . $url;
        }
    }
}
