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
        ___();
        return call_user_func_array(['___', 'add_admin_notice'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___are_plugins_active')){
    function ___are_plugins_active(){
        ___();
        return call_user_func_array(['___', 'are_plugins_active'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___array_keys_exist')){
    function ___array_keys_exist(){
        ___();
        return call_user_func_array(['___', 'array_keys_exist'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___base64_urldecode')){
    function ___base64_urldecode(){
        ___();
        return call_user_func_array(['___', 'base64_urldecode'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___base64_urlencode')){
    function ___base64_urlencode(){
        ___();
        return call_user_func_array(['___', 'base64_urlencode'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___clone_role')){
    function ___clone_role(){
        ___();
        return call_user_func_array(['___', 'clone_role'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___current_screen_in')){
    function ___current_screen_in(){
        ___();
        return call_user_func_array(['___', 'current_screen_in'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___current_screen_is')){
    function ___current_screen_is(){
        ___();
        return call_user_func_array(['___', 'current_screen_is'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___destroy_other_sessions')){
    function ___destroy_other_sessions(){
        ___();
        return call_user_func_array(['___', 'destroy_other_sessions'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___did')){
    function ___did(){
        ___();
        return call_user_func_array(['___', 'did'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___do')){
    function ___do(){
        ___();
        return call_user_func_array(['___', 'do'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___download')){
    function ___download(){
        ___();
        return call_user_func_array(['___', 'one'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___download_and_unzip')){
    function ___download_and_unzip(){
        ___();
        return call_user_func_array(['___', 'download_and_unzip'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___download_and_upload')){
    function ___download_and_upload(){
        ___();
        return call_user_func_array(['___', 'download_and_upload'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___error')){
    function ___error(){
        ___();
        return call_user_func_array(['___', 'error'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___get_memory_size')){
    function ___get_memory_size(){
        ___();
        return call_user_func_array(['___', 'get_memory_size'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___is_array_assoc')){
    function ___is_array_assoc(){
        ___();
        return call_user_func_array(['___', 'is_array_assoc'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___is_doing_heartbeat')){
    function ___is_doing_heartbeat(){
        ___();
        return call_user_func_array(['___', 'is_doing_heartbeat'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___is_plugin_active')){
    function ___is_plugin_active(){
        ___();
        return call_user_func_array(['___', 'is_plugin_active'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___is_plugin_deactivating')){
    function ___is_plugin_deactivating(){
        ___();
        return call_user_func_array(['___', 'is_plugin_deactivating'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___is_post_revision_or_auto_draft')){
    function ___is_post_revision_or_auto_draft(){
        ___();
        return call_user_func_array(['___', 'is_post_revision_or_auto_draft'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___ksort_deep')){
    function ___ksort_deep(){
        ___();
        return call_user_func_array(['___', 'ksort_deep'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___md5')){
    function ___md5(){
        ___();
        return call_user_func_array(['___', 'md5'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___md5_to_uuid4')){
    function ___md5_to_uuid4(){
        ___();
        return call_user_func_array(['___', 'md5_to_uuid4'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___off')){
    function ___off(){
        ___();
        return call_user_func_array(['___', 'off'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___on')){
    function ___on(){
        ___();
        return call_user_func_array(['___', 'on'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___one')){
    function ___one(){
        ___();
		return call_user_func_array(['___', 'one'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___prepare')){
    function ___prepare(){
        ___();
        return call_user_func_array(['___', 'prepare'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___post_type_labels')){
    function ___post_type_labels(){
        ___();
        return call_user_func_array(['___', 'post_type_labels'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___remove_whitespaces')){
    function ___remove_whitespaces(){
        ___();
        return call_user_func_array(['___', 'remove_whitespaces'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___request')){
    function ___request(){
        ___();
		return call_user_func_array(['___', 'request'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___require')){
    function ___require(){
        ___();
		return call_user_func_array(['___', 'require'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___response')){
    function ___response(){
        ___();
		return call_user_func_array(['___', 'response'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___response_error')){
    function ___response_error(){
        ___();
		return call_user_func_array(['___', 'response_error'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___response_success')){
    function ___response_success(){
        ___();
		return call_user_func_array(['___', 'response_success'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___sanitize_timeout')){
    function ___sanitize_timeout(){
        ___();
		return call_user_func_array(['___', 'sanitize_timeout'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___seems_response')){
    function ___seems_response(){
        ___();
        return call_user_func_array(['___', 'seems_response'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___seems_successful')){
    function ___seems_successful(){
        ___();
        return call_user_func_array(['___', 'seems_successful'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___seems_wp_http_requests_response')){
    function ___seems_wp_http_requests_response(){
        ___();
        return call_user_func_array(['___', 'seems_wp_http_requests_response'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___signon_without_password')){
    function ___signon_without_password(){
        ___();
        return call_user_func_array(['___', 'signon_without_password'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___support_authorization_header')){
    function ___support_authorization_header(){
        ___();
        return call_user_func_array(['___', 'support_authorization_header'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___upload')){
    function ___upload(){
        ___();
        return call_user_func_array(['___', 'upload'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___upload_basedir')){
    function ___upload_basedir(){
        ___();
        return call_user_func_array(['___', 'upload_basedir'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___upload_baseurl')){
    function ___upload_baseurl(){
        ___();
        return call_user_func_array(['___', 'upload_baseurl'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___upload_tmpdir')){
    function ___upload_tmpdir(){
        ___();
        return call_user_func_array(['___', 'upload_tmpdir'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('___upload_tmpurl')){
    function ___upload_tmpurl(){
        ___();
        return call_user_func_array(['___', 'upload_tmpurl'], func_get_args());
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
