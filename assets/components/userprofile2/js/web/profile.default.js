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
        $(document).on('click', '#up2-remove-avatar', function(e) {
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
                }
                ,success: function(response) {
                    var i;
                    if (response.success) {
                        userprofile2.Message.success(response.message);
                        //userprofile2.Profile.clearPhoto(elem);
                        if (response.data) {
                            for (i in response.data) {
                                if (response.data.hasOwnProperty(i)) {
                                    $(selector + ' [name="'+i+'"]').val(response.data[i]);
                                    if (i == 'removeavatar') {
										var $photo = $('#up2-avatar');
										if (response.data[i] == '1') {
											$photo.prop('src', $photo.data('gravatar'));
											$('#up2-remove-avatar').hide();
										}
										if (response.data[i] != '1') {
											$photo.prop('src', response.data[i]);
											$('#up2-remove-avatar').show();
											$('input[name="removephoto"]').attr('value', '');
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
        elem.find('input[name="removephoto"]').attr('value', 1);
    }

};

userprofile2.Profile.initialize('#up2-user-edit');