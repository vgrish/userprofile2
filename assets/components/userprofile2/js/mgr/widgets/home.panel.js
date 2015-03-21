userprofile2.panel.Home = function (config) {
	config = config || {};
	Ext.apply(config, {
		baseCls: 'modx-formpanel',
		layout: 'anchor',
		/*
		 stateful: true,
		 stateId: 'userprofile2-panel-home',
		 stateEvents: ['tabchange'],
		 getState:function() {return {activeTab:this.items.indexOf(this.getActiveTab())};},
		 */
		hideMode: 'offsets',
		items: [{
			html: '<h2>' + _('userprofile2') + '</h2>',
			cls: '',
			style: {margin: '15px 0'}
		}, {
			xtype: 'modx-tabs',
			defaults: {border: false, autoHeight: true},
			border: true,
			hideMode: 'offsets',
			items: [{
				title: _('userprofile2_items'),
				layout: 'anchor',
				items: [{
					html: _('userprofile2_intro_msg'),
					cls: 'panel-desc',
				}, {
					xtype: 'userprofile2-grid-items',
					cls: 'main-wrapper',
				}]
			}]
		}]
	});
	userprofile2.panel.Home.superclass.constructor.call(this, config);
};
Ext.extend(userprofile2.panel.Home, MODx.Panel);
Ext.reg('userprofile2-panel-home', userprofile2.panel.Home);
