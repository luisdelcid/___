<?php

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___puc')){
	function ___puc(){
		if(!class_exists('___PUC')){
            require_once(plugin_dir_path(__FILE__) . 'class.php');
        }
	}
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___puc_build')){
	function ___puc_build(){
        ___puc();
        return call_user_func_array(['___PUC', 'build'], func_get_args());
	}
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
