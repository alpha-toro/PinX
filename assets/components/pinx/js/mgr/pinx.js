var PinX = function(config) {
    config = config || {};
    PinX.superclass.constructor.call(this,config);
};
Ext.extend(PinX,Ext.Component,{
    page:{},window:{},grid:{},tree:{},panel:{},combo:{},config: {},view: {}
});
Ext.reg('pinx',PinX);
PinX = new PinX();


PinX.PanelSpacer = { html: '<br />', border: false, cls: 'pinx-panel-spacer' };
