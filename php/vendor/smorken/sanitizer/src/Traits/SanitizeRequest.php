<?php

namespace Smorken\Sanitizer\Traits;

trait SanitizeRequest
{

    public function sanitize(\Smorken\Sanitizer\Contracts\Sanitize $sanitize, $request, array $rules)
    {
        $new = [];
        foreach ($rules as $input => $rule) {
            $new[$input] = $this->sanitizeRule($sanitize, $this->getValueFromRequest($request, $input),
                is_string($rule) ? explode('|', $rule) : $rule);
        }
        if ($new) {
            $this->replaceRequestValues($request, $new);
        }
        return $request;
    }

    protected function getValueFromRequest($request, $key)
    {
        if (is_object($request) && method_exists($request, 'get')) {
            return $request->get($key);
        }
        return $request[$key] ?? null;
    }

    protected function replaceRequestValues(&$request, $values)
    {
        if (is_object($request) && method_exists($request, 'replace')) {
            $request->replace($values);
        } else {
            $request = array_replace_recursive($request, $values);
        }
    }

    protected function sanitizeRule(\Smorken\Sanitizer\Contracts\Sanitize $sanitize, $value, $rule)
    {
        if (is_array($rule)) {
            foreach ($rule as $r) {
                $value = $this->sanitizeRule($sanitize, $value, $r);
            }
        } elseif (is_callable($rule)) {
            $value = $rule($value);
        } else {
            $value = $sanitize->$rule($value);
        }
        return $value;
    }
}
