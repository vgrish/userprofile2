Ext.ComponentMgr.onAvailable('modx-user-tabs', function() {
    this.on('beforerender', function() {

        this.add({
            title: _('userprofile2')
            ,id: 'up2-tab'
            ,items: [{
                xtype: 'userprofile2-panel-user'
            }]
        });

    });

});