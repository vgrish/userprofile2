userprofile2.Profile = {

    initialize: function(selector) {
        var elem = $(selector);
        if (!elem.length) {return false;}
        // Disable elements during ajax request
        $(document).ajaxStart(function() {
            elem.find('button, a, input, select, textarea').attr('disabled', true).addClass('tmp-disabled');
        })
            .ajaxStop(function() {
                elem.find('.tmp-disabled').attr('disabled', false);
            });
        $(document).on('click', '#userprofile2-user-photo-remove', function(e) {
            e.preventDefault();
            userprofile2.Profile.clearPhoto(elem);
            elem.submit();
            return false;
        });

        $(document).on('submit', selector, function(e) {
            $(this).ajaxSubmit({
                url: userprofile2Config.actionUrl
                ,dataType: 'json'
                ,beforeSubmit: function(data) {
                    userprofile2.Message.close();
                    $(selector + ' .desc').show();
                    $(selector + ' .message').text('');
                    $(selector + ' .has-error').removeClass('has-error');
                    data.push({name: 'action', value:'profile/update'});
                    //data.push({name: 'pageId', value: userprofile2Config.pageId});
                }
                ,success: function(response) {
                    var i;
                    if (response.success) {
                        userprofile2.Message.success(response.message);
                        userprofile2.Profile.clearPhoto(elem);
                        if (response.data) {
                            for (i in response.data) {
                                if (response.data.hasOwnProperty(i)) {
                                    $(selector + ' [name="'+i+'"]').val(response.data[i]);
                                    if (i == 'photo') {
                                        var $photo = $('#profile-user-photo');
                                        if (response.data[i] != '') {
                                            $photo.prop('src', response.data[i]);
                                            $('#userprofile2-user-photo-remove').show();
                                        }
                                        else {
                                            $photo.prop('src', $photo.data('gravatar'));
                                            $('#userprofile2-user-photo-remove').hide();
                                        }
                                    }
                                    else if (i == 'extended') {
                                        for (var i2 in response.data[i]) {
                                            if (response.data[i].hasOwnProperty(i2)) {
                                                $(selector + ' [name="extended['+i2+']"]').val(response.data[i][i2]);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                    else {

                        console.log('1');

                        userprofile2.Message.error(response.message, false);
                        if (response.data) {
                            for (i in response.data) {
                                if (response.data.hasOwnProperty(i)) {
                                    var $parent = $(selector + ' [name="'+i+'"]').parent();
                                    $parent.addClass('has-error');
                                    $parent.find('.desc').hide();
                                    $parent.find('.message').text(response.data[i]);
                                }
                            }
                        }
                    }
                }
            });
            return false;
        });

        return true;
    }

    ,clearPhoto: function(elem) {
        var $newphoto = elem.find('input[name="newphoto"]');
        $newphoto.val('').replaceWith($newphoto.clone(true));
        elem.find('input[name="photo"]').attr('value', '');
    }

};

userprofile2.Profile.initialize('#up2-user-edit');