RocketBooking.page.Lists = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        buttons: [{
            text: _('pinx.back_to_lists')
            ,id: 'pinx-btn-back'
            ,handler: function() {
                MODx.loadPage('?a=index&namespace='+PinX.request.namespace);
            }
            ,scope: this
        }]
        ,components: [{
            xtype: 'pinx-panel-lists'
            ,renderTo: 'pinx-panel-lists-div'
            ,listid: config.listid
            ,listtitle: config.listtitle
        }]
    });
    PinX.page.Lists.superclass.constructor.call(this,config);
};
Ext.extend(PinX.page.Lists,MODx.Component);
Ext.reg('pinx-page-lists',PinX.page.Lists);
