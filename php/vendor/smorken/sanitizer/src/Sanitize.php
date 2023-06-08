<?php
/**
 * Created by IntelliJ IDEA.
 * User: scoce95461
 * Date: 3/31/16
 * Time: 8:30 AM
 */

namespace Smorken\Sanitizer;

use Illuminate\Support\Arr;
use Smorken\Sanitizer\Contracts\Actor;

class Sanitize implements \Smorken\Sanitizer\Contracts\Sanitize
{

    protected $default;

    protected $sanitizers = [];

    public function __construct(array $options)
    {
        $this->setupSanitizers($options);
    }

    /**
     * @param $name
     * @param $params
     * @return mixed
     * @throws \Smorken\Sanitizer\SanitizerException
     */
    public function __call($name, $params)
    {
        $sanitizer = null;
        $args = [$name];
        if (isset($params[1]) && $this->exists($params[1])) {
            $sanitizer = $params[1];
            unset($params[1]);
        }
        $args = array_merge($args, $params);
        return $this->sanitizeCall($sanitizer, $args);
    }

    /**
     * @param $name
     * @return \Smorken\Sanitizer\Contracts\Actor
     * @throws \Smorken\Sanitizer\SanitizerException
     */
    public function __get($name)
    {
        return $this->get($name);
    }

    /**
     * @param  string  $name
     * @param  \Smorken\Sanitizer\Contracts\Actor  $sanitizer
     */
    public function add($name, Actor $sanitizer)
    {
        $this->sanitizers[$name] = $sanitizer;
    }

    /**
     * @param $name
     * @return bool
     */
    public function exists($name)
    {
        return array_key_exists($name, $this->sanitizers);
    }

    /**
     * @param  null|string  $sanitizer
     * @return Actor
     * @throws \Smorken\Sanitizer\SanitizerException
     */
    public function get($sanitizer = null)
    {
        if ($sanitizer === null) {
            $sanitizer = $this->default;
        }
        if ($this->exists($sanitizer)) {
            return $this->sanitizers[$sanitizer];
        }
        throw new SanitizerException("Unable to locate $sanitizer.");
    }

    /**
     * Call a sanitizer directly, defaults to the default sanitizer
     *
     * @param  string  $type
     * @param  mixed  $value
     * @param  null|string  $sanitizer
     * @return mixed
     * @throws SanitizerException
     */
    public function sanitize($type, $value, $sanitizer = null)
    {
        $args = func_get_args();
        unset($args[2]);
        return $this->sanitizeCall($sanitizer, $args);
    }

    protected function sanitizeCall($sanitizer, $params)
    {
        foreach ($this->sanitizers as $s) {
            try {
                return call_user_func_array([$s, 'sanitize'], $params);
            } catch (SanitizerException $se) {
                continue;
            }
        }
        throw new SanitizerException('Unable to sanitize '.$params[0]);
    }

    protected function setupSanitizers($options)
    {
        $this->default = Arr::get($options, 'default', 'standard');
        $sans = Arr::get($options, 'sanitizers', []);
        foreach ($sans as $k => $s) {
            $this->add($k, new $s);
        }
    }
}
