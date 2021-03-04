<?php

if(!class_exists('___Loader')){
    final class ___Loader {

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        //
        // private
        //
        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        private static $file = '';

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        //
        // public
        //
        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public static function load($file = ''){
            $dir = wp_get_upload_dir();
            $dir = $dir['basedir'];
            $dir .= '/___';
            if(!wp_mkdir_p($dir)){
                add_action('admin_notices', function(){
        			echo '<div class="notice notice-error"><p>' . __('Could not create directory.') . '</p></div>';
        		});
                return;
            }
            if(!function_exists('get_filesystem_method')){
                require_once(ABSPATH . 'wp-admin/includes/file.php');
            }
            if(get_filesystem_method() != 'direct'){
                add_action('admin_notices', function(){
        			echo '<div class="notice notice-error"><p>' . __('Could not access filesystem.') . '</p></div>';
        		});
                return;
            }
            if(!wp_is_writable($dir)){
                add_action('admin_notices', function(){
        			echo '<div class="notice notice-error"><p>' . __('Filesystem error.') . '</p></div>';
        		});
                return;
            }
            foreach(glob(plugin_dir_path($file) . '*', GLOB_ONLYDIR) as $dir){
                if(basename($dir) != 'loader'){
                    if(file_exists($dir . '/___.php')){
                        require_once($dir . '/___.php');
                    }
                }
            }
            if(is_admin()){
                ___puc_build_update_checker('https://github.com/luisdelcid/___', $file, '___');
                ___enqueue_functions('admin');
            } else {
                ___enqueue_functions('front-end');
            }
            ___on('after_setup_theme', function(){
                $file = get_stylesheet_directory() . '/___.php';
                if(file_exists($file)){
                    require_once($file);
                }
            });
            ___do('___');
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    }
}
