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