<?php

if(!class_exists('___Closure')){
    final class ___Closure {

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        //
        // private
        //
        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        private static function class(){
            if(class_exists('Opis\Closure\SerializableClosure')){
                return true;
            }
            $dir = ___upload_tmpdir() . '/github/opis/closure/3.6.1';
            $expected = $dir . '/closure-3.6.1';
            if(@is_dir($expected)){
                require_once($expected . '/autoload.php');
                return true;
            }
            $url = 'https://github.com/opis/closure/archive/3.6.1.zip';
            $result = ___download_and_unzip($url, $dir);
            if(is_wp_error($result)){
                return $result;
            }
            require_once($expected . '/autoload.php');
            return true;
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        //
        // public
        //
        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public static function closure_md5($data, $spl_object_hash = false){
            $serialized = self::closure_serialize($data);
            if(is_wp_error($serialized)){
                return $serialized;
            }
            if(!$serialized){
                return '';
            }
            if(!$spl_object_hash){
                $serialized = str_replace(spl_object_hash($data), 'spl_object_hash', $serialized);
            }
            return md5($serialized);
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public static function closure_serialize($data){
            $require = self::class();
            if(is_wp_error($require)){
                return $require;
            }
            if($data instanceof Closure){
                $wrapper = new Opis\Closure\SerializableClosure($data);
                return maybe_serialize($wrapper);
            }
    		return '';
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    }
}
