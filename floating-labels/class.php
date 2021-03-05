<?php

if(!class_exists('___Floating_Labels')){
    final class ___Floating_Labels {

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        //
        // public
        //
        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public static function wp_enqueue_scripts(){
            wp_enqueue_script('___floating-labels-b4', plugin_dir_url(__FILE__) . 'floating-labels-b4.js', ['jquery'], filemtime(plugin_dir_path(__FILE__) . 'floating-labels-b4.js'), true);
            wp_enqueue_style('___floating-labels-b4', plugin_dir_url(__FILE__) . 'floating-labels-b4.css', [], filemtime(plugin_dir_path(__FILE__) . 'floating-labels-b4.css'));
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    }
}
