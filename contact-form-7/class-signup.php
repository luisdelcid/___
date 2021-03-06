<?php

if(!class_exists('___CF7_Signup')){
    final class ___CF7_Signup {

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        //
        // public
        //
        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public static function contact_form_types($contact_form_types){
            $contact_form_types['signup'] = __('Signup');
            return $contact_form_types;
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public static function do_shortcode_tag($output, $tag, $attr, $m){
            if('contact-form-7' != $tag){
                return $output;
            }
            $contact_form = wpcf7_get_current_contact_form();
            if(!$contact_form){
                return $output;
            }
            if(get_post_meta($contact_form->id(), '___contact_form_type', true) != 'signup'){
                return $output;
            }
            $invalid = [];
            $missing = [];
            $tags = wp_list_pluck($contact_form->scan_form_tags(), 'type', 'name');
            if(empty($tags['user_email'])){
                $missing[] = 'user_email';
            }
            if(get_post_meta($contact_form->id(), '___signup_email_as_username', true) != 'yes'){
                if(empty($tags['user_login'])){
                    $missing[] = 'user_login';
                }
            }
            if(empty($tags['user_password'])){
                $missing[] = 'user_password';
            }
            if($missing){
                return current_user_can('manage_options') ? sprintf(__('Missing parameter(s): %s'), implode(', ', $missing)) . '.' : __('Something went wrong.');
            }
            if($tags['user_email'] != 'email*'){
                $invalid[] = 'user_email';
            }
            if(get_post_meta($contact_form->id(), '___signup_email_as_username', true) != 'yes'){
                if($tags['user_login'] != 'text*'){
                    $invalid[] = 'user_login';
                }
            }
            if($tags['user_password'] != 'password*'){
                $invalid[] = 'user_password';
            }
            if(!empty($tags['user_password_confirm']) and $tags['user_password_confirm'] != 'password*'){
                $invalid[] = 'user_password_confirm';
            }
            if($invalid){
                return current_user_can('manage_options') ? sprintf(__('Invalid parameter(s): %s'), implode(', ', $invalid)) . '.' : __('Something went wrong.');
            }
            if(is_user_logged_in() and !current_user_can('create_users')){
                return __('Sorry, you are not allowed to create new users.') . ' ' . __('You need a higher level of permission.');
            }
            return $output;
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public static function rwmb_meta_boxes($meta_boxes){
            $meta_boxes[] = [
                'fields' => [
                    [
    					'id' => '___signup_email_as_username',
    					'name' => 'Use email for username',
    					'options' => [
    						'no' => __('No'),
    						'yes' => __('Yes'),
    					],
    					'std' => 'no',
    					'type' => 'radio',
    				],
    				[
    					'desc' => 'Redirect URL, to which users will be redirected after successful registration.',
    					'id' => '___signup_redirect',
    					'name' => 'Redirect URL',
    					'placeholder' => home_url(),
    					'type' => 'url',
    				],
                    [
                        'id' => '___signup_role',
                        'name' => __('Role'),
                        'options' => wp_list_pluck(wp_roles()->roles, 'name'),
                        'std' => 'subscriber',
                        'type' => 'select_advanced',
                    ],
                ],
                'id' => '___signup',
                'post_types' => 'wpcf7_contact_form',
                'title' => __('Signup'),
                'visible' => ['___contact_form_type', 'signup'],
            ];
            return $meta_boxes;
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public static function wpcf7_before_send_mail($contact_form, $abort, $submission){
            if(get_post_meta($contact_form->id(), '___contact_form_type', true) != 'signup'){
                return;
            }
            $user_email = $submission->get_posted_data('user_email');
            if(!$user_email){
                return;
            }
            $user = get_user_by('email', $user_email);
            if($user){
                return;
            }
            if(get_post_meta($contact_form->id(), '___signup_email_as_username', true) == 'yes'){
                $user_login = $submission->get_posted_data('user_email');
            } else {
                $user_login = $submission->get_posted_data('user_login');
            }
            if(!$user_login){
                return;
            }
            $user = get_user_by('login', $user_login);
            if($user){
                return;
            }
            if(!validate_username($user_login)){
                return;
            }
            $illegal_user_logins = (array) apply_filters('illegal_user_logins', ['admin']);
            if(in_array(strtolower($user_login), array_map('strtolower', $illegal_user_logins), true)){
                return;
            }
            $user_password = $submission->get_posted_data('user_password');
            if(!$user_password){
                return;
            }
            if(strpos(wp_unslash($user_password), '\\') !== false){
                return;
            }
            $user_password_confirm = $submission->get_posted_data('user_password_confirm');
            if($user_password_confirm and $user_password_confirm != $user_password){
                return;
            }
    		if(is_user_logged_in() and !current_user_can('create_users')){
    			return;
    		}
    		$userdata = [
    			'role' => get_post_meta($contact_form->id(), '___signup_role', true),
    			'user_email' => wp_slash($user_email),
    			'user_login' => wp_slash($user_login),
    			'user_pass' => $user_password,
    		];
            $user_id = wp_insert_user($userdata);
            if(is_wp_error($user_id)){
                return;
            }
    		if(!is_user_logged_in()){
    			$remember = $submission->get_posted_data('remember');
    			wp_signon([
    				'remember' => $remember,
    				'user_login' => $user_login,
    				'user_password' => $user_password,
    			]);
    		}
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public static function wpcf7_validate_email($result, $tag){
            $contact_form = wpcf7_get_current_contact_form();
            if(!$contact_form){
                return $result;
            }
            $submission = WPCF7_Submission::get_instance();
            if(!$submission){
                return $result;
            }
            if(get_post_meta($contact_form->id(), '___contact_form_type', true) != 'signup'){
                return $result;
            }
            if($tag->name != 'user_email'){
                return $result;
            }
            $user_email = $submission->get_posted_data('user_email');
            if($user_email and wpcf7_is_email($user_email)){
                if(get_user_by('email', $user_email)){
                    $result->invalidate($tag, wp_strip_all_tags(__('<strong>Error</strong>: This email is already registered. Please choose another one.')));
                    return $result;
                }
                if(get_post_meta($contact_form->id(), '___signup_email_as_username', true) == 'yes'){
                    if(get_user_by('login', $user_email)){
                        $result->invalidate($tag, wp_strip_all_tags(__('<strong>Error</strong>: This username is already registered. Please choose another one.')));
                        return $result;
                    }
                }
            }
            return $result;
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public static function wpcf7_validate_text($result, $tag){
            $contact_form = wpcf7_get_current_contact_form();
            if(!$contact_form){
                return $result;
            }
            $submission = WPCF7_Submission::get_instance();
            if(!$submission){
                return $result;
            }
            if(get_post_meta($contact_form->id(), '___contact_form_type', true) != 'signup'){
                return $result;
            }
            if($tag->name != 'user_login'){
                return $result;
            }
            $user_login = $submission->get_posted_data('user_login');
            if($user_login){
                if(!validate_username($user_login)){
                    $result->invalidate($tag, wp_strip_all_tags(__('<strong>Error</strong>: This username is invalid because it uses illegal characters. Please enter a valid username.')));
                    return $result;
                }
                $illegal_user_logins = (array) apply_filters('illegal_user_logins', ['admin']);
                if(in_array(strtolower($user_login), array_map('strtolower', $illegal_user_logins), true)){
                    $result->invalidate($tag, wp_strip_all_tags(__('<strong>Error</strong>: Sorry, that username is not allowed.')));
                    return $result;
                }
                if(get_user_by('login', $user_login)){
                    $result->invalidate($tag, wp_strip_all_tags(__('<strong>Error</strong>: This username is already registered. Please choose another one.')));
                    return $result;
                }
            }
            return $result;
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public static function wpcf7_validate_password($result, $tag){
            $contact_form = wpcf7_get_current_contact_form();
            if(!$contact_form){
                return $result;
            }
            $submission = WPCF7_Submission::get_instance();
            if(!$submission){
                return $result;
            }
            if(get_post_meta($contact_form->id(), '___contact_form_type', true) != 'signup'){
                return $result;
            }
            switch($tag->name){
                case 'user_password':
                    $user_password = $submission->get_posted_data('user_password');
                    if($user_password and strpos(wp_unslash($user_password), '\\') !== false){
                        $result->invalidate($tag, wp_strip_all_tags(__('<strong>Error</strong>: Passwords may not contain the character "\\".')));
                        return $result;
                    }
                    break;
                case 'user_password_confirm':
                    $user_password_confirm = $submission->get_posted_data('user_password_confirm');
                    if($user_password_confirm and $user_password_confirm != $submission->get_posted_data('user_password')){
                        $result->invalidate($tag, wp_strip_all_tags(__('<strong>Error</strong>: Passwords don&#8217;t match. Please enter the same password in both password fields.')));
                        return $result;
                    }
                    break;
            }
            return $result;
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    }
}
