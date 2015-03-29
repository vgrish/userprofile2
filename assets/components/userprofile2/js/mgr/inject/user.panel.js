userprofile2.panel.User = function(config) {
    config = config || {};

	var http =  function(uri) {
		return /^(https?|ftp)\:\/\/[a-zA-Z0-9\.\-]+\.[a-z]{2,}(\/.+)$/.test(uri);
	};
	var getSource = function(){
		return config.source || 1;
	};

	if(!config.avatar) {
		config.avatar = userprofile2.config.profile.avatar;
	}
	if(!http(config.avatar)) {
		config.preview = MODx.config.connectors_url + 'system/phpthumb.php?h=193&w=308&zc=1&src=/' + config.avatar + '&wctx=MODx.ctx&source=' + getSource()
	}
	else {config.preview = config.avatar}

    Ext.apply(config,{
        id: 'userprofile2-panel-user'
        ,border: false
        ,baseCls: 'modx-formpanel'
        ,layout: 'anchor'
        ,listeners: {
            setup: {fn:this.setup,scope:this}
            ,afterRender: function(thisForm, options){
                var uf = Ext.getCmp('modx-panel-user');

                uf.addListener('beforeSubmit', function() {
                    this.beforeSubmit(uf);
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

};
Ext.extend(userprofile2.panel.User,MODx.Panel, {

    beforeSubmit: function(o) {
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
        });
    }

    ,getFielValue: function(tabName, fieldName, defaultValue) {
        var extended = userprofile2.config.extended;

        if(extended[tabName] && extended[tabName][fieldName] && (typeof extended[tabName][fieldName]!== 'object')) {
            value = extended[tabName][fieldName];
        }
        else {
            value = defaultValue;
        }

        return value;
    }

    ,getTabs: function(config) {

        var tabsItems = [];
        var tabs = {
            xtype: 'modx-tabs',
            autoHeight: true,
            deferredRender: false,
            forceLayout: true,
            id: 'up2-extended-tabs',
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
            items: tabsItems
        };

        var tf = userprofile2.config.tabsfields;
        if((!tf) || (typeof tf!== 'object')) return tabs;

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
                    id: 'up2-extended-field-' + item['name_out'],
                    fieldLabel: item['name_in'],
                    disabled: !item['editable'],
                    allowBlank: item['required'],
                    ctCls: 'up2_' + item['type_in'],
                    anchor: '100%',
                    value: this.getFielValue(tabNameOut, item['name_out'], item['value']) || item['value']
                };
                tabFields.push(field);
            }
            if(typeof tabFields!== 'object') {continue;}
            tabsItems.push({
                title: tabNameIn,
                items: tabFields,
                id: tabNameOut
            });
        }

        console.log(tabsItems);

        return tabs;
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
					title: _('up2_fieldset_avatar'),
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
								xtype: 'userprofile2-combo-browser',
								id: 'userprofile2-combo-browser',
								name: 'photo',
								anchor: '100%',
								value: config.avatar || ''
							},{
								html: ''
								+ '<div id="up2-avatar">'
								+ '<img src="' + config.preview +'" alt=""  class="up2-avatar">'
								+ '</div>'
							}
						]

					}
					]
				}, {
					xtype: 'fieldset',
					title: _('up2_fieldset_activity'),
					layoutConfig: {
						labelAlign: 'top'
					},
					layout: 'column',
					items: [{
						columnWidth: 1,
						xtype: 'panel',
						border: false,
						layout: 'form',
						labelAlign: 'top',
						preventRender: true,
						items:[
							{ xtype: 'textfield', disabled: true, value: 'fdfdfd', fieldLabel: _('up2_user_registration'), anchor: '100%'}
							,{ xtype: 'textfield', disabled: true, value: 'fdfdfd', fieldLabel: _('up2_user_lastactivity'), anchor: '100%'}
							,{ xtype: 'textfield', disabled: true, value: 'fdfdfd', fieldLabel: _('up2_user_ip'), anchor: '100%'}
						]}
					]

				}
				]
			},
            {
                columnWidth: .7,
                xtype: 'panel',
                border: false,
                layout: 'form',
                labelAlign: 'left',
                preventRender: true,
                items: this.getTabs(config)
            }
        );

        return items;
    }

});
Ext.reg('userprofile2-panel-user',userprofile2.panel.User);