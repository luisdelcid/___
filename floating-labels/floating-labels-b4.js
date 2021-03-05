
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(typeof ___floating_labels !== 'function'){
    function ___floating_labels(){
        if(jQuery('.___floating-labels > textarea').length){
            jQuery('.___floating-labels > textarea').each(function(){
                ___floating_labels_textarea(this);
            });
        }
        if(jQuery('.___floating-labels > select').length){
            jQuery('.___floating-labels > select').each(function(){
                ___floating_labels_select(this);
            });
        }
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(typeof ___floating_labels_select !== 'function'){
    function ___floating_labels_select(select){
        if(jQuery(select).val() == ''){
            jQuery(select).removeClass('placeholder-hidden');
        } else {
            jQuery(select).addClass('placeholder-hidden');
        }
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(typeof ___floating_labels_textarea !== 'function'){
    function ___floating_labels_textarea(textarea){
        jQuery(textarea).height(parseInt(jQuery(textarea).data('element'))).height(textarea.scrollHeight - parseInt(jQuery(textarea).data('padding')));
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(typeof ___page_visibility_event !== 'function'){
    function ___page_visibility_event(){
        'use strict';
        var visibilityChange = '';
        if(typeof document.hidden !== 'undefined'){ // Opera 12.10 and Firefox 18 and later support
            visibilityChange = 'visibilitychange';
        } else if(typeof document.webkitHidden !== 'undefined'){
            visibilityChange = 'webkitvisibilitychange';
        } else if(typeof document.msHidden !== 'undefined'){
            visibilityChange = 'msvisibilitychange';
        } else if(typeof document.mozHidden !== 'undefined'){ // Deprecated
            visibilityChange = 'mozvisibilitychange';
        }
        return visibilityChange;
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(typeof ___page_visibility_state !== 'function'){
    function ___page_visibility_state(){
        'use strict';
        var hidden = '';
        if(typeof document.hidden !== 'undefined'){ // Opera 12.10 and Firefox 18 and later support
            hidden = 'hidden';
        } else if(typeof document.webkitHidden !== 'undefined'){
            hidden = 'webkitHidden';
        } else if(typeof document.msHidden !== 'undefined'){
            hidden = 'msHidden';
        } else if(typeof document.mozHidden !== 'undefined'){ // Deprecated
            hidden = 'mozHidden';
        }
        return document[hidden];
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

jQuery(function($){
    if($('.___floating-labels > textarea').length){
        $('.___floating-labels > textarea').each(function(){
            $(this).data({
                'border': $(this).outerHeight() - $(this).innerHeight(),
                'element': $(this).height(),
                'padding': $(this).innerHeight() - $(this).height(),
            });
        });
    }
    ___floating_labels();
    if($('.___floating-labels > textarea').length){
        $('.___floating-labels > textarea').on('input propertychange', function(){
            ___floating_labels_textarea(this);
        });
    }
    if($('.___floating-labels > select').length){
        $('.___floating-labels > select').on('change', function(){
            ___floating_labels_select(this);
        });
    }
    $(document).on(___page_visibility_event(), ___floating_labels);
});

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
