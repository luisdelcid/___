<?php

if(!class_exists('___PUC')){
    final class ___PUC {

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        //
        // public
        //
        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public static function puc(){
            if(class_exists('Puc_v4_Factory')){
                return true;
            }
            $dir = ___upload_tmpdir() . '/github/YahnisElsts/plugin-update-checker/4.10';
            $expected = $dir . '/plugin-update-checker-4.10';
            if(@is_dir($expected)){
                require_once($expected . '/plugin-update-checker.php');
                return true;
            }
            $url = 'https://github.com/YahnisElsts/plugin-update-checker/archive/v4.10.zip';
            $result = ___download_and_unzip($url, $dir);
            if(is_wp_error($result)){
                return $result;
            }
            require_once($expected . '/plugin-update-checker.php');
            return true;
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public static function build(){
            $require = self::puc();
            if(is_wp_error($require)){
                return $require;
            }
            return call_user_func_array(['Puc_v4_Factory', 'buildUpdateChecker'], func_get_args());
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    }
}
