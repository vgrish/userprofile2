userprofile2.page.Settings = function(config) {
    config = config || {};
    Ext.applyIf(config, {
        components: [{
            xtype: 'userprofile2-panel-settings'
            , renderTo: 'userprofile2-panel-settings-div'
        }]
    });
    userprofile2.page.Settings.superclass.constructor.call(this, config);
};
Ext.extend(userprofile2.page.Settings, MODx.Component);
Ext.reg('userprofile2-page-settings', userprofile2.page.Settings);

userprofile2.panel.Settings = function(config) {
    config = config || {};
    Ext.apply(config, {
        border: false
        , deferredRender: true
        , baseCls: 'modx-formpanel'
        , items: [{
            html: '<h2>' + _('userprofile2') + ' :: ' + _('up2_settings') + '</h2>'
            , border: false
            , cls: 'modx-page-header container'
        }, {
            xtype: 'modx-tabs'
            , id: 'userprofile2-settings-type-tab'
            , bodyStyle: 'padding: 10px'
            , defaults: {border: false, autoHeight: true}
            , border: true
            , hideMode: 'offsets'

			//

            , items: [{
				title: _('up2_type_field')
				, items: [{
					html: '<p>' + _('up2_type_field_intro') + '</p>'
					, border: false
					, bodyCssClass: 'panel-desc'
					, bodyStyle: 'margin-bottom: 10px'
				}, {
					xtype: 'userprofile2-grid-type-field'
				}]
			},{
                title: _('up2_type_tab')
                , items: [{
                    html: '<p>' + _('up2_type_tab_intro') + '</p>'
                    , border: false
                    , bodyCssClass: 'panel-desc'
                    , bodyStyle: 'margin-bottom: 10px'
                }, {
                    xtype: 'userprofile2-grid-type-tab'
                }]
            },{
				title: _('up2_type_profile')
				, items: [{
					html: '<p>' + _('up2_type_profile_intro') + '</p>'
					, border: false
					, bodyCssClass: 'panel-desc'
					, bodyStyle: 'margin-bottom: 10px'
				}, {
					xtype: 'userprofile2-grid-type-profile'
				}]
			},{
                title: _('up2_setting')
                , items: [{
                    html: '<p>' + _('up2_setting_intro') + '</p>'
                    , border: false
                    , bodyCssClass: 'panel-desc'
                    , bodyStyle: 'margin-bottom: 10px'
                }, {
                    xtype: 'userprofile2-grid-setting'
                }]
            }, {
                title: _('up2_lexicon')
                , items: [{
                    html: '<p>' + _('up2_lexicon_intro') + '</p>'
                    , border: false
                    , bodyCssClass: 'panel-desc'
                    , bodyStyle: 'margin-bottom: 10px'
                }, {
                    //xtype: 'userprofile2-grid-lexicon'
                }]
            }

            ]

        }]
    });
    userprofile2.panel.Settings.superclass.constructor.call(this, config);
};
Ext.extend(userprofile2.panel.Settings, MODx.Panel);
Ext.reg('userprofile2-panel-settings', userprofile2.panel.Settings);