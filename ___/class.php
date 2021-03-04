<?php

if(!class_exists('___')){
    final class ___ {

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        //
        // private
        //
        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        private static $hooks = [];

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        private static function opis_closure(){
            if(class_exists('Opis\Closure\SerializableClosure')){
                return true;
            }
            $dir = self::upload_basedir() . '/github/opis/closure/3.6.1';
            $expected = $dir . '/closure-3.6.1';
            if(@is_dir($expected)){
                require_once($expected . '/autoload.php');
                return true;
            }
            $url = 'https://github.com/opis/closure/archive/3.6.1.zip';
            $result = self::download_and_unzip($url, $dir);
            if(is_wp_error($result)){
                return $result;
            }
            require_once($expected . '/autoload.php');
            return true;
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        private static function upload_basedir(){
            $wp_upload_dir = wp_get_upload_dir();
            return $wp_upload_dir['basedir'] . '/___';
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        private static function upload_baseurl(){
            $wp_upload_dir = wp_get_upload_dir();
            return $wp_upload_dir['baseurl'] . '/___';
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        //
        // public
        //
        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public static function array_keys_exist($keys, $array){
            if(!$keys or !$array or !is_array($keys) or !is_array($array)){
    			return false;
    		}
    		foreach($keys as $key){
    			if(!array_key_exists($key, $array)){
    				return false;
    			}
    		}
    		return true;
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public static function did($tag){
            return did_action($tag);
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public static function do($tag, ...$arg){
            return do_action($tag, ...$arg);
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public static function download($url, $dest, $args = []){
            $wp_upload_dir = wp_get_upload_dir();
            if(strpos($dest, $wp_upload_dir['basedir']) !== 0){
                return self::error('http_request_failed', __('Destination directory for file streaming does not exist or is not writable.'));
            }
            $args = wp_parse_args($args, [
                'timeout' => MINUTE_IN_SECONDS,
            ]);
            $args['filename'] = $dest;
            $args['stream'] = true;
            $args['timeout'] = self::sanitize_timeout($args['timeout']);
            $response = self::request($url, $args)->get();
            if(!$response->success){
                @unlink($dest);
                return $response->to_wp_error();
            }
            return $dest;
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public static function download_and_unzip($url, $dir, $args = []){
            global $wp_filesystem;
            $dir = untrailingslashit($dir);
            $wp_upload_dir = wp_get_upload_dir();
            if(strpos($dir, $wp_upload_dir['basedir']) !== 0){
                return self::error('http_request_failed', __('Destination directory for file streaming does not exist or is not writable.'));
            }
            if(@is_dir($dir)){
                return true;
            }
            if(!WP_Filesystem()){
                return self::error('http_request_failed', __('Filesystem error.'));
            }
            if(empty($args['filename'])){
                $filename = preg_replace('/\?.*/', '', basename($url));
                $tmp = self::upload_basedir() . '/tmp';
                if(!wp_mkdir_p($tmp)){
                    return self::error('http_request_failed', __('Could not create directory.'));
                }
                $dest = $tmp . '/' . $filename;
            } else {
                $dest = $args['filename'];
                unset($args['filename']);
            }
            $filetype = wp_check_filetype($dest, [
                'zip' => 'application/zip',
            ]);
            if(!$filetype['type']){
                return self::error('http_request_failed', __('Sorry, this file type is not permitted for security reasons.'));
            }
            $file = self::download($url, $dest, $args);
            if(is_wp_error($file)){
                return $file;
            }
            $result = unzip_file($file, $dir);
            if(is_wp_error($result)){
                @unlink($file);
                $wp_filesystem->rmdir($dir, true);
                return $result;
            }
            @unlink($file);
            return $dir;
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public static function download_and_upload($url, $args = [], $parent = 0){
            $wp_upload_dir = wp_upload_dir();
            if(empty($args['filename'])){
                $filename = preg_replace('/\?.*/', '', basename($url));
                $dest = $wp_upload_dir['path'] . '/' . wp_unique_filename($wp_upload_dir['path'], $filename);
            } else {
                $dest = $args['filename'];
                $filename = basename($dest);
                unset($args['filename']);
            }
            $file = self::download($url, $dest, $args);
            if(is_wp_error($file)){
                return $file;
            }
            $post_id = self::upload($file, $parent);
            if(is_wp_error($post_id)){
                @unlink($file);
                return $post_id;
            }
            @unlink($file);
            return $post_id;
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public static function error($code = '', $message = '', $data = ''){
            if(!$code){
        		$code = 'error';
        	}
        	if(!$message){
        		$message = __('Something went wrong.');
        	}
        	return new WP_Error($code, $message, $data);
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public static function is_array_assoc($array){
            if(is_array($array)){
                return (array_keys($array) !== range(0, count($array) - 1));
            }
    		return false;
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public static function ksort_deep($data){
            if(self::is_array_assoc($data)){
                ksort($data);
                foreach($data as $index => $item){
                    $data[$index] = ksort_deep($item);
                }
            }
            return $data;
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public static function md5($data){
            if(is_object($data)){
    			if($data instanceof Closure){
    				return self::md5_closure($data);
    			} else {
    				$data = json_decode(wp_json_encode($data), true);
    			}
            }
            if(is_array($data)){
                $data = self::ksort_deep($data);
                $data = maybe_serialize($data);
            }
    		return md5($data);
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public static function md5_closure($data, $spl_object_hash = false){
            $serialized = self::serialize_closure($data);
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

        public static function off($tag, $function_to_remove, $priority = 10){
            return remove_filter($tag, $function_to_add, $priority);
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public static function on($tag, $function_to_add, $priority = 10, $accepted_args = 1){
            add_filter($tag, $function_to_add, $priority, $accepted_args);
        	return _wp_filter_build_unique_id($tag, $function_to_add, $priority);
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public static function one($tag, $function_to_add, $priority = 10, $accepted_args = 1){
    		$idx = _wp_filter_build_unique_id($tag, $function_to_add, $priority);
    		if($function_to_add instanceof Closure){
    			$md5 = self::md5_closure($function_to_add);
                if(is_wp_error($md5)){
                    $md5 = md5($idx);
                }
    		} else {
    			$md5 = md5($idx);
    		}
    		if(!isset(self::$hooks[$tag])){
    			self::$hooks[$tag] = [];
    		}
    		if(!in_array($md5, self::$hooks[$tag])){
    			self::$hooks[$tag][] = $md5;
    			return self::on($tag, $function_to_add, $priority, $accepted_args);
    		} else {
    			return $idx;
    		}
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public static function prepare(...$args){
            global $wpdb;
            if(!$args){
                return '';
            }
            if(strpos($args[0], '%') !== false and count($args) > 1){
                return str_replace("'", '', $wpdb->remove_placeholder_escape($wpdb->prepare(...$args)));
            } else {
                return $args[0];
            }
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public static function request($url, $args = []){
            if(!class_exists('___Request')){
                require_once(plugin_dir_path(__FILE__) . 'class-request.php');
            }
            return new ___Request($url, $args);
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public static function response($response){
            if(!class_exists('___Response')){
                require_once(plugin_dir_path(__FILE__) . 'class-response.php');
            }
            return new ___Response($response);
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public static function response_error($message = '', $code = 0, $data = ''){
            if(!$code){
                $code = 500;
            }
            if(!$message){
                $message = get_status_header_desc($code);
            }
            if(!$message){
                $message = __('Something went wrong.');
            }
            $success = false;
            return self::response(compact('code', 'data', 'message', 'success'));
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public static function response_success($data = '', $code = 0, $message = ''){
            if(!$code){
                $code = 200;
            }
            if(!$message){
                $message = get_status_header_desc($code);
            }
            if(!$message){
                $message = 'OK';
            }
            $success = true;
            return self::response(compact('code', 'data', 'message', 'success'));
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public static function sanitize_timeout($timeout){
            $timeout = (int) $timeout;
            $max_execution_time = (int) ini_get('max_execution_time');
            if($max_execution_time){
                if(!$timeout or $timeout > $max_execution_time){
                    $timeout = $max_execution_time - 1; // Prevents error 504
                }
            }
            if(isset($_SERVER['HTTP_CF_RAY'])){
                if(!$timeout or $timeout > 99){
                    $timeout = 99; // Prevents error 524: https://support.cloudflare.com/hc/en-us/articles/115003011431#524error
                }
            }
            return $timeout;
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public static function seems_response($response){
            return self::array_keys_exist(['code', 'data', 'message', 'success'], $response);
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public static function seems_successful($data){
            if(!is_numeric($data)){
                if($data instanceof ___Response){
                    $data = $data->code;
                } else {
                    return false;
                }
            } else {
                $data = (int) $code;
            }
            return ($code >= 200 and $code < 300);
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public static function seems_wp_http_requests_response($response){
            return (self::array_keys_exist(['body', 'cookies', 'filename', 'headers', 'http_response', 'response'], $response) and ($response['http_response'] instanceof WP_HTTP_Requests_Response));
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public static function serialize_closure($data){
            $require = self::opis_closure();
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

        public static function support_authorization_header(){
            self::one('mod_rewrite_rules', function($rules){
                $rule = 'RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]';
                if(strpos($rule, $rules) === false){
                    $rules = str_replace('RewriteEngine On', 'RewriteEngine On' . "\n" . $rule, $rules);
                }
                return $rules;
            });
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public static function upload($file, $parent = 0){
            $wp_upload_dir = wp_get_upload_dir();
            if(strpos($file, $wp_upload_dir['basedir']) !== 0){
                return self::error('http_request_failed', __('Destination directory for file streaming does not exist or is not writable.'));
            }
            $filetype_and_ext = wp_check_filetype_and_ext($file, $file);
            if(!$filetype_and_ext['type']){
                return self::error('http_request_failed', __('Sorry, this file type is not permitted for security reasons.'));
            }
            $post_id = wp_insert_attachment([
                'guid' => str_replace($wp_upload_dir['basedir'], $wp_upload_dir['baseurl'], $file),
                'post_mime_type' => $filetype_and_ext['type'],
                'post_status' => 'inherit',
                'post_title' => preg_replace('/\.[^.]+$/', '', basename($file)),
            ], $file, $parent, true);
            if(is_wp_error($post_id)){
                return $post_id;
            }
            return $post_id;
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    }
}
