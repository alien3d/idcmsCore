Ext.layout.ColumnWithMarginsLayout = Ext.extend(Ext.layout.ColumnLayout, { 
    onLayout : function(ct, target) { 
        Ext.layout.ColumnWithMarginsLayout.superclass.onLayout.apply(this, arguments); 
        var me = this; 
        ct.items.each(function() { 
            if (this.margins) { 
                var box = this.getEl().findParent('.' + me.extraCls); 
                if (box) { 
                    box = Ext.get(box); 
                    box.setStyle({ 
                        'margin-left': this.margins.left, 
                        'margin-top': this.margins.top, 
                        'margin-right': this.margins.right, 
                        'margin-bottom': this.margins.bottom 
                    }); 
                } 
            } 
        }); 
    } 
}); 

Ext.Container.LAYOUTS['columnwithmargins'] = Ext.layout.ColumnWithMarginsLayout; 
