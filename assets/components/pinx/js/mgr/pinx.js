var PinX = function(config) {
    config = config || {};
    PinX.superclass.constructor.call(this,config);
};
Ext.extend(PinX,Ext.Component,{
    page:{},window:{},grid:{},tree:{},panel:{},combo:{},config: {},view: {}
});
Ext.reg('pinx',PinX);
PinX = new PinX();

PinX.combo.PublishStatus = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        store: [[1, _('published')], [0, _('unpublished')]]
        ,name: 'published'
        ,hiddenName: 'published'
        ,triggerAction: 'all'
        ,editable: false
        ,selectOnFocus: false
        ,preventRender: true
        ,forceSelection: true
        ,enableKeyEvents: true
    });
    PinX.combo.PublishStatus.superclass.constructor.call(this, config);
};
Ext.extend(PinX.combo.PublishStatus, MODx.combo.ComboBox);
Ext.reg('pinx-combo-publish-status', PinX.combo.PublishStatus);

PinX.PanelSpacer = { html: '<br />', border: false, cls: 'pinx-panel-spacer' };
