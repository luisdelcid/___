<?php

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___simple_html_dom')){
	function ___simple_html_dom(){
		if(!class_exists('___Simple_HTML_DOM')){
            require_once(plugin_dir_path(__FILE__) . 'class.php');
        }
	}
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___simple_html_dom_file_get_html')){
	function ___simple_html_dom_file_get_html(){
        ___simple_html_dom();
        return call_user_func_array(['___Simple_HTML_DOM', 'file_get_html'], func_get_args());
	}
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___simple_html_dom_str_get_html')){
	function ___simple_html_dom_str_get_html(){
        ___simple_html_dom();
        return call_user_func_array(['___Simple_HTML_DOM', 'str_get_html'], func_get_args());
	}
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
