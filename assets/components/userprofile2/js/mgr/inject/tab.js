Ext.ComponentMgr.onAvailable('modx-user-type-tab', function() {
    this.on('beforerender', function() {

        this.add({
            title: _('up2_tab')
            ,id: 'up2-tab'
           // ,hideMode: 'offsets'
            ,items: [{
                xtype: 'userprofile2-panel-user'
            }]
        });

    });

});