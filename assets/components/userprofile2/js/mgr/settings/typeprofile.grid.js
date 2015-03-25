userprofile2.grid.TypeProfile = function(config) {
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
							action: config.action || 'mgr/settings/type-profile/sort'
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
		id: 'userprofile2-grid-type-profile'
		,url: userprofile2.config.connector_url
		,baseParams: {
			action: 'mgr/settings/type-profile/getlist'
		}
		,fields: ['id', 'name', 'description', 'default', 'active', 'rank']
		,autoHeight: true
		,paging: true
		,remoteSort: true
		,save_action: 'mgr/settings/type-profile/updatefromgrid'
		,autosave: true
		/*,save_callback: this.updateRow*/
		,columns: [
			{header: _('up2_id'),dataIndex: 'id',width: 50, sortable: true}
			,{header: _('up2_name'),dataIndex: 'name',width: 150, editor: {xtype: 'textfield', allowBlank: false}, sortable: true}
			,{header: _('up2_description'),dataIndex: 'description',width: 150, editor: {xtype: 'textfield', allowBlank: true}, sortable: true}
			,{header: _('up2_default'),dataIndex: 'default', sortable:true, width:50, editor:{xtype:'combo-boolean', renderer:'boolean'}}
			,{header: _('up2_active'),dataIndex: 'active', sortable:true, width:50, editor:{xtype:'combo-boolean', renderer:'boolean'}}
		]
		,tbar: [{
			text: _('up2_btn_create')
			,handler: this.createTypeProfile
			,scope: this
		}]
		,ddGroup: 'dd'
		,enableDragDrop: true
		,listeners: {
			render: {fn: this.dd, scope: this}
		}
	});
	userprofile2.grid.TypeProfile.superclass.constructor.call(this,config);
};
Ext.extend(userprofile2.grid.TypeProfile,MODx.grid.Grid,{
	windows: {}

	,getMenu: function() {
		var m = [];
		m.push({
			text: _('up2_menu_update')
			,handler: this.updateTypeProfile
		});
		m.push('-');
		m.push({
			text: _('up2_menu_profile_tabs')
			,handler: this.updateProfileTabs
		});
		m.push('-');
		m.push({
			text: _('up2_menu_remove')
			,handler: this.removeTypeProfile
		});
		this.addContextMenuItem(m);
	}

/*	,updateRow: function(response) {
		Ext.getCmp('userprofile2-grid-type-profile').refresh();
	}*/

	,createTypeProfile: function(btn,e) {
		var w = Ext.getCmp('userprofile2-window-type-profile-create');
		if (w) {w.hide().getEl().remove();}

		if (!this.windows.createTypeProfile) {
			this.windows.createTypeProfile = MODx.load({
				xtype: 'userprofile2-window-type-profile-create'
				,fields: this.getTypeProfileFields('create')
				,listeners: {
					success: {fn:function() { this.refresh(); },scope:this}
				}
			});
		}
		this.windows.createTypeProfile.fp.getForm().reset();
		this.windows.createTypeProfile.fp.getForm().setValues({
			active: 1
		});
		this.windows.createTypeProfile.show(e.target);
	}

	,updateTypeProfile: function(btn,e) {
		if (!this.menu.record || !this.menu.record.id) return false;
		var r = this.menu.record;

		if (!this.windows.updateTypeProfile) {
			this.windows.updateTypeProfile = MODx.load({
				xtype: 'userprofile2-window-type-profile-update'
				,record: r
				,fields: this.getTypeProfileFields('update')
				,listeners: {
					success: {fn:function() { this.refresh(); },scope:this}
				}
			});
		}
		this.windows.updateTypeProfile.fp.getForm().reset();
		this.windows.updateTypeProfile.fp.getForm().setValues(r);
		this.windows.updateTypeProfile.show(e.target);
	}

	,removeTypeProfile: function(btn,e) {
		if (!this.menu.record) return false;

		MODx.msg.confirm({
			title: _('up2_menu_remove') + ' "' + this.menu.record.name + '"'
			,text: _('up2_menu_remove_confirm')
			,url: this.config.url
			,params: {
				action: 'mgr/settings/type-profile/remove'
				,id: this.menu.record.id
			}
			,listeners: {
				success: {fn:function(r) {this.refresh();}, scope:this}
			}
		});
	}

	,getTypeProfileFields: function(type) {
		var fields = [];

		fields.push(
			{xtype: 'hidden',name: 'id', id: 'userprofile2-type-profile-id-'+type}
			,{xtype: 'textfield',fieldLabel: _('up2_name'), name: 'name', allowBlank: false, anchor: '99%', id: 'userprofile2-type-profile-name-'+type}
			,{xtype: 'textarea',fieldLabel: _('up2_description'), name: 'description', allowBlank: true, anchor: '99%', id: 'userprofile2-type-profile-description-'+type}
		);

		fields.push(
			{xtype: 'xcheckbox', fieldLabel: '', boxLabel: _('up2_active'), name: 'active', id: 'userprofile2-type-profile-active-'+type}
			,{xtype: 'xcheckbox', fieldLabel: '', boxLabel: _('up2_default'), name: 'default', id: 'userprofile2-type-profile-default-'+type}
		);

		return fields;
	}

	,updateProfileTabs: function(btn,e,row) {
		if (typeof(row) != 'undefined') {
			this.menu.record = row.data;
		}

		var id = this.menu.record.id;
		var w = Ext.getCmp('userprofile2-window-tabs-view');
		if (w) {w.hide().getEl().remove();}

		w = MODx.load({
			xtype: 'userprofile2-window-tabs-view'
			,id: 'userprofile2-window-tabs-view'
			,record: {
				id: id
			}
			,listeners: {
				success: {fn:function() {this.refresh();},scope:this}
			}
		});
		w.fp.getForm().reset();
		w.show(e.target,function() {w.setPosition(null,100)},this);
	}

});
Ext.reg('userprofile2-grid-type-profile',userprofile2.grid.TypeProfile);






userprofile2.window.ViewTabs = function(config) {
	config = config || {};

	this.ident = config.ident || 'meuitem'+Ext.id();
	Ext.applyIf(config,{
		//title: _('up2_menu_update')
		id: this.ident
		,width: 750
		,autoHeight: true
		,labelAlign: 'top'
		,fields: {
			xtype: 'modx-tabs'
			,cls: 'up2-tab-up'
			,border: false
			,activeTab: config.activeTab || 0
			,bodyStyle: { background: 'transparent'}
			,deferredRender: false
			,autoHeight: true
			,items: this.getTabs(config)
		}
		,buttons: [{text: _('close'),scope: this,handler: function() {this.hide();}}]
		,keys: []

	});
	userprofile2.window.ViewTabs.superclass.constructor.call(this,config);

};

Ext.extend(userprofile2.window.ViewTabs,MODx.Window, {

	getTabs: function(config) {
		var w = Ext.getCmp('userprofile2-grid-tab-tabs-'+config.record.id);
		if (w) {w.hide().getEl().remove();}

		var tabs = [{
			xtype: 'userprofile2-grid-tab-tabs'
			,record: {
				id: config.record.id
			}
			,title: _('up2_fields')
			,profile: config.record.id
		}];

		return tabs;
	}

});
Ext.reg('userprofile2-window-tabs-view',userprofile2.window.ViewTabs);



userprofile2.grid.Fields = function(config) {
	config = config || {};

	this.dd = function(grid) {

		Ext.dd.DragDropMgr.getZIndex = function(element) {
			var body = document.body,
				z,
				zIndex = -1;
			var overTargetEl = element;

			element = Ext.getDom(element);
			while (element !== body) {
				// this fixes the problem
				if(!element) {
					this._remove(overTargetEl); // remove the drop target from the manager
					break;
				}
				// fix end
				if (!isNaN(z = Number(Ext.fly(element).getStyle('zIndex')))) {
					zIndex = z;
				}
				element = element.parentNode;
			}
			return zIndex;
		};

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
							action: config.action || 'mgr/settings/fields/sort'
							,source: source
							,target: target
							,profile: grid.profile
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

	var profile = config.profile;

	Ext.applyIf(config,{
		id: 'userprofile2-grid-tab-tabs-' + profile
		,url: userprofile2.config.connector_url
		,baseParams: {
			action: 'mgr/settings/fields/getlist'
			,profile: config.profile
		}
		,fields: ['id','name_in','name_out','profile','type','css','value','required','editable','active','rank']
		,pageSize: Math.round(MODx.config.default_per_page / 2)
		,autoHeight: true
		,paging: true
		,remoteSort: true
		,save_action: 'mgr/settings/fields/updatefromgrid'
		,autosave: true
		,save_callback: this.updateRow
		,columns: this.getColumns()
		,tbar: [{
			text: _('up2_btn_create')
			,handler: this.createField
			,scope: this
		}]
		,ddGroup: 'dd'
		,enableDragDrop: true
		,listeners: {
			render: {fn: this.dd, scope: this}
		}
	});
	userprofile2.grid.Fields.superclass.constructor.call(this,config);
};
Ext.extend(userprofile2.grid.Fields,MODx.grid.Grid, {

	getMenu: function() {
		var m = [];
		m.push({
			text: _('up2_menu_update')
			,handler: this.updateField
		});
		m.push('-');
		m.push({
			text: _('up2_menu_remove')
			,handler: this.removeField
		});
		this.addContextMenuItem(m);
	}

	,updateRow: function(response) {
		Ext.getCmp('userprofile2-grid-tab-profiles-' + this.profile).refresh();
	}

	,getColumns: function() {
		var all = {
			id: {hidden: true}
			,name_in: {width: 35, editor: {xtype: 'textfield', allowBlank: false}, sortable: true}
			,name_out: {width: 35, editor: {xtype: 'textfield', allowBlank: false}, sortable: true}
			,type: {width: 60, editor: {xtype: 'userprofile2-combo-field-type', allowBlank: false}, renderer: userprofile2.utils.renderType, sortable: true}
			,css: {width: 35, editor: {xtype: 'textfield', allowBlank: true}, sortable: true}
			// ,value: {width: 35, editor: {xtype: 'textfield', allowBlank: true}, sortable: true}
			,required: {width: 35, sortable: true, editor:{xtype:'combo-boolean', renderer:'boolean'}}
			,editable: {width: 35, sortable: true, editor:{xtype:'combo-boolean', renderer:'boolean'}}
			,active: {width: 35, sortable: true, editor:{xtype:'combo-boolean', renderer:'boolean'}}
		};

		var columns = [];

		for (var i in all) {
			if (!all.hasOwnProperty(i)) {continue;}
			Ext.applyIf(all[i], {
				header: _('up2_' + i)
				,dataIndex: i
			});
			columns.push(all[i]);
		}

		return columns;
	}

	,removeField: function(btn,e) {
		if (!this.menu.record) return false;

		MODx.msg.confirm({
			title: _('up2_menu_remove') + ' "' + this.menu.record.name + '"'
			,text: _('up2_menu_remove_confirm')
			,url: this.config.url
			,params: {
				action: 'mgr/settings/fields/remove'
				,id: this.menu.record.id
			}
			,listeners: {
				success: {fn:function(r) {this.refresh();}, scope:this}
			}
		});
	}

	,createField: function(btn,e) {
		var w = Ext.getCmp('userprofile2-window-field-in-tab-create');
		if (w) {w.hide().getEl().remove();}

		var profile = this.profile;

		if (!this.windows.createField) {
			this.windows.createField = MODx.load({
				xtype: 'userprofile2-window-field-in-tab-create'
				,fields: this.getTabFields('create')
				,listeners: {
					success: {fn:function() {
						Ext.getCmp('userprofile2-grid-tab-tabs-' + profile).refresh();
					},scope:this}
				}
			});
		}
		this.windows.createField.fp.getForm().reset();
		this.windows.createField.fp.getForm().setValues({
			active: 1
			,editable: 1
			,profile: profile
		});
		this.windows.createField.show(e.target);
	}

	,updateField: function(btn,e) {
		if (!this.menu.record || !this.menu.record.id) return false;
		var r = this.menu.record;

		if (!this.windows.updateField) {
			this.windows.updateField = MODx.load({
				xtype: 'userprofile2-window-field-in-tab-update'
				,record: r
				,fields: this.getTabFields('update')
				,listeners: {
					success: {fn:function() { this.refresh(); },scope:this}
				}
			});
		}
		this.windows.updateField.fp.getForm().reset();
		this.windows.updateField.fp.getForm().setValues(r);
		this.windows.updateField.show(e.target);
	}

	,getTabFields: function(type) {
		var fields = [];

		fields.push(
			{xtype: 'hidden',name: 'id', id: 'userprofile2-field-in-tab-id-'+type}
			,{xtype: 'hidden',name: 'tab', id: 'userprofile2-field-in-tab-tab-'+type}
			,{xtype: 'textfield',fieldLabel: _('up2_name_in'), name: 'name_in', allowBlank: false, anchor: '99%', id: 'userprofile2-field-in-tab-name_in-'+type}
			,{xtype: 'textfield',fieldLabel: _('up2_name_out'), name: 'name_out', allowBlank: false, anchor: '99%', id: 'userprofile2-field-in-tab-name_out-'+type}
			,{xtype: 'userprofile2-combo-field-type',fieldLabel: _('up2_type'), name: 'type', allowBlank: false, anchor: '99%', id: 'userprofile2-field-in-tab-type-'+type}
			,{xtype: 'textfield',fieldLabel: _('up2_css'), name: 'css', allowBlank: true, anchor: '99%', id: 'userprofile2-field-in-tab-css-'+type}
			,{xtype: 'textarea',fieldLabel: _('up2_value'), name: 'value', allowBlank: true, anchor: '99%', id: 'userprofile2-field-in-tab-value-'+type}
		);

		fields.push(
			{xtype: 'xcheckbox', fieldLabel: '', boxLabel: _('up2_required'), name: 'required', id: 'userprofile2-field-in-tab-required-'+type}
			,{xtype: 'xcheckbox', fieldLabel: '', boxLabel: _('up2_editable'), name: 'editable', id: 'userprofile2-field-in-tab-editable-'+type}
			,{xtype: 'xcheckbox', fieldLabel: '', boxLabel: _('up2_active'), name: 'active', id: 'userprofile2-field-in-tab-active-'+type}
		);

		return fields;
	}

});
Ext.reg('userprofile2-grid-tab-tabs',userprofile2.grid.Fields);


userprofile2.window.CreateFieldInTab = function(config) {
	config = config || {};
	this.ident = config.ident || 'mecitem'+Ext.id();
	Ext.applyIf(config,{
		title: _('up2_menu_create')
		,id: this.ident
		,width: 500
		,autoHeight: true
		,labelAlign: 'left'
		,labelWidth: 150
		,url: userprofile2.config.connector_url
		,action: 'mgr/settings/fields/create'
		,fields: config.fields
		,keys: [{key: Ext.EventObject.ENTER,shift: true,fn: function() {this.submit() },scope: this}]
	});
	userprofile2.window.CreateFieldInTab .superclass.constructor.call(this,config);
};
Ext.extend(userprofile2.window.CreateFieldInTab ,MODx.Window);
Ext.reg('userprofile2-window-field-in-tab-create',userprofile2.window.CreateFieldInTab );

userprofile2.window.UpdateFieldInTab = function(config) {
	config = config || {};
	this.ident = config.ident || 'mecitem'+Ext.id();
	Ext.applyIf(config,{
		title: _('up2_menu_create')
		,id: this.ident
		,width: 500
		,autoHeight: true
		,labelAlign: 'left'
		,labelWidth: 150
		,url: userprofile2.config.connector_url
		,action: 'mgr/settings/fields/update'
		,fields: config.fields
		,keys: [{key: Ext.EventObject.ENTER,shift: true,fn: function() {this.submit() },scope: this}]
	});
	userprofile2.window.UpdateFieldInTab .superclass.constructor.call(this,config);
};
Ext.extend(userprofile2.window.UpdateFieldInTab ,MODx.Window);
Ext.reg('userprofile2-window-field-in-tab-update',userprofile2.window.UpdateFieldInTab);


/* ------------------------------------------------- */

userprofile2.window.CreateTypeProfile = function(config) {
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
		,action: 'mgr/settings/type-profile/create'
		,fields: config.fields
		,keys: [{key: Ext.EventObject.ENTER,shift: true,fn: function() {this.submit() },scope: this}]
	});
	userprofile2.window.CreateTypeProfile.superclass.constructor.call(this,config);
};
Ext.extend(userprofile2.window.CreateTypeProfile,MODx.Window);
Ext.reg('userprofile2-window-type-profile-create',userprofile2.window.CreateTypeProfile);


userprofile2.window.UpdateTypeProfile = function(config) {
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
		,action: 'mgr/settings/type-profile/update'
		,fields: config.fields
		,keys: [{key: Ext.EventObject.ENTER,shift: true,fn: function() {this.submit() },scope: this}]
	});
	userprofile2.window.UpdateTypeProfile.superclass.constructor.call(this,config);
};
Ext.extend(userprofile2.window.UpdateTypeProfile,MODx.Window);
Ext.reg('userprofile2-window-type-profile-update',userprofile2.window.UpdateTypeProfile);