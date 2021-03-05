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
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___cf7_floating_labels')){
    function ___cf7_floating_labels(){
        if(!class_exists('___CF7_Floating_Labels')){
            require_once(plugin_dir_path(__FILE__) . 'class-floating-labels.php');
        }
        ___floating_labels();
        if(did_action('plugins_loaded')){
            ___CF7_Floating_Labels::plugins_loaded();
        } else {
            ___one('plugins_loaded', ['___CF7_Floating_Labels', 'plugins_loaded']);
        }
        ___one('wp_enqueue_scripts', ['___CF7_Floating_Labels', 'enqueue_scripts']);
        ___one('wpcf7_autop_or_not', '__return_false');
        ___one('wpcf7_init', ['___CF7_Floating_Labels', 'wpcf7_init']);
        ___one('wpcf7_validate_password', ['___CF7_Floating_Labels', 'wpcf7_validate_password'], 10, 2);
        ___one('wpcf7_validate_password*', ['___CF7_Floating_Labels', 'wpcf7_validate_password'], 10, 2);
        ___one('wpcf7_validate_radio*', 'wpcf7_checkbox_validation_filter', 10, 2);
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___cf7_login')){
    function ___cf7_login(){
        if(!class_exists('___CF7_Login')){
            require_once(plugin_dir_path(__FILE__) . 'class-login.php');
        }
        ___cf7();
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
        ___cf7();
        ___one('do_shortcode_tag', ['___CF7_Signup', 'do_shortcode_tag'], 10, 4);
        ___one('rwmb_meta_boxes', ['___CF7_Signup', 'rwmb_meta_boxes']);
        ___one('wpcf7_before_send_mail', ['___CF7_Signup', 'wpcf7_before_send_mail'], 10, 3);
        ___one('wpcf7_validate_email*', ['___CF7_Signup', 'wpcf7_validate_email'], 10, 2);
        ___one('wpcf7_validate_text*', ['___CF7_Signup', 'wpcf7_validate_text'], 10, 2);
        ___one('wpcf7_validate_password*', ['___CF7_Signup', 'wpcf7_validate_password'], 10, 2);
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
