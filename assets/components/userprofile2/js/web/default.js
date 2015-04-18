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
            $.jGrowl(message, {theme: 'up2-message-success', sticky: sticky});
        }
    }
    ,error: function(message, sticky) {
        if (sticky == null) {sticky = true;}
        if (message) {
            $.jGrowl(message, {theme: 'up2-message-error', sticky: sticky});
        }
    }
    ,info: function(message, sticky) {
        if (sticky == null) {sticky = false;}
        if (message) {
            $.jGrowl(message, {theme: 'up2-message-info', sticky: sticky});
        }
    }
    ,close: function() {
        $.jGrowl('close');
    }
};

userprofile2.initialize();

userprofile2.Hash = {
    get: function() {
        var vars = {},
            hash, splitter, hashes;
        if (!this.oldbrowser()) {
            var pos = window.location.href.indexOf('?');
            hashes = (pos != -1) ? decodeURIComponent(window.location.href.substr(pos + 1)) : '';
            splitter = '&';
        } else {
            hashes = decodeURIComponent(window.location.hash.substr(1));
            splitter = '/';
        }
        if (hashes.length == 0) {
            return vars;
        } else {
            hashes = hashes.split(splitter);
        }
        for (var i in hashes) {
            if (hashes.hasOwnProperty(i)) {
                hash = hashes[i].split('=');
                if (typeof hash[1] == 'undefined') {
                    vars['anchor'] = hash[0];
                } else {
                    vars[hash[0]] = hash[1];
                }
            }
        }
        return vars;
    },
    set: function(vars) {
        var hash = '';
        for (var i in vars) {
            if (vars.hasOwnProperty(i)) {
                hash += '&' + i + '=' + vars[i];
            }
        }
        if (!this.oldbrowser()) {
            if (hash.length != 0) {
                hash = '?' + hash.substr(1);
            }
            window.history.pushState(hash, '', document.location.pathname + hash);
        } else {
            window.location.hash = hash.substr(1);
        }
    },
    add: function(key, val) {
        var hash = this.get();
        hash[key] = val;
        this.set(hash);
    },
    remove: function(key) {
        var hash = this.get();
        delete hash[key];
        this.set(hash);
    },
    clear: function() {
        this.set({});
    },
    oldbrowser: function() {
        return false;
    }
};