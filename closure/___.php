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
        return call_user_func_array(['___', 'closure_md5'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___closure_serialize')){
    function ___closure_serialize(){
        return call_user_func_array(['___', 'closure_serialize'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
