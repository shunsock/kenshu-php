<?php
/**
 * Created by IntelliJ IDEA.
 * User: scoce95461
 * Date: 3/31/16
 * Time: 8:31 AM
 */

namespace Smorken\Sanitizer\Actors;

use Illuminate\Support\Str;
use Smorken\Sanitizer\Contracts\Actor;
use Smorken\Sanitizer\SanitizerException;

abstract class Base implements Actor
{

    public function __call($name, $params)
    {
        array_unshift($params, $name);
        return call_user_func_array([$this, 'sanitize'], $params);
    }

    /**
     * @param  string  $key
     * @param  mixed  $value
     * @return string
     * @throws SanitizerException
     */
    public function sanitize($key, $value)
    {
        $m = Str::camel($key);
        if (method_exists($this, $m)) {
            $args = func_get_args();
            unset($args[0]);
            return call_user_func_array([$this, $m], $args);
        }
        throw new SanitizerException("$key cannot be sanitized.");
    }

    protected function alpha($value)
    {
        return $this->preg($value, '/[^\p{L}]/');
    }

    protected function alphaNum($value)
    {
        return $this->preg($value, '/[^\p{L}\p{N}]/');
    }

    protected function alphaNumDash($value)
    {
        return $this->preg($value, '/[^\p{L}\p{N}\-_]/');
    }

    protected function alphaNumDashSpace($value)
    {
        return $this->preg($value, '/[^\p{L}\p{N}\-_ ]/');
    }

    protected function bladeViewName($value)
    {
        return $this->preg($value, '/[^A-Za-z0-9\-_\.]/');
    }

    protected function bool($value)
    {
        return (bool) $value;
    }

    protected function boolean($value)
    {
        return $this->bool($value);
    }

    protected function email($value)
    {
        return filter_var($value, FILTER_SANITIZE_EMAIL);
    }

    protected function float($value)
    {
        return (float) $value;
    }

    protected function int($value)
    {
        return filter_var($value, FILTER_SANITIZE_NUMBER_INT);
    }

    protected function integer($value)
    {
        return $this->int($value);
    }

    protected function phpClassName($value)
    {
        return $this->preg($value, '/[^A-Za-z0-9_\\\]/');
    }

    protected function preg($value, $regex)
    {
        return preg_replace($regex, '', $value);
    }

    protected function purify($value)
    {
        return $this->sanitize('xssAdmin', $value);
    }

    protected function string($value)
    {
        return htmlentities(stripslashes(trim($value)), ENT_QUOTES, 'UTF-8', false);
    }

    /**
     * Note that this method is NOT guaranteed to be safe!
     *
     * @param $value
     * @param  array|string  $tags
     * @return mixed
     */
    protected function stripTags($value, $tags)
    {
        if (is_string($tags)) {
            $tags = [$tags];
        }
        foreach ($tags as $tag) {
            $pattern = sprintf('/<%s.*>.*<\/%s>/', $tag, $tag);
            $value = $this->preg($value, $pattern);
        }
        return $value;
    }

    protected function url($value)
    {
        return filter_var($value, FILTER_SANITIZE_URL);
    }
}
