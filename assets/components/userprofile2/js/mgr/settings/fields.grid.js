userprofile2.grid.Fields = function(config) {
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
                            action: config.action || 'mgr/settings/fields/sort'
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
        id: 'userprofile2-grid-fields'
        ,url: userprofile2.config.connector_url
        ,baseParams: {
            action: 'mgr/settings/fields/getlist'
        }
        ,fields: ['id', 'name', 'fields', 'add_fields', 'product_fields', 'tree_fields', 'class', 'description', 'active', 'active_filter_category', 'body_user']
        ,autoHeight: true
        ,paging: true
        ,remoteSort: true
        ,save_action: 'mgr/settings/fields/updatefromgrid'
        ,autosave: true
        ,save_callback: this.updateRow

        ,columns: [
            ,{header: _('up2_id'),dataIndex: 'id',width: 50, sortable: true}
            ,{header: _('up2_name'),dataIndex: 'name',width: 100, editor: {xtype: 'textfield', allowBlank: false}, sortable: true}
            ,{header: _('up2_fields'),dataIndex: 'fields',width: 100, editor: {xtype: 'numberfield', allowBlank: false}, sortable: true}
            ,{header: _('up2_add_fields'),dataIndex: 'add_fields',width: 100, editor: {xtype: 'textfield', allowBlank: false}, sortable: true}
            ,{header: _('up2_product_fields'),dataIndex: 'product_fields',width: 100, editor: {xtype: 'textfield', allowBlank: false}, sortable: true}
            ,{header: _('up2_initiator_fields'),dataIndex: 'initiator_fields',width: 100, editor: {xtype: 'textfield', allowBlank: false}, sortable: true}
            ,{header: _('up2_class'),dataIndex: 'class',width: 150, editor: {xtype: 'textfield', allowBlank: false}, sortable: true}
            ,{header: _('up2_active'),dataIndex: 'active',sortable:true, width:50, editor:{xtype:'combo-boolean', renderer:'boolean'}}
            ,{header: _('up2_active_filter_category'),dataIndex: 'active_filter_category',sortable:true, width:50, editor:{xtype:'combo-boolean', renderer:'boolean'}}



        ]
        ,tbar: [{
            text: _('up2_btn_create')
            ,handler: this.createFields
            ,scope: this
        }]
        ,ddGroup: 'dd'
        ,enableDragDrop: true
        ,listeners: {render: {fn: this.dd, scope: this}}
    });
    userprofile2.grid.Fields.superclass.constructor.call(this,config);

};
Ext.extend(userprofile2.grid.Fields,MODx.grid.Grid,{
    windows: {}

    ,getMenu: function() {
        var m = [];
        m.push({
            text: _('up2_menu_update')
            ,handler: this.updateFields
        });
        m.push('-');
        m.push({
            text: _('up2_menu_remove')
            ,handler: this.removeFields
        });
        this.addContextMenuItem(m);
    }


});
Ext.reg('userprofile2-grid-fields',userprofile2.grid.Fields);
