<?php

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___floating_labels')){
    function ___floating_labels(){
        if(!class_exists('___Floating_Labels')){
            require_once(plugin_dir_path(__FILE__) . 'class.php');
        }
        ___one('wp_enqueue_scripts', ['___Floating_Labels', 'wp_enqueue_scripts']);
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
