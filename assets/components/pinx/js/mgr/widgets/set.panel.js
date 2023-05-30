PinX.panel.Set = function(config) {
    config = config || {};
    Ext.apply(config,{
        border: false
        ,baseCls: 'modx-formpanel'
        ,cls: 'container'
        ,items: [{
            html: '<h2>'+_('pinx')+'</h2>'
            ,border: false
            ,cls: 'modx-page-header'
        },{
            xtype: 'modx-panel'
            ,defaults: { border: false, autoHeight: true }
            ,border: true
            ,activeItem: 0
            ,hideMode: 'offsets'
            ,items: [{
                // title: _('pinx.items')
                items: [
                    // {
                    //     html: '<p>'+_('pinx.item_intro_msg')+'</p>'
                    //     ,border:false
                    //     ,bodyCssClass: 'panel-desc'
                    // }
                    {
                        xtype: 'pinx-grid-items'
                        ,setid: config.setid
                        ,preventRender: true
                        ,cls: 'main-wrapper'
                    }
                ]
            }]
        }]
    });
    PinX.panel.Set.superclass.constructor.call(this,config);
};
Ext.extend(PinX.panel.Set,MODx.Panel);
Ext.reg('pinx-panel-set',PinX.panel.Set);
