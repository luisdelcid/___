<?php

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___zoom')){
	function ___zoom(){
		if(!class_exists('___Zoom')){
            require_once(plugin_dir_path(__FILE__) . 'class.php');
        }
	}
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___zoom_auth')){
	function ___zoom_auth(){
        ___zoom();
        return call_user_func_array(['___Zoom', 'auth'], func_get_args());
	}
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___zoom_delete')){
	function ___zoom_delete(){
        ___zoom();
        return call_user_func_array(['___Zoom', 'delete'], func_get_args());
	}
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___zoom_get')){
	function ___zoom_get(){
        ___zoom();
        return call_user_func_array(['___Zoom', 'get'], func_get_args());
	}
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___zoom_patch')){
	function ___zoom_patch(){
        ___zoom();
        return call_user_func_array(['___Zoom', 'patch'], func_get_args());
	}
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___zoom_post')){
	function ___zoom_post(){
        ___zoom();
        return call_user_func_array(['___Zoom', 'post'], func_get_args());
	}
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___zoom_put')){
	function ___zoom_put(){
        ___zoom();
        return call_user_func_array(['___Zoom', 'put'], func_get_args());
	}
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
