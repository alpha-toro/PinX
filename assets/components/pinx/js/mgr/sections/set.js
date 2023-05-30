PinX.page.Set = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        buttons: [{
            text: _('pinx.back_to_sets')
            ,id: 'pinx-btn-back'
            ,handler: function() {
                MODx.loadPage('?a=index&namespace='+PinX.request.namespace);
            }
            ,scope: this
        }]
        ,components: [{
            xtype: 'pinx-panel-set'
            ,renderTo: 'pinx-panel-set-div'
            ,setid: config.setid
        }]
    });
    PinX.page.Set.superclass.constructor.call(this,config);
};
Ext.extend(PinX.page.Set,MODx.Component);
Ext.reg('pinx-page-set',PinX.page.Set);
