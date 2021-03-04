<?php

if(!class_exists('___CF7')){
    final class ___CF7 {

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        //
        // private
        //
        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        private static function is_edit(){
            global $pagenow;
            if(empty($pagenow) or $pagenow != 'post.php'){
                return false;
            }
        	if(empty($_GET['post'])){
        		return false;
        	}
        	$post = get_post($_GET['post']);
        	if(empty($post) or $post->post_type != 'wpcf7_contact_form'){
        		return false;
        	}
        	if(empty($_GET['action']) or $_GET['action'] != 'edit'){
        		return false;
        	}
        	if(empty($_GET['_wpnonce'])){
        		return false;
        	}
        	return wp_verify_nonce($_GET['_wpnonce'], '___edit_' . $post->ID);
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        //
        // public
        //
        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public static function redirect_post_location($location, $post_id){
            if(get_post_type($post_id) == 'wpcf7_contact_form'){
                $referer = wp_get_referer();
                if($referer){
                    $location = add_query_arg('message', 1, $referer);
                }
            }
            return $location;
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public static function register_post_type_args($args, $post_type){
            if($post_type == 'wpcf7_contact_form'){
        		if(self::is_edit()){
        			$args['show_in_menu'] = false;
        			$args['show_ui'] = true;
        			$args['supports'] = ['title'];
        		}
        	}
            return $args;
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public static function rwmb_meta_boxes($meta_boxes){
            global $pagenow;
    		$fields = [
    			[
    				'id' => '___contact_form_type',
    				'name' => __('Type'),
    				'options' => [
    					'contact_form' => __('Contact Form', 'contact-form-7'),
    					'login' => __('Log in'),
    					'signup' => __('Signup'),
    				],
    				'std' => 'contact_form',
    				'type' => 'radio',
    			],
    			[
    				'desc' => 'Redirect URL, to which users will be redirected after successful submission.',
    				'id' => '___redirect',
    				'name' => 'Redirect URL',
    				'type' => 'url',
    				'visible' => ['___contact_form_type', 'contact_form'],
    			],
    		];
    		if(self::is_edit()){
    			$fields[] = [
    				'std' => '<style>#minor-publishing, .page-title-action, #delete-action { display: none !important; } #major-publishing-actions { border-top: 0 !important; }</style><a href="' . admin_url('admin.php?page=wpcf7&post=' . $_GET['post'] . '&action=edit&active-tab=' . (isset($_GET['active-tab']) ? $_GET['active-tab'] : '')) . '">&larr; ' . __('Go back') . '</a>',
    				'type' => 'custom_html',
    			];
    		}
    		$meta_boxes[] = [
    			'fields' => $fields,
    			'id' => '___',
    			'post_types' => 'wpcf7_contact_form',
    			'title' => '___',
    		];
            return $meta_boxes;
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public static function wp_enqueue_scripts(){
            $redirects = [];
        	$ids = get_posts([
        		'fields' => 'ids',
        		'post_type' => 'wpcf7_contact_form',
        		'posts_per_page' => -1,
        	]);
            if($ids){
        		foreach($ids as $id){
        			switch(get_post_meta($id, '___contact_form_type', true)){
        				case 'contact_form':
        					$redirect = get_post_meta($id, '___redirect', true);
        					if($redirect){
        						$redirects[$id] = $redirect;
        					}
        					break;
        				case 'signup':
        					$redirect = get_post_meta($id, '___signup_redirect', true);
        					if(!$redirect){
        						$redirect = home_url();
        					}
        					$redirects[$id] = $redirect;
        					break;
        				case 'login':
        					$redirect = get_post_meta($id, '___login_redirect', true);
        					if(!$redirect){
        						$redirect = home_url();
        					}
        					$redirects[$id] = $redirect;
        					break;
        			}
        		}
        	}
            if($redirects){
        		$data = "var ___redirects = " . wp_json_encode($redirects) . ";
jQuery('.wpcf7').on('wpcf7mailsent wpcf7mailfailed', function(event){
	if(typeof ___redirects[event.detail.contactFormId] != 'undefined'){
		jQuery(location).attr('href', ___redirects[event.detail.contactFormId]);
	}
});";
        		wp_add_inline_script('contact-form-7', $data);
        	}
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public static function wpcf7_editor_panels($panels){
            if(empty($panels['___'])){
                $active_tab = count($panels);
                $panels['___'] = [
                    'callback' => function($contact_form) use($active_tab){
                        $html = '<h2>' . __('Edit') . '</h2>';
                        $html .= '<fieldset>';
                        $html .= '<legend>';
                        if($contact_form->id()){
        					$nonce_url = wp_nonce_url(admin_url('post.php?post=' . $contact_form->id() . '&action=edit&active-tab=' . $active_tab), '___edit_' . $contact_form->id());
                            $html .= '<a href="' . $nonce_url . '">' . __('Edit This') . ' &rarr;</a>';
                        } else {
                            $html .= __('Save Changes') . ' &rarr;';
                        }
                        $html .= '</legend>';
                        $html .= '</fieldset>';
                        echo $html;
                    },
                    'title' => '___',
                ];
            }
            return $panels;
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public static function wpcf7_password_validation_filter($result, $tag){
            $name = $tag->name;
            $value = isset($_POST[$name]) ? trim(wp_unslash(strtr((string) $_POST[$name], "\n", ' '))) : '';
            if('password' == $tag->basetype){
                if($tag->is_required() and '' === $value){
                    $result->invalidate($tag, wpcf7_get_message('invalid_required'));
                }
            }
            $result = wpcf7_text_validation_filter($result, $tag);
            return $result;
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    }
}
