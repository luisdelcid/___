<?php

if(!class_exists('___CF7_Floating_Labels')){
    final class ___CF7_Floating_Labels {

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        //
        // private
        //
        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        private static function browse($tag = null, $fallback = ''){
			if($tag->has_option('___browse')){
                return $tag->get_option('___browse', '', true);
            }
            if(!$fallback){
                $fallback = __('Select');
            }
            return $fallback;
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        private static function checkbox($html = '', $tag = null){
            $html = ___simple_html_dom_str_get_html($html);
			$type = (in_array($tag->basetype, ['checkbox', 'radio']) ? $tag->basetype : 'checkbox');
			foreach($html->find('.wpcf7-list-item') as $li){
				$li->addClass('custom-control custom-' . $type);
				if(self::inline($tag)){
                    $li->addClass('custom-control-inline');
                }
				$input = $li->find('input', 0);
				$input->addClass('custom-control-input');
				$input->id = $tag->name . '_' . sanitize_title($input->value);
				$label = $li->find('.wpcf7-list-item-label', 0);
				$label->addClass('custom-control-label');
				$label->for = $input->id;
				$label->tag = 'label';
				$li->innertext = $input->outertext . $label->outertext;
			}
            return $html;
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        private static function file($html = '', $tag = null){
            $html = ___simple_html_dom_str_get_html($html);
            $wrapper = $html->find('.wpcf7-form-control-wrap', 0);
            $wrapper->addClass('custom-file');
            $input = $wrapper->find('input', 0);
            $input->addClass('custom-file-input');
			$input->id = $tag->name;
            $input->outertext = $input->outertext . '<label class="custom-file-label" for="' . $input->id . '" data-browse="' . self::browse($tag) . '">' . self::label($tag) . '</label>';
        	return $html;
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        private static function floating_labels($tag = null, $fallback = true){
            if($tag->has_option('___floating_labels')){
                $floating_labels = $tag->get_option('___floating_labels', '', true);
				return (in_array($floating_labels, ['off', 'false']) ? false : boolval($floating_labels));
            }
            return $fallback;
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        private static function inline($tag = null, $fallback = false){
            if($tag->has_option('___inline')){
                $inline = $tag->get_option('___inline', '', true);
				return (in_array($inline, ['off', 'false']) ? false : boolval($inline));
            }
            return $fallback;
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        private static function is_text($type){
			return in_array($type, self::text_fields());
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        private static function label($tag = null, $fallback = ''){
			if($tag->has_option('___label')){
                return $tag->get_option('___label', '', true);
            }
            if(!$fallback){
                $fallback = __('Select Files');
            }
            return $fallback;
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        private static function placeholder($tag = null, $fallback = ''){
            switch(true){
                case self::is_text($tag->type):
                    if($tag->has_option('placeholder') or $tag->has_option('watermark')){
                        if($tag->values){
                            return reset($tag->values);
                        }
                    }
                    break;
                case $tag->basetype == 'select':
                    if($tag->has_option('first_as_label')){
                        if($tag->values){
                            return reset($tag->values);
                        }
                    }
                    break;
            }
            return $fallback;
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        private static function select($html = '', $tag = null){
            $html = ___simple_html_dom_str_get_html($html);
            $floating_labels = self::floating_labels($tag);
            $placeholder = self::placeholder($tag);
            if($floating_labels and $placeholder){
                $wrapper = $html->find('.wpcf7-form-control-wrap', 0);
                $wrapper->addClass('___floating-labels');
                $select = $wrapper->find('select', 0);
                $select->addClass('custom-select');
                $option = $select->find('option', 0);
				$option->innertext = '';
                $select->outertext = $select->outertext . '<label>' . $placeholder . '</label>';
            } else {
                $wrapper = $html->find('.wpcf7-form-control-wrap', 0);
                $select = $wrapper->find('select', 0);
                $select->addClass('custom-select');
                $size = self::size($tag);
                if($size){
                    $select->addClass('custom-select-' . $size);
                }
            }
            return $html;
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        private static function size($tag = null, $fallback = ''){
            if($tag->has_option('___size')){
                $size = $tag->get_option('___size', '', true);
                if(in_array($size, ['sm', 'md', 'lg'])){
                    return ($size === 'md' ? '' : $size);
                }
            }
            return $fallback;
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        private static function text($html = '', $tag = null){
            $html = ___simple_html_dom_str_get_html($html);
            $floating_labels = self::floating_labels($tag);
            $placeholder = self::placeholder($tag);
            if($floating_labels and $placeholder){
                $wrapper = $html->find('.wpcf7-form-control-wrap', 0);
                $wrapper->addClass('___floating-labels');
                $input = $wrapper->find('input', 0);
                $input->addClass('form-control');
                $input->outertext = $input->outertext . '<label>' . $placeholder . '</label>';
            } else {
                $wrapper = $html->find('.wpcf7-form-control-wrap', 0);
                $input = $wrapper->find('input', 0);
                $input->addClass('form-control');
                $size = self::size($tag);
                if($size){
                    $input->addClass('form-control-' . $size);
                }
            }
            return $html;
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        private static function text_fields(){
			return ['text', 'text*', 'email', 'email*', 'url', 'url*', 'tel', 'tel*', 'textarea', 'textarea*', 'password', 'password*'];
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        private static function textarea($html = '', $tag = null){
            $html = ___simple_html_dom_str_get_html($html);
            $floating_labels = self::floating_labels($tag);
            $placeholder = self::placeholder($tag);
            if($floating_labels and $placeholder){
                $wrapper = $html->find('.wpcf7-form-control-wrap', 0);
                $wrapper->addClass('___floating-labels');
                $textarea = $wrapper->find('textarea', 0);
                $textarea->addClass('form-control');
                $textarea->cols = null;
				$textarea->rows = null;
                $textarea->outertext = $textarea->outertext . '<label>' . $placeholder . '</label>';
            } else {
                $wrapper = $html->find('.wpcf7-form-control-wrap', 0);
                $textarea = $wrapper->find('textarea', 0);
                $textarea->addClass('form-control');
                $size = self::size($tag);
                if($size){
                    $textarea->addClass('form-control-' . $size);
                }
            }
            return $html;
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        //
        // public
        //
        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public static function plugins_loaded(){
            ___off('wpcf7_init', 'wpcf7_add_form_tag_acceptance');
            ___off('wpcf7_init', 'wpcf7_add_form_tag_checkbox');
            ___off('wpcf7_init', 'wpcf7_add_form_tag_date');
            ___off('wpcf7_init', 'wpcf7_add_form_tag_file');
            ___off('wpcf7_init', 'wpcf7_add_form_tag_number');
            ___off('wpcf7_init', 'wpcf7_add_form_tag_select');
            ___off('wpcf7_init', 'wpcf7_add_form_tag_text');
            ___off('wpcf7_init', 'wpcf7_add_form_tag_textarea');
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public static function wp_enqueue_scripts(){
            wp_enqueue_script('___cf7_floating-labels-b4', plugin_dir_url(__FILE__) . 'floating-labels-b4.js', ['jquery'], filemtime(plugin_dir_path(__FILE__) . 'floating-labels-b4.js'), true);
            wp_enqueue_style('___cf7_floating-labels-b4', plugin_dir_url(__FILE__) . 'floating-labels-b4.css', [], filemtime(plugin_dir_path(__FILE__) . 'floating-labels-b4.css'));
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public static function wpcf7_init(){
			 wpcf7_add_form_tag('acceptance', function($tag){
                $html = wpcf7_acceptance_form_tag_handler($tag);
                return self::checkbox($html, $tag);
            }, [
        		'name-attr' => true,
        	]);
            wpcf7_add_form_tag(['checkbox', 'checkbox*', 'radio', 'radio*'], function($tag){
                $html = wpcf7_checkbox_form_tag_handler($tag);
                return self::checkbox($html, $tag);
            }, [
        		'name-attr' => true,
				'multiple-controls-container' => true,
                'selectable-values' => true,
        	]);
			wpcf7_add_form_tag(['date', 'date*'], function($tag){
                $html = wpcf7_date_form_tag_handler($tag);
                return self::text($html, $tag);
            }, [
        		'name-attr' => true,
        	]);
			wpcf7_add_form_tag(['file', 'file*'], function($tag){
                $html = wpcf7_file_form_tag_handler($tag);
                return self::file($html, $tag);
            }, [
                'file-uploading' => true,
                'name-attr' => true,
        	]);
			wpcf7_add_form_tag(['number', 'number*'], function($tag){
                $html = wpcf7_number_form_tag_handler($tag);
				return self::text($html, $tag);
            }, [
        		'name-attr' => true,
        	]);
			wpcf7_add_form_tag(['range', 'range*'], function($tag){
                return wpcf7_number_form_tag_handler($tag);
            }, [
        		'name-attr' => true,
        	]);
			wpcf7_add_form_tag(['select', 'select*'], function($tag){
                $html = wpcf7_select_form_tag_handler($tag);
                return self::select($html, $tag);
            }, [
        		'name-attr' => true,
                'selectable-values' => true,
        	]);
            wpcf7_add_form_tag(self::text_fields(), function($tag){
                $html = wpcf7_text_form_tag_handler($tag);
                return self::text($html, $tag);
            }, [
        		'name-attr' => true,
        	]);
            wpcf7_add_form_tag(['textarea', 'textarea*'], function($tag){
                $html = wpcf7_textarea_form_tag_handler($tag);
                return self::textarea($html, $tag);
            }, [
        		'name-attr' => true,
        	]);
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public static function wpcf7_validate_password($result, $tag){
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
