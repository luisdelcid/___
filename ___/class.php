<?php

if(!class_exists('___')){
    final class ___ {

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        //
        // private
        //
        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        private static $admin_notices = [], $hooks = [];

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        //
        // public
        //
        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public static function add_admin_notice($admin_notice, $class = 'error', $is_dismissible = false){
            if(!in_array($class, ['error', 'info', 'success', 'warning'])){
    			$class = 'warning';
    		}
    		if($is_dismissible){
    			$class .= ' is-dismissible';
    		}
    		self::$admin_notices[] = '<div class="notice notice-' . $class . '"><p>' . $admin_notice . '</p></div>';
    		self::one('admin_notices', function(){
    			foreach(self::$admin_notices as $admin_notice){
    				echo $admin_notice;
    			}
    		});
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public static function are_plugins_active($plugins){
            $r = false;
    		if($plugins){
    			$r = true;
    			foreach($plugins as $plugin){
    				if(!self::is_plugin_active($plugin)){
    					$r = false;
    					break;
    				}
    			}
    		}
    		return $r;
        }

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

        public static function base64_urldecode($data, $strict = false){
            return base64_decode(strtr($data, '-_', '+/'), $strict);
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public static function base64_urlencode($data){
            return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public static function clone_role($source, $destination, $display_name){
            $role = get_role($source);
    		if($role){
    			$capabilities = $role->capabilities;
    			return add_role($destination, $display_name, $capabilities);
    		}
    		return null;
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public static function current_screen_in($ids){
            if(is_admin()){
    			if(function_exists('get_current_screen')){
    				$current_screen = get_current_screen();
    	            if($current_screen){
    					return in_array($current_screen->id, $ids);
    	            }
    			}
            }
            return false;
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public static function current_screen_is($id){
            if(is_admin()){
    			if(function_exists('get_current_screen')){
    				$current_screen = get_current_screen();
    	            if($current_screen){
    					return ($current_screen->id == $id);
    	            }
    			}
            }
            return false;
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public static function destroy_other_sessions(){
            self::one('init', function(){
    			wp_destroy_other_sessions();
            });
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
                $tmp = self::upload_tmpdir();
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

        public static function get_memory_size(){
            if(!function_exists('exec')){
    	        return 0;
    	    }
    	    exec('free -b', $output);
    	    $output = $output[1];
    	    $output = trim(preg_replace('/\s+/', ' ', $output));
    	    $output = explode(' ', $output);
    	    $output = $output[1];
    	    return (int) $output;
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public static function is_array_assoc($array){
            if(is_array($array)){
                return (array_keys($array) !== range(0, count($array) - 1));
            }
    		return false;
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public static function is_doing_heartbeat(){
            return (defined('DOING_AJAX') and DOING_AJAX and isset($_POST['action']) and $_POST['action'] == 'heartbeat');
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public static function is_plugin_active($plugin){
            if(!function_exists('is_plugin_active')){
    			require_once(ABSPATH . 'wp-admin/includes/plugin.php');
    		}
    		return is_plugin_active($plugin);
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public static function is_plugin_deactivating($file){
            global $pagenow;
            if(is_file($file)){
                return (is_admin() and $pagenow == 'plugins.php' and isset($_GET['action'], $_GET['plugin']) and $_GET['action'] == 'deactivate' and $_GET['plugin'] == plugin_basename($file));
            }
            return false;
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public static function is_post_revision_or_auto_draft($post){
            return (wp_is_post_revision($post) or get_post_status($post) == 'auto-draft');
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
    				return ___closure_md5($data);
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

        public static function md5_to_uuid4($md5){
            if(strlen($md5) == 32){
        		return substr($md5, 0, 8) . '-' . substr($md5, 8, 4) . '-' . substr($md5, 12, 4) . '-' . substr($md5, 16, 4) . '-' . substr($md5, 20, 12);
        	}
            return '';
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
    			$md5 = ___closure_md5($function_to_add);
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

        public static function post_type_labels($singular, $plural, $all = true){
            if($singular and $plural){
        		return [
        			'name' => $plural,
        			'singular_name' => $singular,
        			'add_new' => 'Add New',
        			'add_new_item' => 'Add New ' . $singular,
        			'edit_item' => 'Edit ' . $singular,
        			'new_item' => 'New ' . $singular,
        			'view_item' => 'View ' . $singular,
        			'view_items' => 'View ' . $plural,
        			'search_items' => 'Search ' . $plural,
        			'not_found' => 'No ' . strtolower($plural) . ' found.',
        			'not_found_in_trash' => 'No ' . strtolower($plural) . ' found in Trash.',
        			'parent_item_colon' => 'Parent ' . $singular . ':',
        			'all_items' => ($all ? 'All ' : '') . $plural,
        			'archives' => $singular . ' Archives',
        			'attributes' => $singular . ' Attributes',
        			'insert_into_item' => 'Insert into ' . strtolower($singular),
        			'uploaded_to_this_item' => 'Uploaded to this ' . strtolower($singular),
        			'featured_image' => 'Featured image',
        			'set_featured_image' => 'Set featured image',
        			'remove_featured_image' => 'Remove featured image',
        			'use_featured_image' => 'Use as featured image',
        			'filter_items_list' => 'Filter ' . strtolower($plural) . ' list',
        			'items_list_navigation' => $plural . ' list navigation',
        			'items_list' => $plural . ' list',
        			'item_published' => $singular . ' published.',
        			'item_published_privately' => $singular . ' published privately.',
        			'item_reverted_to_draft' => $singular . ' reverted to draft.',
        			'item_scheduled' => $singular . ' scheduled.',
        			'item_updated' => $singular . ' updated.',
        		];
        	}
        	return [];
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public static function remove_whitespaces($str){
            return trim(preg_replace('/[\r\n\t\s]+/', ' ', $str));
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

        public static function signon_without_password($username_or_email, $remember = false){
            if(is_user_logged_in()){
                return wp_get_current_user();
            } else {
                $idx = self::one('authenticate', function($user, $username_or_email){
                    if(is_null($user)){
                        if(is_email($username_or_email)){
                            $user = get_user_by('email', $username_or_email);
                        }
                        if(is_null($user)){
                            $user = get_user_by('login', $username_or_email);
                            if(is_null($user)){
    	                        return self::error('does_not_exist', __('The requested user does not exist.'));
    	                    }
                        }
                    }
                    return $user;
                }, 10, 2);
                $user = wp_signon([
    				'remember' => $remember,
                    'user_login' => $username_or_email,
                    'user_password' => '',
                ]);
                self::off('authenticate', $idx);
                return $user;
            }
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

        public static function upload_basedir(){
            $wp_upload_dir = wp_get_upload_dir();
            return $wp_upload_dir['basedir'] . '/___';
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public static function upload_baseurl(){
            $wp_upload_dir = wp_get_upload_dir();
            return $wp_upload_dir['baseurl'] . '/___';
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public static function upload_tmpdir(){
            return self::upload_basedir() . '/tmp';
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public static function upload_tmpurl(){
            return self::upload_baseurl() . '/tmp';
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    }
}
