<?php
/**
 * Created by IntelliJ IDEA.
 * User: scoce95461
 * Date: 3/31/16
 * Time: 8:32 AM
 */

namespace Smorken\Sanitizer\Contracts;

interface Actor
{

    /**
     * @param string $type
     * @param mixed $value
     * @return mixed
     */
    public function sanitize($type, $value);
}
