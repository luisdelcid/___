<?php

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___cf7')){
    function ___cf7(){
        if(!class_exists('___CF7')){
            require_once(plugin_dir_path(__FILE__) . 'class.php');
        }
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___cf7_login')){
    function ___cf7_login(){
        if(!class_exists('___CF7_Login')){
            require_once(plugin_dir_path(__FILE__) . 'class-login.php');
        }
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___cf7_signup')){
    function ___cf7_signup(){
        if(!class_exists('___CF7_Signup')){
            require_once(plugin_dir_path(__FILE__) . 'class-signup.php');
        }
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

___cf7();
___on('redirect_post_location', ['___CF7', 'redirect_post_location'], 10, 2);
___on('register_post_type_args', ['___CF7', 'register_post_type_args'], 10, 2);
___on('rwmb_meta_boxes', ['___CF7', 'rwmb_meta_boxes']);
___on('wp_enqueue_scripts', ['___CF7', 'wp_enqueue_scripts']);
___on('wpcf7_editor_panels', ['___CF7', 'wpcf7_editor_panels']);
___on('wpcf7_validate_password', ['___CF7', 'wpcf7_validate_password'], 10, 2);
___on('wpcf7_validate_password*', ['___CF7', 'wpcf7_validate_password'], 10, 2);

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

___cf7_login();
___on('do_shortcode_tag', ['___CF7_Login', 'do_shortcode_tag'], 10, 4);
___on('rwmb_meta_boxes', ['___CF7_Login', 'rwmb_meta_boxes']);
___on('wpcf7_before_send_mail', ['___CF7_Login', 'wpcf7_before_send_mail'], 10, 3);
___on('wpcf7_validate_email*', ['___CF7_Login', 'wpcf7_validate_email'], 10, 2);
___on('wpcf7_validate_text*', ['___CF7_Login', 'wpcf7_validate_text'], 10, 2);
___on('wpcf7_validate_password*', ['___CF7_Login', 'wpcf7_validate_password'], 10, 2);

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

___cf7_signup();
___on('do_shortcode_tag', ['___CF7_Signup', 'do_shortcode_tag'], 10, 4);
___on('rwmb_meta_boxes', ['___CF7_Signup', 'rwmb_meta_boxes']);
___on('wpcf7_before_send_mail', ['___CF7_Signup', 'wpcf7_before_send_mail'], 10, 3);
___on('wpcf7_validate_email*', ['___CF7_Signup', 'wpcf7_validate_email'], 10, 2);
___on('wpcf7_validate_text*', ['___CF7_Signup', 'wpcf7_validate_text'], 10, 2);
___on('wpcf7_validate_password*', ['___CF7_Signup', 'wpcf7_validate_password'], 10, 2);

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
