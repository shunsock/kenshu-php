<?php
/**
 * Created by IntelliJ IDEA.
 * User: scoce95461
 * Date: 3/31/16
 * Time: 8:33 AM
 */

namespace Smorken\Sanitizer\Contracts;

interface Sanitize
{

    /**
     * @param null|string $sanitizer
     * @return Actor
     * @throws \Smorken\Sanitizer\SanitizerException
     */
    public function get($sanitizer = null);

    /**
     * @param string $name
     * @param Actor $sanitizer
     */
    public function add($name, Actor $sanitizer);

    /**
     * @param $name
     * @return bool
     */
    public function exists($name);

    /**
     * Call a sanitizer directly, defaults to the default sanitizer
     * @param string $type
     * @param mixed $value
     * @param null|string $sanitizer
     * @return mixed
     */
    public function sanitize($type, $value, $sanitizer = null);
}
