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

if (!function_exists('format_datetime')) {

  function format_datetime($data_str, $format = 'd/m/Y H:i') {
    if (empty($data_str)) {
      return "";
    }
    $format = (empty($format) ? 'd/m/Y H' : $format);
    return date($format, strtotime($data_str));
  }

}