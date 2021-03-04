<?php

if(!class_exists('___JWT')){
    final class ___JWT {

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        //
        // private
        //
        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        private static function class(){
            if(class_exists('Firebase\JWT\JWT')){
                return true;
            }
            $dir = ___upload_tmpdir() . '/github/firebase/php-jwt/5.2.1';
            $expected = $dir . '/php-jwt-5.2.1';
            if(@is_dir($expected)){
                require_once($expected . '/src/BeforeValidException.php');
                require_once($expected . '/src/ExpiredException.php');
                require_once($expected . '/src/JWK.php');
                require_once($expected . '/src/JWT.php');
                require_once($expected . '/src/SignatureInvalidException.php');
                return true;
            }
            $url = 'https://github.com/firebase/php-jwt/archive/v5.2.1.zip';
            $result = ___download_and_unzip($url, $dir);
            if(is_wp_error($result)){
                return $result;
            }
            require_once($expected . '/src/BeforeValidException.php');
            require_once($expected . '/src/ExpiredException.php');
            require_once($expected . '/src/JWK.php');
            require_once($expected . '/src/JWT.php');
            require_once($expected . '/src/SignatureInvalidException.php');
            return true;
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        //
        // public
        //
        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public static function decode($data){
            $require = self::class();
            if(is_wp_error($require)){
                return $require;
            }
            return call_user_func_array(['Firebase\JWT\JWT', 'decode'], func_get_args());
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public static function encode($data){
            $require = self::class();
            if(is_wp_error($require)){
                return $require;
            }
            return call_user_func_array(['Firebase\JWT\JWT', 'encode'], func_get_args());
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    }
}
