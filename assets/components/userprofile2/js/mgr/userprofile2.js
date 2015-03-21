var userprofile2 = function (config) {
	config = config || {};
	userprofile2.superclass.constructor.call(this, config);
};
Ext.extend(userprofile2, Ext.Component, {
	page: {}, window: {}, grid: {}, tree: {}, panel: {}, combo: {}, config: {}, view: {}, utils: {}
});
Ext.reg('userprofile2', userprofile2);

userprofile2 = new userprofile2();