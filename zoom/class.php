<?php

if(!class_exists('___Zoom')){
    final class ___Zoom {

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        //
        // private
        //
        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        private static $api_key = '', $api_secret = '', $timeout = 30;

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        private static function jwt(){
            if(!self::$api_key or !self::$api_secret){
                return '';
            }
            $payload = [
                'iss' => self::$api_key,
                'exp' => time() + DAY_IN_SECONDS, // GMT time
            ];
            return ___jwt_encode($payload, self::$api_secret);
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        private static function request($url){
            return ___request($url, [
        		'headers' => [
        			'Accept' => 'application/json',
        			'Authorization' => 'Bearer ' . self::jwt(),
        			'Content-Type' => 'application/json',
        		],
        		'timeout' => self::$timeout,
        	]);
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        private static function url($endpoint){
            if($endpoint){
                $base = 'https://api.zoom.us/v2';
                $endpoint = str_replace($base, '', untrailingslashit($endpoint));
                return $base . '/' . ltrim($endpoint, '/');
            }
            return '';
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        //
        // public
        //
        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public static function auth($api_key, $api_secret){
            if($api_key){
    			self::$api_key = $api_key;
    		}
            if($api_secret){
    			self::$api_secret = $api_secret;
    		}
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public static function delete($endpoint, $args = []){
            $url = self::url($endpoint);
            $request = self::request($url);
            return $request->delete($args);
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public static function get($endpoint, $args = []){
            $url = self::url($endpoint);
            $request = self::request($url);
            return $request->get($args);
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public static function patch($endpoint, $args = []){
            $url = self::url($endpoint);
            $request = self::request($url);
            return $request->patch($args);
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public static function post($endpoint, $args = []){
            $url = self::url($endpoint);
            $request = self::request($url);
            return $request->post($args);
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public static function put($endpoint, $args = []){
            $url = self::url($endpoint);
            $request = self::request($url);
            return $request->put($args);
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    }
}
