<?php

if(!class_exists('___CF7_Login')){
    final class ___CF7_Login {

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        //
        // public
        //
        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public static function contact_form_types($contact_form_types){
            $contact_form_types['login'] = __('Log in');
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
            if(get_post_meta($contact_form->id(), '___contact_form_type', true) != 'login'){
                return $output;
            }
            $invalid = [];
            $missing = [];
            $tags = wp_list_pluck($contact_form->scan_form_tags(), 'type', 'name');
            if(get_post_meta($contact_form->id(), '___login_email_as_username', true) == 'yes'){
                if(empty($tags['user_email'])){
                    $missing[] = 'user_email';
                }
            } else {
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
            if(get_post_meta($contact_form->id(), '___login_email_as_username', true) == 'yes'){
                if($tags['user_email'] != 'email*'){
                    $invalid[] = 'user_email';
                }
            } else {
                if($tags['user_login'] != 'text*'){
                    $invalid[] = 'user_login';
                }
            }
            if($tags['user_password'] != 'password*'){
                $invalid[] = 'user_password';
            }
            if($invalid){
                return current_user_can('manage_options') ? sprintf(__('Invalid parameter(s): %s'), implode(', ', $invalid)) . '.' : __('Something went wrong.');
            }
            if(is_user_logged_in()){
                return __('You are logged in already. No need to register again!');
            }
            return $output;
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public static function rwmb_meta_boxes($meta_boxes){
            $meta_boxes[] = [
                'fields' => [
    				[
    					'id' => '___login_email_as_username',
    					'name' => 'Use email for username',
    					'options' => [
    						'no' => __('No'),
    						'yes' => __('Yes'),
    					],
    					'std' => 'no',
    					'type' => 'radio',
    				],
    				[
    					'desc' => 'Redirect URL, to which users will be redirected after successful login.',
    					'id' => '___login_redirect',
    					'name' => 'Redirect URL',
    					'placeholder' => home_url(),
    					'type' => 'url',
    				],
                ],
                'id' => '___login',
                'post_types' => 'wpcf7_contact_form',
                'title' => __('Log in'),
                'visible' => ['___contact_form_type', 'login'],
            ];
            return $meta_boxes;
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public static function wpcf7_before_send_mail($contact_form, $abort, $submission){
            if(get_post_meta($contact_form->id(), '___contact_form_type', true) != 'login'){
                return;
            }
            if(is_user_logged_in()){
                return;
            }
            if(get_post_meta($contact_form->id(), '___login_email_as_username', true) == 'yes'){
                $user_email = $submission->get_posted_data('user_email');
                if(!$user_email){
                    return;
                }
                $user = get_user_by('email', $user_email);
                if(!$user){
                    return;
                }
            } else {
                $user_login = $submission->get_posted_data('user_login');
                if(!$user_login){
                    return;
                }
                if(is_email($user_login)){
                    $user = get_user_by('email', $user_login);
                } else {
                    $user = get_user_by('login', $user_login);
                }
                if(!$user){
                    return;
                }
            }
            $user_password = $submission->get_posted_data('user_password');
            if(!$user_password){
                return;
            }
            if(!wp_check_password($user_password, $user->data->user_pass, $user->ID)){
                return;
            }
            $remember = $submission->get_posted_data('remember');
            wp_signon([
                'remember' => $remember,
                'user_login' => $user->user_login,
                'user_password' => $user_password,
            ]);
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
            if(get_post_meta($contact_form->id(), '___contact_form_type', true) != 'login'){
                return $result;
            }
            if($tag->name != 'user_email'){
                return $result;
            }
            if(get_post_meta($contact_form->id(), '___login_email_as_username', true) == 'yes'){
                $user_email = $submission->get_posted_data('user_email');
                if($user_email and wpcf7_is_email($user_email)){
                    $user = get_user_by('email', $user_email);
                    if(!$user){
                        $message = __('Unknown email address. Check again or try your username.');
                        $message = explode('.', $message);
                        $message = $message[0] . '.';
                        $result->invalidate($tag, wp_strip_all_tags($message));
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
            if(get_post_meta($contact_form->id(), '___contact_form_type', true) != 'login'){
                return $result;
            }
            if($tag->name != 'user_login'){
                return $result;
            }
            $user_login = $submission->get_posted_data('user_login');
            if($user_login){
                if(is_email($user_login)){
                    $message = __('Unknown email address. Check again or try your username.');
                    $user = get_user_by('email', $user_login);
                } else {
                    $message = __('Unknown username. Check again or try your email address.');
                    $user = get_user_by('login', $user_login);
                }
                if(!$user){
                    $result->invalidate($tag, wp_strip_all_tags($message));
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
            if(get_post_meta($contact_form->id(), '___contact_form_type', true) != 'login'){
                return $result;
            }
            if($tag->name != 'user_password'){
                return $result;
            }
            $user = false;
            if(get_post_meta($contact_form->id(), '___login_email_as_username', true) == 'yes'){
                $user_email = $submission->get_posted_data('user_email');
                if($user_email and wpcf7_is_email($user_email)){
                    $message = sprintf(__('<strong>Error</strong>: The password you entered for the email address %s is incorrect.'), '<strong>' . $user_email . '</strong>');
                    $user = get_user_by('email', $user_email);
                }
            } else {
                $user_login = $submission->get_posted_data('user_login');
                if($user_login){
                    if(is_email($user_login)){
                        $message = sprintf(__('<strong>Error</strong>: The password you entered for the email address %s is incorrect.'), '<strong>' . $user_login . '</strong>');
                        $user = get_user_by('email', $user_login);
                    } else {
                        $message = sprintf(__('<strong>Error</strong>: The password you entered for the username %s is incorrect.'), '<strong>' . $user_login . '</strong>');
                        $user = get_user_by('login', $user_login);
                    }
                }
            }
            if($user){
                $user_password = $submission->get_posted_data('user_password');
                if($user_password){
                    if(!wp_check_password($user_password, $user->data->user_pass, $user->ID)){
                        $result->invalidate($tag, wp_strip_all_tags($message));
                        return $result;
                    }
                }
            }
            return $result;
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    }
}
