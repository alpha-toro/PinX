PinX.grid.Items = function(config) {
    config = config || {};

    this.exp = new Ext.grid.RowExpander({
        tpl: new Ext.Template(
            '<p class="image">{image}</p>'
        )
    });

    Ext.applyIf(config,{
        id: 'pinx-grid-items'
        ,url: PinX.config.connectorUrl
        ,baseParams: {
            action: 'mgr/item/getlist'
            ,set: config.setid
        }
        ,fields: ['id', 'title', 'image', 'set', 'rank', 'actions']
        ,paging: true
        ,ddGroup: 'mygridDD'
        ,enableDragDrop: true
        ,remoteSort: false
        ,cls: 'gallery-grid'
        ,bodyCssClass: 'grid-with-buttons'
        ,autosave: true
        ,preventRender: true
        ,autoExpandColumn: 'title'
        //,plugins: [this.exp]
        ,viewConfig: {
            forceFit:true
            ,enableRowBody:true
            ,showPreview:true
            //,getRowClass: this.applyRowClass
            ,scrollOffset: 0
        }
        ,sortInfo: {
            field: 'rank'
            ,direction: 'ASC'
        }
        ,columns: [
          //this.exp,
          {
            header: _('pinx.title')
            ,dataIndex: 'title'
            //,renderer: {fn:this._renderTitle, scope: this}
          },
          {
            header: _('pinx.image')
            ,dataIndex: 'image'
            ,renderer: {fn:this._renderImage, scope: this}
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
                            rows = sm.getSelections();

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
        ,tbar: [
            {
                text: _('pinx.item_create')
                ,handler: this.createItem
                ,scope: this
            }
            ,{
                xtype: 'textfield'
                ,id: 'pinx-tf-search'
                ,emptyText: _('search')+'...'
                ,listeners: {
                    'change': {fn: this.search, scope: this}
                    ,'render': {fn: function(cmp) {
                        new Ext.KeyMap(cmp.getEl(), {
                            key: Ext.EventObject.ENTER
                            ,fn: function() {
                                this.fireEvent('change',this);
                                this.blur();
                                return true;
                            }
                            ,scope: cmp
                        });
                    },scope:this}
                }
            }
            ,'-'
            ,{
                xtype: 'button'
                ,id: 'modx-filter-clear'
                ,text: _('filter_clear')
                ,listeners: {
                    'click': {fn: this.clearFilter, scope: this}
                }
            }
        ]
    });
    PinX.grid.Items.superclass.constructor.call(this,config);
    this._makeTemplate();
    this.addEvents('sort');
    this.on('sort',this.onSort,this);
    this.on('click', this.handleButtons, this);
};
Ext.extend(PinX.grid.Items,MODx.grid.Grid,{
    windows: {}

    ,onSort: function(o) {
        MODx.Ajax.request({
            url: this.config.url
            ,params: {
                action: 'mgr/item/sort'
                ,set: this.config.setid
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

    ,_makeTemplate: function() {
        this.tplImage = new Ext.XTemplate('<tpl for="."><img width="250" src="{image}"></tpl>', {
            compiled: true
        });
    }

    ,applyRowClass: function(record, rowIndex, p, ds) {
        if (this.grid.viewConfig.showPreview) {
            var xf = Ext.util.Format;
            //p.body = '<p>' + xf.ellipsis(xf.stripTags(record.data.image), 300) + '</p>';
            p.body = '<p>PREVIEW</p>';
            return 'x-grid3-row-expanded';
        }
        return 'x-grid3-row-collapsed';
    }

    ,clearFilter: function() {
        var s = this.getStore();
        s.baseParams.query = '';
        Ext.getCmp('pinx-tf-search').reset();
        this.getBottomToolbar().changePage(1);
        this.refresh();
    }

    ,search: function(tf,newValue,oldValue) {
        var s = this.getStore();
        s.baseParams.query = tf.getValue();
        this.getBottomToolbar().changePage(1);
        this.refresh();
    }

    ,getMenu: function() {
        var m = [];
        m.push({
            text: _('pinx.item_update')
            ,handler: this.updateItem
        });
        m.push('-');
        m.push({
            text: _('pinx.item_remove')
            ,handler: this.removeItem
        });
        this.addContextMenuItem(m);
    }

    ,createItem: function(btn,e) {
        if (!this.config || !this.config.setid) return false;
        var s = this.config.setid;

        this.windows.createItem = MODx.load({
            xtype: 'pinx-window-item-create'
            ,set: s
            ,listeners: {
                'success': {fn:function() {this.refresh();},scope:this}
            }
        });
        this.windows.createItem.show(e.target);
    }

    ,updateItem: function(btn,e) {
        if (!this.menu.record || !this.menu.record.id) return false;
        var r = this.menu.record;

        this.windows.updateItem = MODx.load({
            xtype: 'pinx-window-item-update'
            ,record: r
            ,listeners: {
                'success': {fn:function() {this.refresh();},scope:this}
            }
        });
        this.windows.updateItem.fp.getForm().setValues(r);
        this.windows.updateItem.show(e.target);
    }

    ,removeItem: function(btn,e) {
        if (!this.menu.record) return false;

        MODx.msg.confirm({
            title: _('pinx.item_remove')
            ,text: _('pinx.item_remove_confirm')
            ,url: PinX.config.connectorUrl
            ,params: {
                action: 'mgr/item/remove'
                ,id: this.menu.record.id
            }
            ,listeners: {
                'success': {fn:function(r) {this.refresh();},scope:this}
            }
        });
    }

    ,_renderTitle: function(value, p, record) {
        return this.tplTitle.apply(record.data);
    }

    ,_renderImage: function(value, p, record) {
        return this.tplImage.apply(record.data);
    }

    ,publishItem: function() {
        MODx.Ajax.request({
            url: PinX.config.connectorUrl
            ,params: {
                action: 'mgr/item/publish'
                ,id: this.menu.record.id
            }
            ,listeners: {
                'success': {fn: this.refresh, scope: this}
            }
        });
        return true;

    }

    ,unpublishItem: function(record) {
        MODx.Ajax.request({
            url: PinX.config.connectorUrl
            ,params: {
                action: 'mgr/item/unpublish'
                ,id: this.menu.record.id
            }
            ,listeners: {
                'success': {fn: this.refresh, scope: this}
            }
        });
        return true;
    }

    ,handleButtons: function(e) {
        var target  = e.getTarget();
        var element = target.className.split(' ')[0];
        if (element == 'controlBtn') {
            var action       = target.className.split(' ')[1];
            var record       = this.getSelectionModel().getSelected().data;
            this.menu.record = record;
            switch (action) {
                case 'edit':
                    this.updateItem(null, e);
                    break;
                case 'publish':
                    this.publishItem();
                    break;
                case 'unpublish':
                    this.unpublishItem();
                    break;
                case 'delete':
                    this.removeItem();
                    break;
                default:
                    break;
            }
        }
    }
});
Ext.reg('pinx-grid-items',PinX.grid.Items);


PinX.window.CreateItem = function(config) {
    config = config || {};
    this.ident = config.ident || 'mecitem'+Ext.id();
    Ext.applyIf(config,{
        title: _('pinx.item_create')
        ,id: this.ident
        ,autoHeight: true
        ,width: 650
        ,modal: true
        ,url: PinX.config.connectorUrl
        ,closeAction: 'close'
        ,baseParams: {
            action: 'mgr/item/create'
            ,set: config.set
        }
        ,fields: [{
            xtype: 'textfield'
            ,fieldLabel: _('pinx.title')
            ,name: 'title'
            ,id: 'pinx-'+this.ident+'-title'
            ,anchor: '100%'
        },{
            xtype: 'textfield'
            ,allowBlank: false
            ,fieldLabel: _('pinx.image')
            ,name: 'image'
            ,id: 'pinx-'+this.ident+'-image'
            ,anchor: '100%'
        }],
        keys: [] //Prevent enter key from submitting the form
    });
    PinX.window.CreateItem.superclass.constructor.call(this,config);
    //this.on('activate',function() {
      //  if (MODx.loadRTE) { MODx.loadRTE('pinx-'+this.ident+'-image'); }
    //});
};
Ext.extend(PinX.window.CreateItem,MODx.Window);
Ext.reg('pinx-window-item-create',PinX.window.CreateItem);


PinX.window.UpdateItem = function(config) {
    config = config || {};
    this.ident = config.ident || 'meuitem'+Ext.id();
    Ext.applyIf(config,{
        title: _('pinx.item_update')
        ,id: this.ident
        ,autoHeight: true
        ,width: 650
        ,modal: true
        ,url: PinX.config.connectorUrl
        ,action: 'mgr/item/update'
        ,closeAction: 'close'
        ,fields: [{
            xtype: 'hidden'
            ,name: 'id'
            ,id: 'pinx-'+this.ident+'-id'
        },{
            xtype: 'textfield'
            ,fieldLabel: _('pinx.title')
            ,name: 'title'
            ,id: 'pinx-'+this.ident+'-title'
            ,anchor: '100%'
        },{
            xtype: 'textfield'
            ,fieldLabel: _('pinx.image')
            ,name: 'image'
            ,id: 'pinx-'+this.ident+'-image'
            ,anchor: '100%'
        }],
        keys: [] //Prevent enter key from submitting the form
    });
    PinX.window.UpdateItem.superclass.constructor.call(this,config);
    //this.on('activate',function() {
      //  if (MODx.loadRTE) { MODx.loadRTE('pinx-'+this.ident+'-image'); }
    //});
};
Ext.extend(PinX.window.UpdateItem,MODx.Window);
Ext.reg('pinx-window-item-update',PinX.window.UpdateItem);
