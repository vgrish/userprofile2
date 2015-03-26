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
				['textarea', 'textarea']
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