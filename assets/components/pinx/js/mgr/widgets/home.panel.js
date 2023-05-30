PinX.panel.Home = function(config) {
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
            ,defaults: { border: false ,autoHeight: true }
            ,border: true
            ,activeItem: 0
            ,hideMode: 'offsets'
            ,items: [
                {
                    // title: _('pinx.sets')
                    items: [
                        // {
                        //     html: '<p>'+_('pinx.set_intro_msg')+'</p>'
                        //     ,border: false
                        //     ,bodyCssClass: 'panel-desc'
                        // }
                        {
                            xtype: 'pinx-grid-sets'
                            ,preventRender: true
                            ,cls: 'main-wrapper'
                        }
                    ]
                }
            ]
        }]
    });
    PinX.panel.Home.superclass.constructor.call(this,config);
};
Ext.extend(PinX.panel.Home,MODx.Panel);
Ext.reg('pinx-panel-home',PinX.panel.Home);
