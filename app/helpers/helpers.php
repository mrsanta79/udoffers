<?php

if(!function_exists('validate_hex')) {
    function validate_hex(string $code) {
        if(preg_match('/^#[0-9A-F]{6}$/i', $code) || preg_match('/^#([0-9A-F]{3}){1,2}$/i', $code)) {
            return true;
        } else {
            return false;
        }
    }
}