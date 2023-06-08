<?php
if (!function_exists('qs_url')) {
    /**
     * Generate a querystring url for the application.
     *
     * Assumes that you want a URL with a querystring rather than route params
     * (which is what the default url() helper does)
     *
     * @param  string $url
     * @param  mixed $qs
     * @return string
     */
    function qs_url($url, $qs = [])
    {
        if ($qs) {
            if (function_exists('http_build_query')) {
                $qs = escape_array($qs);
                return sprintf('%s?%s', $url, http_build_query($qs, null, '&'));
            }
            return $url . array_to_query_string($qs);
        }
        return $url;
    }
}

if (!function_exists('array_to_query_string')) {
    /**
     * Create a query string from an array
     *
     * @param $qs_data
     * @param bool $prepend_start
     * @param string $separator
     * @param string $start
     * @return null|string
     */
    function array_to_query_string($qs_data, $prepend_start = true, $separator = '&', $start = '?')
    {
        $qs = null;
        $items = array_to_items($qs_data);
        if (count($items)) {
            $qs = sprintf('%s%s', $prepend_start ? $start : null, implode($separator, $items));
        }
        return $qs;
    }
}

if (!function_exists('array_to_items')) {
    function array_to_items($array, $outer_key = '', $items = [])
    {
        if (!is_array($array)) {
            return $array ?: null;
        }
        foreach ($array as $k => $v) {
            $key = $outer_key ? $outer_key . '[' . $k . ']' : $k;
            if (is_array($v)) {
                $items += array_to_items($v, $key, $items);
            } else {
                $items[] = sprintf('%s=%s', e($key), urlencode(e($v)));
            }
        }
        return $items;
    }
}

if (!function_exists('escape_array')) {
    function escape_array($array)
    {
        $items = [];
        if (!is_array($array)) {
            return $array ?: null;
        }
        foreach ($array as $k => $v) {
            $k = e($k);
            if (is_array($v)) {
                $items[$k] = escape_array($v);
            } else {
                $items[$k] = e($v);
            }
        }
        return $items;
    }
}
