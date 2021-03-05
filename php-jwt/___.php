<?php

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___jwt')){
    function ___jwt(){
        if(!class_exists('___JWT')){
            require_once(plugin_dir_path(__FILE__) . 'class.php');
        }
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___jwt_decode')){
    function ___jwt_decode(){
        ___jwt();
        return call_user_func_array(['___JWT', 'decode'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___jwt_encode')){
    function ___jwt_encode(){
        ___jwt();
        return call_user_func_array(['___JWT', 'encode'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
