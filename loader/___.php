<?php

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___loader')){
	function ___loader(){
		if(!class_exists('___')){
            require_once(plugin_dir_path(__FILE__) . 'class.php');
        }
	}
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___load')){
	function ___load(){
        ___loader();
        return call_user_func_array(['___Loader', 'load'], func_get_args());
	}
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
