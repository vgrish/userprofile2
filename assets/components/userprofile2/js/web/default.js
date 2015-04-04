userprofile2 = {
    initialize: function() {

        if(!jQuery().ajaxForm) {
            document.write('<script src="'+userprofile2Config.jsUrl+'lib/jquery.form.min.js"><\/script>');
        }
        if(!jQuery().jGrowl) {
            document.write('<script src="'+userprofile2Config.jsUrl+'lib/jquery.jgrowl.min.js"><\/script>');
        }

        $(document).ready(function() {
            $.jGrowl.defaults.closerTemplate = '<div>[ '+userprofile2Config.close_all_message+' ]</div>';
        });
    }

};

userprofile2.Message = {
    success: function(message, sticky) {
        if (sticky == null) {sticky = false;}
        if (message) {
            $.jGrowl(message, {theme: 'userprofile2-message-success', sticky: sticky});
        }
    }
    ,error: function(message, sticky) {
        if (sticky == null) {sticky = true;}
        if (message) {
            $.jGrowl(message, {theme: 'userprofile2-message-error', sticky: sticky});
        }
    }
    ,info: function(message, sticky) {
        if (sticky == null) {sticky = false;}
        if (message) {
            $.jGrowl(message, {theme: 'userprofile2-message-info', sticky: sticky});
        }
    }
    ,close: function() {
        $.jGrowl('close');
    }
};

userprofile2.initialize();