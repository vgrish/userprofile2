Ext.namespace('userprofile2.combo');

userprofile2.combo.TypeIn = function(config) {
	config = config || {};
	Ext.applyIf(config,{
		store: new Ext.data.ArrayStore({
			id: 0
			,fields: ['type_in','display']
			,data: [
				['textfield', 'textfield'],
				['numberfield', 'numberfield'],
				['textarea', 'textarea'],
				['datefield','datefield'],
				['xdatetime','xdatetime']
			]
		})
		,mode: 'local'
		,displayField: 'display'
		,valueField: 'type_in'
		,hiddenName: 'type_in'

	});
	userprofile2.combo.TypeIn.superclass.constructor.call(this,config);
};
Ext.extend(userprofile2.combo.TypeIn,MODx.combo.ComboBox);
Ext.reg('userprofile2-combo-type-in',userprofile2.combo.TypeIn);

userprofile2.combo.TypeOut = function(config) {
	config = config || {};
	Ext.applyIf(config,{
		store: new Ext.data.ArrayStore({
			id: 0
			,fields: ['type_out','display']
			,data: [
				['text', 'text'],
				['number', 'number'],
				['textarea', 'textarea'],
				['hidden', 'hidden']
			]
		})
		,mode: 'local'
		,displayField: 'display'
		,valueField: 'type_out'
		,hiddenName: 'type_out'

	});
	userprofile2.combo.TypeOut.superclass.constructor.call(this,config);
};
Ext.extend(userprofile2.combo.TypeOut,MODx.combo.ComboBox);
Ext.reg('userprofile2-combo-type-out',userprofile2.combo.TypeOut);


userprofile2.combo.FieldType = function(config) {
	config = config || {};
	Ext.applyIf(config, {
		name: 'handler'
		, hiddenName: 'type'
		, displayField: 'name'
		, valueField: 'id'
		, editable: true
		, fields: ['name','id']
		, pageSize: 10
		, emptyText: _('up2_combo_select')
		, hideMode: 'offsets'
		, url: userprofile2.config.connector_url
		, baseParams: {
			action: 'mgr/settings/type-field/getlist',
			combo: true,
			limit: 0
		}
	});
	userprofile2.combo.FieldType.superclass.constructor.call(this, config);
};
Ext.extend(userprofile2.combo.FieldType, MODx.combo.ComboBox);
Ext.reg('userprofile2-combo-field-type', userprofile2.combo.FieldType);


userprofile2.combo.TabType = function(config) {
	config = config || {};
	Ext.applyIf(config, {
		name: 'handler'
		, hiddenName: 'tab'
		, displayField: 'name_in'
		, valueField: 'id'
		, editable: true
		, fields: ['name_in','id']
		, pageSize: 10
		, emptyText: _('up2_combo_select')
		, hideMode: 'offsets'
		, url: userprofile2.config.connector_url
		, baseParams: {
			action: 'mgr/settings/type-tab/getlist',
			combo: true,
			limit: 0
		}
	});
	userprofile2.combo.TabType.superclass.constructor.call(this, config);
};
Ext.extend(userprofile2.combo.TabType, MODx.combo.ComboBox);
Ext.reg('userprofile2-combo-tab-type', userprofile2.combo.TabType);


userprofile2.combo.ProfileType = function(config) {
	config = config || {};
	Ext.applyIf(config, {
		name: 'handler'
		, hiddenName: 'type'
		, displayField: 'name'
		, valueField: 'id'
		, editable: true
		, fields: ['name','id']
		, pageSize: 10
		, emptyText: _('up2_combo_select')
		, hideMode: 'offsets'
		, url: userprofile2.config.connector_url
		, baseParams: {
			action: 'mgr/settings/type-profile/getlist',
			combo: true,
			limit: 0
		}
	});
	userprofile2.combo.ProfileType.superclass.constructor.call(this, config);
};
Ext.extend(userprofile2.combo.ProfileType, MODx.combo.ComboBox);
Ext.reg('userprofile2-combo-profile-type', userprofile2.combo.ProfileType);


userprofile2.combo.Browser = function(config) {
	config = config || {};

	if (config.length != 0 && typeof config.openTo !== "undefined") {
		if (!/^\//.test(config.openTo)) {
			config.openTo = '/' + config.openTo;
		}
		if (!/$\//.test(config.openTo)) {
			var tmp = config.openTo.split('/')
			delete tmp[tmp.length - 1];
			tmp = tmp.join('/');
			config.openTo = tmp.substr(1)
		}
	}

	Ext.applyIf(config,{
		width: 300
		,triggerAction: 'all'
	});
	userprofile2.combo.Browser.superclass.constructor.call(this,config);
	this.config = config;
};
Ext.extend(userprofile2.combo.Browser,Ext.form.TriggerField,{
	browser: null

	,onTriggerClick : function(btn){
		if (this.disabled){
			return false;
		}

		//if (this.browser === null) {
			this.browser = MODx.load({
				xtype: 'modx-browser'
				,id: Ext.id()
				,multiple: true
				,source: this.config.source || MODx.config.default_media_source
				,rootVisible: this.config.rootVisible || false
				,allowedFileTypes: this.config.allowedFileTypes || ''
				,wctx: this.config.wctx || 'web'
				,openTo: this.config.openTo || ''
				,rootId: this.config.rootId || '/'
				,hideSourceCombo: this.config.hideSourceCombo || false
				,hideFiles: this.config.hideFiles || true
				,listeners: {
					'select': {fn: function(data) {
						this.setValue(data.fullRelativeUrl);
						this.fireEvent('select',data);
						Ext.get('up2-avatar').update('<img src="'+MODx.config.connectors_url+'system/phpthumb.php?h=274&w=274&zc=1&src='+data.fullRelativeUrl+'&wctx=MODx.ctx&source=1" class="up2-avatar" alt="" />');
					},scope:this}
				}
			});
		//}
		this.browser.win.buttons[0].on('disable',function(e) {this.enable()})
		this.browser.win.tree.on('click', function(n,e) {
				path = this.getPath(n);
				this.setValue(path);
			},this
		);
		this.browser.win.tree.on('dblclick', function(n,e) {
				path = this.getPath(n);
				this.setValue(path);
				this.browser.hide()
			},this
		);
		this.browser.show(btn);
		return true;
	}
	,onDestroy: function(){
		userprofile2.combo.Browser.superclass.onDestroy.call(this);
	}
	,getPath: function(n) {
		if (n.id == '/') {return '';}
		data = n.attributes;
		path = data.path + '/';

		return path;
	}
});
Ext.reg('userprofile2-combo-browser',userprofile2.combo.Browser);
