PinX.page.Home = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        components: [{
            xtype: 'pinx-panel-home'
            ,renderTo: 'pinx-panel-home-div'
        }]
    });
    PinX.page.Home.superclass.constructor.call(this,config);

};
Ext.extend(PinX.page.Home,MODx.Component);
Ext.reg('pinx-page-home',PinX.page.Home);
