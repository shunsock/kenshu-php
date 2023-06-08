<?php
/**
 * Created by IntelliJ IDEA.
 * User: scoce95461
 * Date: 3/31/16
 * Time: 8:40 AM
 */

namespace Smorken\Sanitizer\Actors;

class RdsCds extends Base
{

    protected function acadOrg($value)
    {
        return $this->alphaNum($value);
    }

    protected function collegeId($value)
    {
        return $this->alphaNum($value);
    }

    protected function comments($value)
    {
        return $this->string($value);
    }

    protected function courseId($value)
    {
        return $this->alphaNumDash($value);
    }

    protected function credits($value)
    {
        return $this->int($value);
    }

    protected function detailId($value)
    {
        return $this->alphaNumDash($value);
    }

    protected function diff($value)
    {
        return $this->float($value);
    }

    protected function groupId($value)
    {
        return $this->alphaNumDash($value);
    }

    protected function load($value)
    {
        $valid = ['N', 'L', 'H', 'T', 'F'];
        if (in_array($value, $valid, true)) {
            return $value;
        }
    }

    protected function meidOrId($value)
    {
        return $this->alphaNum($value);
    }

    protected function name($value)
    {
        return $this->string($value);
    }

    protected function page($value)
    {
        return $this->int($value);
    }

    protected function planCode($value)
    {
        return $this->alphaNum($value);
    }

    protected function studentId($value)
    {
        return $this->int($value);
    }

    protected function termId($value)
    {
        return $this->int($value);
    }
}
