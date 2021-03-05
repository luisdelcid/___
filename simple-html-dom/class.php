<?php

if(!class_exists('___Simple_HTML_DOM')){
    final class ___Simple_HTML_DOM {

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        //
        // private
        //
        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        private static function class(){
            if(class_exists('simple_html_dom')){
                return true;
            }
            $dir = ___upload_tmpdir() . '/github/simplehtmldom/simplehtmldom/1.9.1';
            $expected = $dir . '/simplehtmldom-1.9.1';
            if(@is_dir($expected)){
                require_once($expected . '/simple_html_dom.php');
                return true;
            }
            $url = 'https://github.com/simplehtmldom/simplehtmldom/archive/1.9.1.zip';
            $result = ___download_and_unzip($url, $dir);
            if(is_wp_error($result)){
                return $result;
            }
            require_once($expected . '/simple_html_dom.php');
            return true;
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        //
        // public
        //
        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public static function file_get_html(){
            $require = self::class();
            if(is_wp_error($require)){
                return $require;
            }
            return call_user_func_array('file_get_html', func_get_args());
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public static function str_get_html(){
            $require = self::class();
            if(is_wp_error($require)){
                return $require;
            }
            return call_user_func_array('str_get_html', func_get_args());
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    }
}
