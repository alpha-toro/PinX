PinX.grid.Lists = function(config) {
    config = config || {};
    var gridView = new Ext.grid.GridView({
        forceFit: true
        ,scrollOffset: 0
        ,getRowClass : function (row, index) {
            var cls = '';
            var data = row.data;
            return cls;
        }
    });  //end gridView

    Ext.applyIf(config,{
        id: 'pinx-grid-lists'
        ,url: PinX.config.connectorUrl
        ,baseParams: { action: 'mgr/lists/getlist' }
        ,fields: ['id','title','description','rank']
        ,autoHeight: true
        ,paging: true
        ,ddGroup: 'mygridDD'
        ,enableDragDrop: true
        ,remoteSort: true
        ,anchor: '97%'
        ,autoExpandColumn: 'title'
        ,save_action: 'mgr/lists/updatefromgrid'
        ,autosave: true
        ,view: gridView
        ,columns: [
            {
                header: _('id')
                ,dataIndex: 'id'
                ,width: 25
            }
            ,{
                header: _('title')
                ,dataIndex: 'Title'
                ,width: 100
                ,editor: { xtype: 'textfield' }
            }
            ,{
                header: _('description')
                ,dataIndex: 'description'
                ,width: 300
                ,editor: { xtype: 'textfield' }
            }
            
        ]
        ,listeners: {
            "render": {
                scope: this
                ,fn: function(grid) {
                    var ddrow = new Ext.dd.DropTarget(grid.container, {
                        ddGroup: 'mygridDD'
                        ,copy: false
                        ,notifyDrop: function(dd, e, data) { // thing being dragged, event, data from dagged source
                            var ds = grid.store;
                            var sm = grid.getSelectionModel();
                            rows   = sm.getSelections();

                            if (dd.getDragData(e)) {
                                var targetNode = dd.getDragData(e).selections[0];
                                var sourceNode = data.selections[0];

                                grid.fireEvent('sort',{
                                    target: targetNode
                                    ,source: sourceNode
                                    ,event: e
                                    ,dd: dd
                                });
                            }
                        }
                    });
                }
            }
        }
        ,tbar: [{
            text: _('pinx.list_create')
            ,handler: this.createList
            ,scope: this
        }]
    });
    PinX.grid.Lists.superclass.constructor.call(this,config);
    this.addLists('sort');
    this.on('sort',this.onSort,this);
};
Ext.extend(PinX.grid.Lists,MODx.grid.Grid,{
    windows: {}

    ,onSort: function(o) {
        MODx.Ajax.request({
            url: this.config.url
            ,params: {
                action: 'mgr/lists/sort'
                ,source: o.source.id
                ,target: o.target.id
            }
            ,listeners: {
                'success':{fn:function(r) {
                    this.refresh();
                },scope:this}
            }
        });
    }
    ,getMenu: function() {
        var record = this.menu.record;
        var m = [];
        m.push({
            text: _('pinx.lists_manage')
            ,handler: this.manageEvent
        });
        m.push({
            text: _('pinx.lists_update')
            ,handler: this.updateEvent
        });

        m.push('-');
        m.push({
            text: _('pinx.lists_remove')
            ,handler: this.removeList
        });
        this.addContextMenuItem(m);
    }

    ,manageList: function() {
        var redir = '?a=event&namespace='+MODx.request.namespace+'&listid=';

        // needed for double click
        if (typeof(this.menu.record) == "undefined") {
            redir += this.getSelectedAsList();
        } else {
            redir += this.menu.record.id+'&listtitle='+this.menu.record.title;
        }
        MODx.loadPage(redir);
    }

    ,createList: function(btn,e) {
        e.preventDefault();
        if (!this.windows.createList) {
            this.windows.createList = MODx.load({
                xtype: 'pinx-window-list-create'
                ,listeners: {
                    'success': {fn:function() {this.refresh();},scope:this}
                }
            });
        }
        this.windows.createList.fp.getForm().reset();
        this.windows.createList.show(e.target);
    }

    ,updateList: function(btn,e) {
        e.preventDefault();
        if (!this.menu.record || !this.menu.record.id) return false;
        var r = this.menu.record;

        if (!this.windows.updateList) {
            this.windows.updateList = MODx.load({
                xtype: 'pinx-window-list-update'
                ,record: r
                ,listeners: {
                    'success': {fn:function() {this.refresh();},scope:this}
                }
            });
        }
        this.windows.updateList.fp.getForm().reset();
        this.windows.updateList.fp.getForm().setValues(r);
        this.windows.updateList.show(e.target);
    }

    ,removeList: function(btn,e) {
        if (!this.menu.record) return false;

        MODx.msg.confirm({
            title: _('pinx.lists_remove')
            ,text: _('pinx.lists_remove_confirm')
            ,url: this.config.url
            ,params: {
                action: 'mgr/lists/remove'
                ,id: this.menu.record.id
            }
            ,listeners: {
                'success': {fn:function(r) {this.refresh();},scope:this}
            }
        });
    }
});
Ext.reg('pinx-grid-lists',PinX.grid.Lists);


PinX.window.CreateLists = function(config) {
    config = config || {};
    this.ident = config.ident || 'mecset'+Ext.id();
    Ext.applyIf(config,{
        title: _('pinx.lists_create')
        ,id: this.ident
        ,autoHeight: true
        ,width: 475
        ,modal: true
        ,url: PinX.config.connectorUrl
        ,action: 'mgr/lists/create'
        ,fields: [{
            xtype: 'textfield'
            ,fieldLabel: _('title')
            ,name: 'title'
            ,anchor: '100%'
        },{
            xtype: 'textarea'
            ,fieldLabel: _('description')
            ,name: 'description'
            ,anchor: '100%'
        },{
            xtype: 'textfield'
            ,fieldLabel: 'Owner Name'
            ,name: 'owner_name'
            ,anchor: '100%'
        },{
            xtype: 'numberfield'
            ,fieldLabel: 'Owner ID'
            ,name: 'owner_id'
            ,anchor: '100%'
        }]
    });
    PinX.window.CreateLists.superclass.constructor.call(this,config);
};
Ext.extend(PinX.window.CreateLists,MODx.Window);
Ext.reg('rocketbooking-window-lists-create',PinX.window.CreateLists);

PinX.window.UpdateLists = function(config) {
    config = config || {};
    this.ident = config.ident || 'meuset'+Ext.id();
    Ext.applyIf(config,{
        title: _('pinx.lists_update')
        ,id: this.ident
        ,autoHeight: true
        ,width: 475
        ,modal: true
        ,url: PinX.config.connectorUrl
        ,action: 'mgr/lists/update'
        ,fields: [{
            xtype: 'hidden'
            ,name: 'id'
        },{
            xtype: 'textfield'
            ,fieldLabel: _('title')
            ,name: 'title'
            ,anchor: '100%'
        },{
            xtype: 'textarea'
            ,fieldLabel: _('description')
            ,name: 'description'
            ,anchor: '100%'
        },{
            xtype: 'textfield'
            ,fieldLabel: 'Owner Name'
            ,name: 'owner_name'
            ,anchor: '100%'
        },{
            xtype: 'numberfield'
            ,fieldLabel: 'Owner ID'
            ,name: 'owner_id'
            ,anchor: '100%'
        }]
    });
    PinX.window.UpdateLists.superclass.constructor.call(this,config);
};
Ext.extend(PinX.window.UpdateLists,MODx.Window);
Ext.reg('pinx-window-lists-update',PinX.window.UpdateLists);
