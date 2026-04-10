<?php

if (!function_exists('__t')) {
    function __t($key, $replace = [], $locale = null)
    {
        return __($key, $replace, $locale);
    }
}