userprofile2.grid.TypeField = function(config) {
	config = config || {};

	this.dd = function(grid) {
		this.dropTarget = new Ext.dd.DropTarget(grid.container, {
			ddGroup : 'dd',
			copy:false,
			notifyDrop : function(dd, e, data) {
				var store = grid.store.data.items;
				var target = store[dd.getDragData(e).rowIndex].id;
				var source = store[data.rowIndex].id;
				if (target != source) {
					dd.el.mask(_('loading'),'x-mask-loading');
					MODx.Ajax.request({
						url: userprofile2.config.connector_url
						,params: {
							action: config.action || 'mgr/settings/type-field/sort'
							,source: source
							,target: target
						}
						,listeners: {
							success: {fn:function(r) {dd.el.unmask();grid.refresh();},scope:grid}
							,failure: {fn:function(r) {dd.el.unmask();},scope:grid}
						}
					});
				}
			}
		});
	};
	Ext.applyIf(config,{
		id: 'userprofile2-grid-type-field'
		,url: userprofile2.config.connector_url
		,baseParams: {
			action: 'mgr/settings/type-field/getlist'
		}
		,fields: ['id', 'name', 'type_in', 'type_out', 'active', 'rank']
		,autoHeight: true
		,paging: true
		,remoteSort: true
		,save_action: 'mgr/settings/type-field/updatefromgrid'
		,autosave: true
		/*,save_callback: this.updateRow*/
		,columns: [
			{header: _('up2_id'),dataIndex: 'id',width: 50, sortable: true}
			,{header: _('up2_name'),dataIndex: 'name',width: 150, editor: {xtype: 'textfield', allowBlank: false}, sortable: true}
			,{header: _('up2_type_in'),dataIndex: 'type_in',width: 150, editor: {xtype: 'userprofile2-combo-type-in', allowBlank: false}, sortable: true}
			,{header: _('up2_type_out'),dataIndex: 'type_out',width: 150, editor: {xtype: 'userprofile2-combo-type-out', allowBlank: false}, sortable: true}
			,{header: _('up2_active'),dataIndex: 'active', sortable:true, width:50, editor:{xtype:'combo-boolean', renderer:'boolean'}}
		]
		,tbar: [{
			text: _('up2_btn_create')
			,handler: this.createTypeField
			,scope: this
		}]
		,ddGroup: 'dd'
		,enableDragDrop: true
		,listeners: {
			render: {fn: this.dd, scope: this}
		}
	});
	userprofile2.grid.TypeField.superclass.constructor.call(this,config);
};
Ext.extend(userprofile2.grid.TypeField,MODx.grid.Grid,{
	windows: {}

	,getMenu: function() {
		var m = [];
		m.push({
			text: _('up2_menu_update')
			,handler: this.updateTypeField
		});
		m.push('-');
		m.push({
			text: _('up2_menu_remove')
			,handler: this.removeTypeField
		});
		this.addContextMenuItem(m);
	}

/*	,updateRow: function(response) {
		Ext.getCmp('userprofile2-grid-type-field').refresh();
	}*/

	,createTypeField: function(btn,e) {
		var w = Ext.getCmp('userprofile2-window-type-field-create');
		if (w) {w.hide().getEl().remove();}

		if (!this.windows.createTypeField) {
			this.windows.createTypeField = MODx.load({
				xtype: 'userprofile2-window-type-field-create'
				,fields: this.getTypeFieldFields('create')
				,listeners: {
					success: {fn:function() { this.refresh(); },scope:this}
				}
			});
		}
		this.windows.createTypeField.fp.getForm().reset();
		this.windows.createTypeField.fp.getForm().setValues({
			active: 1
		});
		this.windows.createTypeField.show(e.target);
	}

	,updateTypeField: function(btn,e) {
		if (!this.menu.record || !this.menu.record.id) return false;
		var r = this.menu.record;

		if (!this.windows.updateTypeField) {
			this.windows.updateTypeField = MODx.load({
				xtype: 'userprofile2-window-type-field-update'
				,record: r
				,fields: this.getTypeFieldFields('update')
				,listeners: {
					success: {fn:function() { this.refresh(); },scope:this}
				}
			});
		}
		this.windows.updateTypeField.fp.getForm().reset();
		this.windows.updateTypeField.fp.getForm().setValues(r);
		this.windows.updateTypeField.show(e.target);
	}

	,removeTypeField: function(btn,e) {
		if (!this.menu.record) return false;

		MODx.msg.confirm({
			title: _('up2_menu_remove') + ' "' + this.menu.record.name + '"'
			,text: _('up2_menu_remove_confirm')
			,url: this.config.url
			,params: {
				action: 'mgr/settings/type-field/remove'
				,id: this.menu.record.id
			}
			,listeners: {
				success: {fn:function(r) {this.refresh();}, scope:this}
			}
		});
	}

	,getTypeFieldFields: function(type) {
		var fields = [];

		fields.push(
			{xtype: 'hidden',name: 'id', id: 'userprofile2-type-field-id-'+type}
			,{xtype: 'textfield',fieldLabel: _('up2_name'), name: 'name', allowBlank: false, anchor: '99%', id: 'userprofile2-type-field-name-'+type}
			,{xtype: 'userprofile2-combo-type-in',fieldLabel: _('up2_type_in'), name: 'type_in', allowBlank: false, anchor: '99%', id: 'userprofile2-type-field-type_in-'+type}
			,{xtype: 'userprofile2-combo-type-out',fieldLabel: _('up2_type_out'), name: 'type_out', allowBlank: false, anchor: '99%', id: 'userprofile2-type-field-type_out-'+type}
		);

		fields.push(
			{xtype: 'xcheckbox', fieldLabel: '', boxLabel: _('up2_active'), name: 'active', id: 'userprofile2-type-field-active-'+type}
		);

		return fields;
	}

});
Ext.reg('userprofile2-grid-type-field',userprofile2.grid.TypeField);


userprofile2.window.CreateTypeField = function(config) {
	config = config || {};
	this.ident = config.ident || 'mecitem'+Ext.id();
	Ext.applyIf(config,{
		title: _('up2_menu_create')
		,id: this.ident
		,width: 450
		,autoHeight: true
		,labelAlign: 'left'
		,labelWidth: 150
		,url: userprofile2.config.connector_url
		,action: 'mgr/settings/type-field/create'
		,fields: config.fields
		,keys: [{key: Ext.EventObject.ENTER,shift: true,fn: function() {this.submit() },scope: this}]
	});
	userprofile2.window.CreateTypeField.superclass.constructor.call(this,config);
};
Ext.extend(userprofile2.window.CreateTypeField,MODx.Window);
Ext.reg('userprofile2-window-type-field-create',userprofile2.window.CreateTypeField);


userprofile2.window.UpdateTypeField = function(config) {
	config = config || {};
	this.ident = config.ident || 'meuitem'+Ext.id();
	Ext.applyIf(config,{
		title: _('up2_menu_update')
		,id: this.ident
		,width: 450
		,autoHeight: true
		,labelAlign: 'left'
		,labelWidth: 150
		,url: userprofile2.config.connector_url
		,action: 'mgr/settings/type-field/update'
		,fields: config.fields
		,keys: [{key: Ext.EventObject.ENTER,shift: true,fn: function() {this.submit() },scope: this}]
	});
	userprofile2.window.UpdateTypeField.superclass.constructor.call(this,config);
};
Ext.extend(userprofile2.window.UpdateTypeField,MODx.Window);
Ext.reg('userprofile2-window-type-field-update',userprofile2.window.UpdateTypeField);