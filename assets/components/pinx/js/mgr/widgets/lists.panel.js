PinX.panel.Lists = function(config) {
    config = config || {};
    Ext.apply(config,{
        border: false
        ,url: PinX.config.connectorUrl
        ,baseCls: 'modx-formpanel'
        ,cls: 'container'
        ,items: [{
            html: '<h2>'+config.listtitle+'</h2>'
            ,border: false
            ,cls: 'modx-page-header'
        },{
            xtype: 'modx-panel'
            ,defaults: { border: false, autoHeight: true }
            ,border: true
            ,activeItem: 0
            ,hideMode: 'offsets'
            ,items: [{
                items: [
                    {
                        xtype: 'pinx-grid-images'
                        ,eventid: config.listid
                        ,preventRender: true
                        ,cls: 'main-wrapper'
                    }
                ]
            }]
        }]
    });
    PinX.panel.Lists.superclass.constructor.call(this,config);
};
Ext.extend(PinX.panel.Lists,MODx.Panel);
Ext.reg('pinx-panel-event',PinX.panel.Lists);
