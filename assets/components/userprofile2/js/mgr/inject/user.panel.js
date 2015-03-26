userprofile2.panel.User = function(config) {
    config = config || {};
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
            html: '<p>'+_('up2_tab_intro')+'</p>'
            ,border: false
            ,bodyCssClass: 'panel-desc'
        }, {
            layout: 'column'
            ,border: false
            ,bodyCssClass: 'tab-panel-wrapper '
            ,style: 'padding: 15px;'
            ,items: this.getItems(config)
        }]
    });
    userprofile2.panel.User.superclass.constructor.call(this,config);



};
Ext.extend(userprofile2.panel.User,MODx.Panel, {

    beforeSubmit: function(o) {


        console.log('beforeSubmit');

        var v = Ext.getCmp('modx-panel-user').getForm().getValues();
        var d = [];
        var n = 0;

        for(i in v) {
            if(/up2/.test(i)) {
                d[n] = [i, v[i]];
                n++;
            }
        }

        MODx.Ajax.request({
            url: userprofile2.config.connector_url
            ,params: {
                action: 'mgr/profile/update'
                ,id: userprofile2.config.user
                ,data: Ext.util.JSON.encode(d)
            }
        });

    }

    ,getTabs: function(config) {
        var type = 'update';
        var tabsItems = [];
        var tabs = {
            xtype: 'modx-tabs',
            autoHeight: true,
            deferredRender: false,
            forceLayout: true,
            id: 'contract-tab-panel-type-'+type,
            width: '98%',
            bodyStyle: 'padding: 10px 10px 10px 10px;',
            border: true,
            defaults: {
                border: false,
                autoHeight: true,
                bodyStyle: 'padding: 5px 8px 5px 5px;',
                layout: 'form',
                deferredRender: false,
                forceLayout: true
            },
            items: tabsItems,
            style: 'padding: 15px 25px 15px 15px;'
        };

        return tabs;
    }

    /*
     return {
     xtype: 'modx-tabs',
     autoHeight: true,
     deferredRender: false,
     forceLayout: true,
     id: 'contract-tab-panel-type-'+type,
     width: '98%',
     bodyStyle: 'padding: 10px 10px 10px 10px;',
     border: true,
     defaults: {
     border: false,
     autoHeight: true,
     bodyStyle: 'padding: 5px 8px 5px 5px;',
     layout: 'form',
     deferredRender: false,
     forceLayout: true
     },
     items: tabsItemsList,
     style: 'padding: 15px 25px 15px 15px;'

     };
     */


    ,getItems: function(config) {
        var items = [];

        items.push(
            {
                columnWidth: .3,
                xtype: 'panel',

                border: false,
                layout: 'form',
                labelAlign: 'top',
                preventRender: true,
                items: [
                    {
                        xtype: 'fieldset',
                        title: _('up_fieldset_avatar'),
                        layoutConfig: {
                            labelAlign: 'top'
                        },
                        layout: 'column',
                        items: [
                            {
                                columnWidth: 1,
                                xtype: 'panel',
                                border: false,
                                layout: 'form',
                                labelAlign: 'top',
                                preventRender: true,
                                items: [
                                    {
                                        //xtype: 'up-combo-browser',
                                        fieldLabel: _('up_avatar'),
                                        name: 'photo',
                                        anchor: '100%',
                                        id: 'up-combo-browser',
                                        //value: config.profile.photo || ''
                                    },
                                    //avatar
                                ]

                            }
                        ]
                    }, {
                        xtype: 'fieldset',
                        title: _('up_fieldset_info'),
                        layoutConfig: {
                            labelAlign: 'top'
                        },
                        layout: 'column',
                        items: [
                            {
                                columnWidth: 1,
                                xtype: 'panel',
                                border: false,
                                layout: 'form',
                                labelAlign: 'top',
                                preventRender: true,
                                items: [
                                    {
                                        xtype: 'hidden',
                                        name: 'up2[real][type_id]',
                                        //value: userprofile.config.extSetting.id
                                    },
                                    {
                                        xtype: 'textarea',
                                        name: 'up2[real][description]',
                                        //value: data.description || '',
                                        description: _('up2_description_help'),
                                        fieldLabel: _('up2_description'),
                                        anchor: '100%',
                                        //height: 126,
                                        enableKeyEvents: true,
                                        //listeners: listeners
                                    },
                                    {
                                        xtype: 'textarea',
                                        name: 'up2[real][introtext]',
                                        //value: data.introtext || '',
                                        description: _('up2_introtext_help'),
                                        fieldLabel: _('up2_introtext'),
                                        anchor: '100%',
                                        height: 126,
                                        enableKeyEvents: true,
                                        //listeners: listeners
                                    }
                                ]

                            }
                        ]

                    }
                ]
            },
            {
                columnWidth: .7,
                xtype: 'panel',
                border: false,
                layout: 'form',
                labelAlign: 'top',
                preventRender: true,
                items: this.getTabs(config)
                /*[
                    {
                        xtype: 'fieldset',
                        title: _('up_fieldset_info'),
                        layoutConfig: {
                            labelAlign: 'top'
                        },
                        layout: 'column',
                        items: [
                            {
                                columnWidth: 1,
                                xtype: 'panel',
                                border: false,
                                layout: 'form',
                                labelAlign: 'top',
                                preventRender: true,
                                items: [
                                    {
                                        xtype: 'hidden',
                                        name: 'up2[real][type_id]',
                                        //value: userprofile.config.extSetting.id
                                    },
                                    {
                                        xtype: 'textarea',
                                        name: 'up2[real][description]',
                                        //value: data.description || '',
                                        description: _('up2_description_help'),
                                        fieldLabel: _('up2_description'),
                                        anchor: '100%',
                                        //height: 126,
                                        enableKeyEvents: true,
                                        //listeners: listeners
                                    },
                                    {
                                        xtype: 'textarea',
                                        name: 'up2[real][introtext]',
                                        //value: data.introtext || '',
                                        description: _('up2_introtext_help'),
                                        fieldLabel: _('up2_introtext'),
                                        anchor: '100%',
                                        height: 126,
                                        enableKeyEvents: true,
                                        //listeners: listeners
                                    }
                                ]

                            }
                        ]

                    }
                ]*/
            }
        );

        return items;

    }

});
Ext.reg('userprofile2-panel-user',userprofile2.panel.User);


/*
userprofile2.panel.User = function(config) {
    config = config || {};
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
            html: '<p>'+_('up2_tab_intro')+'</p>'
            ,border: false
            ,bodyCssClass: 'panel-desc'
        }, {
            layout: 'column'
            ,border: false
            ,bodyCssClass: 'tab-panel-wrapper '
            ,style: 'padding: 15px;'
            ,items: this.getItems(config)
        }]
    });
    userprofile2.panel.User.superclass.constructor.call(this,config);



};
Ext.extend(userprofile2.panel.User,MODx.Panel, {

    beforeSubmit: function(o) {


        console.log('beforeSubmit');

        var v = Ext.getCmp('modx-panel-user').getForm().getValues();
        var d = [];
        var n = 0;

        for(i in v) {
            if(/up2/.test(i)) {
                d[n] = [i, v[i]];
                n++;
            }
        }

        MODx.Ajax.request({
            url: userprofile2.config.connector_url
            ,params: {
                action: 'mgr/profile/update'
                ,id: userprofile2.config.user
                ,data: Ext.util.JSON.encode(d)
            }
        });

    }

    ,getItems: function(config) {
        var items = [];

        items.push(
            {
                columnWidth: .3,
                xtype: 'panel',

                border: false,
                layout: 'form',
                labelAlign: 'top',
                preventRender: true,
                items: [
                    {
                        xtype: 'fieldset',
                        title: _('up_fieldset_avatar'),
                        layoutConfig: {
                            labelAlign: 'top'
                        },
                        layout: 'column',
                        items: [
                            {
                                columnWidth: 1,
                                xtype: 'panel',
                                border: false,
                                layout: 'form',
                                labelAlign: 'top',
                                preventRender: true,
                                items: [
                                    {
                                        //xtype: 'up-combo-browser',
                                        fieldLabel: _('up_avatar'),
                                        name: 'photo',
                                        anchor: '100%',
                                        id: 'up-combo-browser',
                                        //value: config.profile.photo || ''
                                    },
                                    //avatar
                                ]

                            }
                        ]
                    }
                ]
            },
            {
                columnWidth: .7,
                xtype: 'panel',
                border: false,
                layout: 'form',
                labelAlign: 'top',
                preventRender: true,
                items: [
                    {
                        xtype: 'fieldset',
                        title: _('up_fieldset_info'),
                        layoutConfig: {
                            labelAlign: 'top'
                        },
                        layout: 'column',
                        items: [
                            {
                                columnWidth: 1,
                                xtype: 'panel',
                                border: false,
                                layout: 'form',
                                labelAlign: 'top',
                                preventRender: true,
                                items: [
                                    {
                                        xtype: 'hidden',
                                        name: 'up2[real][type_id]',
                                        //value: userprofile.config.extSetting.id
                                    },
                                    {
                                        xtype: 'textarea',
                                        name: 'up2[real][description]',
                                        //value: data.description || '',
                                        description: _('up2_description_help'),
                                        fieldLabel: _('up2_description'),
                                        anchor: '100%',
                                        //height: 126,
                                        enableKeyEvents: true,
                                        //listeners: listeners
                                    },
                                    {
                                        xtype: 'textarea',
                                        name: 'up2[real][introtext]',
                                        //value: data.introtext || '',
                                        description: _('up2_introtext_help'),
                                        fieldLabel: _('up2_introtext'),
                                        anchor: '100%',
                                        height: 126,
                                        enableKeyEvents: true,
                                        //listeners: listeners
                                    }
                                ]

                            }
                        ]

                    }
                ]
            }
        );

        return items;

    }

});
Ext.reg('userprofile2-panel-user',userprofile2.panel.User);*/
