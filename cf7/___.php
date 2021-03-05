<?php

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___cf7')){
    function ___cf7(){
        if(!class_exists('___CF7')){
            require_once(plugin_dir_path(__FILE__) . 'class.php');
        }
        ___one('redirect_post_location', ['___CF7', 'redirect_post_location'], 10, 2);
        ___one('register_post_type_args', ['___CF7', 'register_post_type_args'], 10, 2);
        ___one('rwmb_meta_boxes', ['___CF7', 'rwmb_meta_boxes']);
        ___one('wp_enqueue_scripts', ['___CF7', 'wp_enqueue_scripts']);
        ___one('wpcf7_editor_panels', ['___CF7', 'wpcf7_editor_panels']);
        ___one('wpcf7_validate_password', ['___CF7', 'wpcf7_validate_password'], 10, 2);
        ___one('wpcf7_validate_password*', ['___CF7', 'wpcf7_validate_password'], 10, 2);
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___cf7_login')){
    function ___cf7_login(){
        if(!class_exists('___CF7_Login')){
            require_once(plugin_dir_path(__FILE__) . 'class-login.php');
        }
        ___one('do_shortcode_tag', ['___CF7_Login', 'do_shortcode_tag'], 10, 4);
        ___one('rwmb_meta_boxes', ['___CF7_Login', 'rwmb_meta_boxes']);
        ___one('wpcf7_before_send_mail', ['___CF7_Login', 'wpcf7_before_send_mail'], 10, 3);
        ___one('wpcf7_validate_email*', ['___CF7_Login', 'wpcf7_validate_email'], 10, 2);
        ___one('wpcf7_validate_text*', ['___CF7_Login', 'wpcf7_validate_text'], 10, 2);
        ___one('wpcf7_validate_password*', ['___CF7_Login', 'wpcf7_validate_password'], 10, 2);
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___cf7_signup')){
    function ___cf7_signup(){
        if(!class_exists('___CF7_Signup')){
            require_once(plugin_dir_path(__FILE__) . 'class-signup.php');
        }
        ___one('do_shortcode_tag', ['___CF7_Signup', 'do_shortcode_tag'], 10, 4);
        ___one('rwmb_meta_boxes', ['___CF7_Signup', 'rwmb_meta_boxes']);
        ___one('wpcf7_before_send_mail', ['___CF7_Signup', 'wpcf7_before_send_mail'], 10, 3);
        ___one('wpcf7_validate_email*', ['___CF7_Signup', 'wpcf7_validate_email'], 10, 2);
        ___one('wpcf7_validate_text*', ['___CF7_Signup', 'wpcf7_validate_text'], 10, 2);
        ___one('wpcf7_validate_password*', ['___CF7_Signup', 'wpcf7_validate_password'], 10, 2);
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
