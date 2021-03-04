<?php

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___closure')){
    function ___closure(){
        if(!class_exists('___Closure')){
            require_once(plugin_dir_path(__FILE__) . 'class.php');
        }
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___closure_md5')){
    function ___closure_md5(){
        ___closure();
        return call_user_func_array(['___Closure', 'closure_md5'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___closure_serialize')){
    function ___closure_serialize(){
        ___closure();
        return call_user_func_array(['___Closure', 'closure_serialize'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
