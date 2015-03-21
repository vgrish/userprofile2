userprofile2.page.Home = function (config) {
	config = config || {};
	Ext.applyIf(config, {
		components: [{
			xtype: 'userprofile2-panel-home', renderTo: 'userprofile2-panel-home-div'
		}]
	});
	userprofile2.page.Home.superclass.constructor.call(this, config);
};
Ext.extend(userprofile2.page.Home, MODx.Component);
Ext.reg('userprofile2-page-home', userprofile2.page.Home);