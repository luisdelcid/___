<?php

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___')){
    function ___(){
        if(!class_exists('___')){
            require_once(plugin_dir_path(__FILE__) . 'class.php');
        }
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___add_admin_notice')){
    function ___add_admin_notice(){
        return call_user_func_array(['___', 'add_admin_notice'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___are_plugins_active')){
    function ___are_plugins_active(){
        return call_user_func_array(['___', 'are_plugins_active'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___array_keys_exist')){
    function ___array_keys_exist(){
        return call_user_func_array(['___', 'array_keys_exist'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___base64_urldecode')){
    function ___base64_urldecode(){
        return call_user_func_array(['___', 'base64_urldecode'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___base64_urlencode')){
    function ___base64_urlencode(){
        return call_user_func_array(['___', 'base64_urlencode'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___clone_role')){
    function ___clone_role(){
        return call_user_func_array(['___', 'clone_role'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___current_screen_in')){
    function ___current_screen_in(){
        return call_user_func_array(['___', 'current_screen_in'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___current_screen_is')){
    function ___current_screen_is(){
        return call_user_func_array(['___', 'current_screen_is'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___destroy_other_sessions')){
    function ___destroy_other_sessions(){
        return call_user_func_array(['___', 'destroy_other_sessions'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___did')){
    function ___did(){
        return call_user_func_array(['___', 'did'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___do')){
    function ___do(){
        return call_user_func_array(['___', 'do'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___download')){
    function ___download(){
        return call_user_func_array(['___', 'one'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___download_and_unzip')){
    function ___download_and_unzip(){
        return call_user_func_array(['___', 'download_and_unzip'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___download_and_upload')){
    function ___download_and_upload(){
        return call_user_func_array(['___', 'download_and_upload'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___error')){
    function ___error(){
        return call_user_func_array(['___', 'error'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___get_memory_size')){
    function ___get_memory_size(){
        return call_user_func_array(['___', 'get_memory_size'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___is_array_assoc')){
    function ___is_array_assoc(){
        return call_user_func_array(['___', 'is_array_assoc'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___is_doing_heartbeat')){
    function ___is_doing_heartbeat(){
        return call_user_func_array(['___', 'is_doing_heartbeat'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___is_plugin_active')){
    function ___is_plugin_active(){
        return call_user_func_array(['___', 'is_plugin_active'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___is_plugin_deactivating')){
    function ___is_plugin_deactivating(){
        return call_user_func_array(['___', 'is_plugin_deactivating'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___is_post_revision_or_auto_draft')){
    function ___is_post_revision_or_auto_draft(){
        return call_user_func_array(['___', 'is_post_revision_or_auto_draft'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___ksort_deep')){
    function ___ksort_deep(){
        return call_user_func_array(['___', 'ksort_deep'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___md5')){
    function ___md5(){
        return call_user_func_array(['___', 'md5'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___md5_to_uuid4')){
    function ___md5_to_uuid4(){
        return call_user_func_array(['___', 'md5_to_uuid4'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___off')){
    function ___off(){
        return call_user_func_array(['___', 'off'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___on')){
    function ___on(){
        return call_user_func_array(['___', 'on'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___one')){
    function ___one(){
		return call_user_func_array(['___', 'one'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___prepare')){
    function ___prepare(){
        return call_user_func_array(['___', 'prepare'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___post_type_labels')){
    function ___post_type_labels(){
        return call_user_func_array(['___', 'post_type_labels'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___remove_whitespaces')){
    function ___remove_whitespaces(){
        return call_user_func_array(['___', 'remove_whitespaces'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___request')){
    function ___request(){
		return call_user_func_array(['___', 'request'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___response')){
    function ___response(){
		return call_user_func_array(['___', 'response'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___response_error')){
    function ___response_error(){
		return call_user_func_array(['___', 'response_error'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___response_success')){
    function ___response_success(){
		return call_user_func_array(['___', 'response_success'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___sanitize_timeout')){
    function ___sanitize_timeout(){
		return call_user_func_array(['___', 'sanitize_timeout'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___seems_response')){
    function ___seems_response(){
        return call_user_func_array(['___', 'seems_response'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___seems_successful')){
    function ___seems_successful(){
        return call_user_func_array(['___', 'seems_successful'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___seems_wp_http_requests_response')){
    function ___seems_wp_http_requests_response(){
        return call_user_func_array(['___', 'seems_wp_http_requests_response'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___signon_without_password')){
    function ___signon_without_password(){
        return call_user_func_array(['___', 'signon_without_password'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___support_authorization_header')){
    function ___support_authorization_header(){
        return call_user_func_array(['___', 'support_authorization_header'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___upload')){
    function ___upload(){
        return call_user_func_array(['___', 'upload'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___upload_basedir')){
    function ___upload_basedir(){
        return call_user_func_array(['___', 'upload_basedir'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___upload_baseurl')){
    function ___upload_baseurl(){
        return call_user_func_array(['___', 'upload_baseurl'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___upload_tmpdir')){
    function ___upload_tmpdir(){
        return call_user_func_array(['___', 'upload_tmpdir'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___upload_tmpurl')){
    function ___upload_tmpurl(){
        return call_user_func_array(['___', 'upload_tmpurl'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
