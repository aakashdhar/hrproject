<?php

if(!function_exists('ping')) {
    function ping() {
        return 'pong';
    }
}

if (!function_exists('format_date')) {

    function format_date($data_str, $format = 'd/m/Y')
    {
        if (empty($data_str)) {
            return "";
        }
        $format = (empty($format) ? 'd/m/Y' : $format);
        return date($format, strtotime($data_str));
    }

}