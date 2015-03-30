userprofile2.panel.User = function(config) {
    config = config || {};

	var getSource = function(){
		return config.source || 1;
	};
    if(!config.type) {
        config.type = userprofile2.config.type;
    }
    if(!config.data) {
        config.data = userprofile2.config.data;
    }
    if(!userprofile2.utils.http(config.data.avatar)) {
        config.data.preview = MODx.config.connectors_url + 'system/phpthumb.php?h=193&w=308&zc=1&src=/' + config.data.avatar + '&wctx=MODx.ctx&source=' + getSource()
    }
    else {
		config.data.preview = config.data.avatar;
	}

    Ext.apply(config,{
        id: 'userprofile2-panel-user'
        ,border: false
        ,baseCls: 'modx-formpanel'
        ,layout: 'anchor'
        ,listeners: {
            afterRender: function(thisForm, options){
                var uf = Ext.getCmp('modx-panel-user');

                uf.addListener('success', function() {
                    this.successUserpanel(uf);
                }, this);
            }
        }
        ,items: [{
            html: '<p>'+_('up2_tabs_intro')+'</p>'
            ,border: false
            ,bodyCssClass: 'panel-desc'
        }, {
            layout: 'column'
            ,border: false
            ,bodyCssClass: 'tab-panel-wrapper '
            ,style: 'padding: 10px;'
            ,items: this.getItems(config)
        }]

    });
    userprofile2.panel.User.superclass.constructor.call(this,config);

    this.getTabs(userprofile2.config.tabsfields);
};
Ext.extend(userprofile2.panel.User,MODx.Panel, {

    successUserpanel: function(o) {
        var d = '';
        var f = Ext.getCmp('modx-panel-user').getForm();

        if(f.id) {
            d = Ext.util.JSON.encode($('#'+f.id).serializeJSON().up2);
        }
        MODx.Ajax.request({
            url: userprofile2.config.connector_url
            ,params: {
                action: 'mgr/profile/update'
                ,id: userprofile2.config.user
                ,data: d
            }
            ,listeners: {
                failure: {fn:function(r) {
                    Ext.Msg.alert();
                },scope:this}
            }
        });
    }

    ,getFielValue: function(tabName, fieldName, defaultValue) {
        var extend = userprofile2.config.extend;

        if(extend[tabName] && extend[tabName][fieldName] && (typeof extend[tabName][fieldName]!== 'object')) {
            value = extend[tabName][fieldName];
        }
        else {
            value = defaultValue;
        }

        return value;
    }

    ,getTabs: function(tf) {

        var tabs = Ext.getCmp('up2-extend-tabs');
        if((!tf) || (typeof tf!== 'object')) {return [];}

        for (keyTab in tf) {
            var tab = tf[keyTab];
            if((!tab) || (typeof tab!== 'object')) {continue;}

            var fields = tab['fields'];
            if((!fields) || (typeof fields!== 'object')) {continue;}

            var tabNameIn = tab['name_in'];
            var tabNameOut = tab['name_out'];
            var tabDescription = tab['description'];
            var tabFields = [];

            for (keyField in fields) {

                var item = fields[keyField];
                if((!item) || (typeof item!== 'object')) {continue;}

                var field = {
                    xtype: item['type_in'],
                    name: 'up2[' + tabNameOut + '][' + item['name_out'] + ']',
                    id: 'up2-extend-field-' + item['name_out'],
                    fieldLabel: item['name_in'],
                    disabled: !item['editable'],
                    allowBlank: !item['required'],
                    ctCls: 'up2_' + item['type_in'],
                    anchor: '100%',
                    value: this.getFielValue(tabNameOut, item['name_out'], item['value']) || item['value']
                };
                tabFields.push(field);
            }
            if(typeof tabFields!== 'object') {continue;}

            tabs.add({
                title: tabNameIn,
                items: tabFields,
                id: tabNameOut
            });
        }
        tabs.setActiveTab(0);
    }

    ,profileChangeType: function() {
        var type = Ext.getCmp('userprofile2-combo-profile-type');
        var newTab = [];
        MODx.Ajax.request({
            url: userprofile2.config.connector_url
            ,params: {
                action: 'mgr/misc/tabs-fields/getlist'
                ,type: type.value
            }
            ,listeners: {
                success: {fn:function(r) {
                    if(r.message) {

                        var tabs = Ext.getCmp('up2-extend-tabs');
                        userprofile2.config.tabsfields = Ext.util.JSON.decode(r.message);
                        tabs.removeAll();
                        this.getTabs(userprofile2.config.tabsfields);
                    }
                },scope:this}
            }
        });
    }

    ,getItems: function(config) {
        var items = [];

        items.push({
                columnWidth: .3,
                xtype: 'panel',
                border: false,
                layout: 'form',
                labelAlign: 'top',
                preventRender: true,
                items: [{
                    xtype: 'fieldset',
                    title: _('up2_fieldset_user'),
                    layoutConfig: { labelAlign: 'top'},
                    layout: 'column',
                    items:[{
                        columnWidth: 1,
                        xtype: 'panel',
                        border: false,
                        layout: 'form',
                        labelAlign: 'top',
                        preventRender: true,
                        items: [{
                            xtype: 'userprofile2-combo-profile-type',
                            id: 'userprofile2-combo-profile-type',
                            fieldLabel: _('up2_user_type'),
                            name: 'up2[type]',
                            hiddenName: 'up2[type]',
                            allowBlank: false,
                            anchor: '100%',
                            value: config.type,
                            listeners: {
                                select: {fn: function(r) { this.profileChangeType();},scope:this }
                            }
                        },{
                            xtype: 'userprofile2-combo-browser',
                            id: 'userprofile2-combo-browser',
                            fieldLabel: _('up2_avatar'),
                            name: 'photo',
                            anchor: '100%',
                            value: userprofile2.utils.http(config.data.avatar) ? '' : config.data.avatar
                        },{
                            html: ''
                            + '<div id="up2-avatar">'
                            + '<img src="' + config.data.preview +'" alt=""  class="up2-avatar">'
                            + '</div>'
                        }
                        ]

                    }
                    ]
                }, {
                    xtype: 'fieldset',
                    title: _('up2_fieldset_activity'),
                    layoutConfig: { labelAlign: 'top'},
                    layout: 'column',
                    items: [{
                        columnWidth: 1,
                        xtype: 'panel',
                        border: false,
                        layout: 'form',
                        labelAlign: 'top',
                        preventRender: true,
                        items:[
                            // { xtype: 'hidden', name: 'up2[type]', value: config.type}
                            { xtype: 'textfield', disabled: true, value: config.data.registration, fieldLabel: _('up2_user_registration'), anchor: '100%'}
                            ,{ xtype: 'textfield', disabled: true, value: config.data.lastactivity, fieldLabel: _('up2_user_lastactivity'), anchor: '100%'}
                            ,{ xtype: 'textfield', disabled: true, value: config.data.ip, fieldLabel: _('up2_user_ip'), anchor: '100%'}
                        ]}
                    ]

                }
                ]
            },
            {
                columnWidth: .7,
                xtype: 'panel',
                id: 'userprofile2-panel-profile',
                border: false,
                layout: 'form',
                labelAlign: 'left',
                preventRender: true,
                //items: this.getTabs(config)
                items: {
                    xtype: 'modx-tabs',
                    autoHeight: true,
                    deferredRender: false,
                    forceLayout: true,
                    id: 'up2-extend-tabs',
                    width: '99%',
                    bodyStyle: 'padding: 10px 0px 10px 0px;',
                    style: 'padding: 15px 25px 15px 15px;',
                    border: true,
                    defaults: {
                        border: false,
                        autoHeight: true,
                        layout: 'form',
                        deferredRender: false,
                        forceLayout: true,
                        labelAlign: 'top'
                    },
                    items: []
                }
            }
        );

        return items;
    }

});
Ext.reg('userprofile2-panel-user',userprofile2.panel.User);