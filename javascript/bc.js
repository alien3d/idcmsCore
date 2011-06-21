
Ext.apply(Ext.form.VTypes, {
    dollar: function() {
        var regex = /^\$?[0-9]+(,[0-9]{3})*(\.[0-9]{2})?$/;
        return function(strValue) {
            if (!regex(strValue)) {
                return false;
            }
        };
    },
    dollarMask: /[\d\$\,,.]/,
    dollarText: 'Not a valid dollar amount.  Must be in the format "$230.45" ($ symbol and cents optional).'
});
Ext.override(Ext.form.ComboBox, {
    setValue: function(v) {
        var text = v;
        if (this.valueField) {
            if (this.mode == "remote" && !Ext.isDefined(this.store.totalLength)) {
                this.store.on("load", this.setValue.createDelegate(this, arguments), null, {
                    single: true
                });
                if (this.store.lastOptions === null) {
                    var params;
                    if (this.valueParam) {
                        params = {};
                        params[this.valueParam] = v;
                    } else {
                        var q = this.allQuery;
                        this.lastQuery = q;
                        this.store.setBaseParam(this.queryParam, q);
                        params = this.getParams(q);
                    }
                    this.store.load({
                        params: params
                    });
                }
                return;
            }
            var r = this.findRecord(this.valueField, v);
            if (r) {
                text = r.data[this.displayField];
            } else {
                if (this.valueNotFoundText !== undefined) {
                    text = this.valueNotFoundText;
                }
            }
        }
        this.lastSelectionText = text;
        if (this.hiddenField) {
            this.hiddenField.value = v;
        }
        Ext.form.ComboBox.superclass.setValue.call(this, text);
        this.value = v;
    }
});
function is_int(value) {
    if ((parseFloat(value) == parseInt(value)) && !isNaN(parseInt(value))) {
        return true;
    } else {
        return false;
    }
}
Ext.ns("Ext.ux.form");
Ext.ux.form.ComboBoxMatch = Ext.extend(Ext.form.ComboBox, {
    anyMatch: true,
    caseSensitive: false,
    createValueMatcher: function(value) {
        if (Ext.isEmpty(value, false)) {
            return new RegExp("^");
        }
        value = Ext.escapeRe(String(value));
        return new RegExp((this.anyMatch === true ? "": "^") + "(" + value + ")", this.caseSensitive ? "": "i");
    },
    prepareData: function(data) {
        var result = Ext.apply({},
        data);
        result[this.displayField] = data[this.displayField].replace(this.createValueMatcher(this.getRawValue()),
        function(a, b) {
            if (typeof b != "string") {
                return "";
            }
            return '<span class="mark-combo-match">' + b + "</span>";
        });
        return result;
    },
    initList: function() {
        Ext.ux.form.ComboBoxMatch.superclass.initList.apply(this, arguments);
        this.view.prepareData = this.prepareData.createDelegate(this);
    },
    doQuery: function(q, forceAll) {
        if (q === undefined || q === null) {
            q = "";
        }
        var qe = {
            query: q,
            forceAll: forceAll,
            combo: this,
            cancel: false
        };
        if (this.fireEvent("beforequery", qe) === false || qe.cancel) {
            return false;
        }
        q = qe.query;
        forceAll = qe.forceAll;
        if (forceAll === true || (q.length >= this.minChars)) {
            if (this.lastQuery !== q) {
                this.lastQuery = q;
                if (this.mode == "local") {
                    this.selectedIndex = -1;
                    if (forceAll) {
                        this.store.clearFilter();
                    } else {
                        this.store.filter(this.displayField, this.createValueMatcher(q));
                    }
                    this.onLoad();
                } else {
                    if (this.store) {
                        this.store.baseParams[this.queryParam] = q;
                        this.store.load({
                            params: this.getParams(q)
                        });
                        this.expand();
                    }
                }
            } else {
                this.selectedIndex = -1;
                this.onLoad();
            }
        }
    }
});
Ext.ns("Ext.ux.grid");
if ("function" !== typeof RegExp.escape) {
    RegExp.escape = function(s) {
        if ("string" !== typeof s) {
            return s;
        }
        return s.replace(/([.*+?\^=!:${}()|\[\]\/\\])/g, "\\$1");
    };
}
Ext.ux.grid.RowActions = function(config) {
    Ext.apply(this, config);
    this.addEvents("beforeaction", "action", "beforegroupaction", "groupaction");
    Ext.ux.grid.RowActions.superclass.constructor.call(this);
};
Ext.extend(Ext.ux.grid.RowActions, Ext.util.Observable, {
    actionEvent: "click",
    autoWidth: true,
    dataIndex: "",
    header: "",
    isColumn: true,
    keepSelection: false,
    menuDisabled: true,
    sortable: false,
    tplGroup: '<tpl for="actions"><div class="ux-grow-action-item<tpl if="\'right\'===align"> ux-action-right</tpl> {cls}" style="{style}" qtip="{qtip}">{text}</div></tpl>',
    tplRow: '<div class="ux-row-action"><tpl for="actions"><div class="ux-row-action-item {cls} <tpl if="text">ux-row-action-text</tpl>" style="{hide}{style}" qtip="{qtip}"><tpl if="text"><span qtip="{qtip}">{text}</span></tpl></div></tpl></div>',
    hideMode: "visiblity",
    widthIntercept: 4,
    widthSlope: 21,
    init: function(grid) {
        this.grid = grid;
        this.id = this.id || Ext.id();
        var lookup = grid.getColumnModel().lookup;
        delete(lookup[undefined]);
        lookup[this.id] = this;
        if (!this.tpl) {
            this.tpl = this.processActions(this.actions);
        }
        if (this.autoWidth) {
            this.width = this.widthSlope * this.actions.length + this.widthIntercept;
            this.fixed = true;
        }
        var view = grid.getView();
        var cfg = {
            scope: this
        };
        cfg[this.actionEvent] = this.onClick;
        grid.afterRender = grid.afterRender.createSequence(function() {
            view.mainBody.on(cfg);
            grid.on("destroy", this.purgeListeners, this);
        },
        this);
        if (!this.renderer) {
            this.renderer = function(value, cell, record, row, col, store) {
                cell.css += (cell.css ? " ": "") + "ux-row-action-cell";
                return this.tpl.apply(this.getData(value, cell, record, row, col, store));
            }.createDelegate(this);
        }
        if (view.groupTextTpl && this.groupActions) {
            view.interceptMouse = view.interceptMouse.createInterceptor(function(e) {
                if (e.getTarget(".ux-grow-action-item")) {
                    return false;
                }
            });
            view.groupTextTpl = '<div class="ux-grow-action-text">' + view.groupTextTpl + "</div>" + this.processActions(this.groupActions, this.tplGroup).apply();
        }
        if (true === this.keepSelection) {
            grid.processEvent = grid.processEvent.createInterceptor(function(name, e) {
                if ("mousedown" === name) {
                    return ! this.getAction(e);
                }
            },
            this);
        }
    },
    getData: function(value, cell, record, row, col, store) {
        return record.data || {};
    },
    processActions: function(actions, template) {
        var acts = [];
        Ext.each(actions,
        function(a, i) {
            if (a.iconCls && "function" === typeof(a.callback || a.cb)) {
                this.callbacks = this.callbacks || {};
                this.callbacks[a.iconCls] = a.callback || a.cb;
            }
            var o = {
                cls: a.iconIndex ? "{" + a.iconIndex + "}": (a.iconCls ? a.iconCls: ""),
                qtip: a.qtipIndex ? "{" + a.qtipIndex + "}": (a.tooltip || a.qtip ? a.tooltip || a.qtip: ""),
                text: a.textIndex ? "{" + a.textIndex + "}": (a.text ? a.text: ""),
                hide: a.hideIndex ? '<tpl if="' + a.hideIndex + '">' + ("display" === this.hideMode ? "display:none": "visibility:hidden") + ";</tpl>": (a.hide ? ("display" === this.hideMode ? "display:none": "visibility:hidden;") : ""),
                align: a.align || "right",
                style: a.style ? a.style: ""
            };
            acts.push(o);
        },
        this);
        var xt = new Ext.XTemplate(template || this.tplRow);
        return new Ext.XTemplate(xt.apply({
            actions: acts
        }));
    },
    getAction: function(e) {
        var action = false;
        var t = e.getTarget(".ux-row-action-item");
        if (t) {
            action = t.className.replace(/ux-row-action-item /, "");
            if (action) {
                action = action.replace(/ ux-row-action-text/, "");
                action = action.trim();
            }
        }
        return action;
    },
    onClick: function(e, target) {
        var view = this.grid.getView();
        var row = e.getTarget(".x-grid3-row");
        var col = view.findCellIndex(target.parentNode.parentNode);
        var action = this.getAction(e);
        if (false !== row && false !== col && false !== action) {
            var record = this.grid.store.getAt(row.rowIndex);
            if (this.callbacks && "function" === typeof this.callbacks[action]) {
                this.callbacks[action](this.grid, record, action, row.rowIndex, col);
            }
            if (true !== this.eventsSuspended && false === this.fireEvent("beforeaction", this.grid, record, action, row.rowIndex, col)) {
                return;
            } else {
                if (true !== this.eventsSuspended) {
                    this.fireEvent("action", this.grid, record, action, row.rowIndex, col);
                }
            }
        }
        t = e.getTarget(".ux-grow-action-item");
        if (t) {
            var group = view.findGroup(target);
            var groupId = group ? group.id.replace(/ext-gen[0-9]+-gp-/, "") : null;
            var records;
            if (groupId) {
                var re = new RegExp(RegExp.escape(groupId));
                records = this.grid.store.queryBy(function(r) {
                    return r._groupId.match(re);
                });
                records = records ? records.items: [];
            }
            action = t.className.replace(/ux-grow-action-item (ux-action-right )*/, "");
            if ("function" === typeof this.callbacks[action]) {
                this.callbacks[action](this.grid, records, action, groupId);
            }
            if (true !== this.eventsSuspended && false === this.fireEvent("beforegroupaction", this.grid, records, action, groupId)) {
                return false;
            }
            this.fireEvent("groupaction", this.grid, records, action, groupId);
        }
    }
});
Ext.reg("rowactions", Ext.ux.grid.RowActions);
Ext.ux.GridPrinter = {
    print: function(grid) {
        var columns = grid.getColumnModel().config;
        var data = [];
        grid.store.data.each(function(item) {
            var convertedData = [];
            var i = 0;
            for (var key in item.data) {
                var value = item.data[key];
                if (i > 0) {
                    Ext.each(columns,
                    function(column) {
                        if (column.dataIndex == key) {
                            convertedData[key] = column.renderer ? column.renderer(value) : value;
                        }
                    },
                    this);
                }
                i++;
            }
            data.push(convertedData);
        });
        var headings = Ext.ux.GridPrinter.headerTpl.apply(columns);
        var body = Ext.ux.GridPrinter.bodyTpl.apply(columns);
        var html = new Ext.XTemplate('<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">', "<html>", "<head>", '<meta content="Content-Type: application/vnd.ms-excel"; charset=UTF-8" http-equiv="Content-Type" />', '<link href="' + Ext.ux.GridPrinter.stylesheetPath + '" rel="stylesheet" type="text/css" media="screen,print" />', "<title>" + grid.title + "</title>", "</head>", "<body>", "<table>", headings, '<tpl for=".">', body, "</tpl>", "</table>", "</body>", "</html>").apply(data);
        var win = window.open("", "printgrid");
        win.document.write(html);
    },
    stylesheetPath: "../js/resources/css/report.css",
    headerTpl: new Ext.XTemplate("<tr>", '<tpl for=".">', "<th>{header}</th>", "</tpl>", "</tr>"),
    bodyTpl: new Ext.XTemplate("<tr>", '<tpl for=".">', "<td>{{dataIndex}}</td>", "</tpl>", "</tr>")
};
Ext.namespace("Ext.ux.plugins");
Ext.ux.plugins.PageComboResizer = Ext.extend(Object, {
    pageSizes: [5, 10, 15, 20, 25, 30, 50, 75, 100, 200, 300, 500],
    prefixText: "Showing ",
    postfixText: "records per page.",
    constructor: function(config) {
        Ext.apply(this, config);
        Ext.ux.plugins.PageComboResizer.superclass.constructor.call(this, config);
    },
    init: function(pagingToolbar) {
        var ps = this.pageSizes;
        var combo = new Ext.form.ComboBox({
            typeAhead: true,
            triggerAction: "all",
            lazyRender: true,
            mode: "local",
            width: 45,
            store: ps,
            listeners: {
                select: function(c, r, i) {
                    pagingToolbar.pageSize = ps[i];
                    var rowIndex = 0;
                    var gp = pagingToolbar.findParentBy(function(ct, cmp) {
                        return (ct instanceof Ext.grid.GridPanel) ? true: false;
                    });
                    var sm = gp.getSelectionModel();
                    if (undefined != sm && sm.hasSelection()) {
                        if (sm instanceof Ext.grid.RowSelectionModel) {
                            rowIndex = gp.store.indexOf(sm.getSelected());
                        } else {
                            if (sm instanceof Ext.grid.CellSelectionModel) {
                                rowIndex = sm.getSelectedCell()[0];
                            }
                        }
                    }
                    rowIndex += pagingToolbar.cursor;
                    pagingToolbar.doLoad(Math.floor(rowIndex / pagingToolbar.pageSize) * pagingToolbar.pageSize);
                }
            }
        });
        Ext.iterate(this.pageSizes,
        function(ps) {
            if (ps == pagingToolbar.pageSize) {
                combo.setValue(ps);
                return;
            }
        });
        var inputIndex = pagingToolbar.items.indexOf(pagingToolbar.refresh);
        pagingToolbar.insert(++inputIndex, "-");
        pagingToolbar.insert(++inputIndex, this.prefixText);
        pagingToolbar.insert(++inputIndex, combo);
        pagingToolbar.insert(++inputIndex, this.postfixText);
        pagingToolbar.on({
            beforedestroy: function() {
                combo.destroy();
            }
        });
    }
});

//JavaScript Document
/**
 * Ext.ux.form.IconComboBox Extension Class for Ext 2.x Library
 *
 * @author  Ing. Jozef Sakalos
 * @version $Id: IconCombo.js,v 1.1 2010/01/29 10:14:25 jcarbou Exp $
 *
 * @license Ext.ux.form.IconComboBox is licensed under the terms of
 * the Open Source LGPL 3.0 license.  Commercial use is permitted to the extent
 * that the code/component(s) do NOT become part of another Open Source or Commercially
 * licensed development library or toolkit without explicit permission.
 * 
 * License details: http://www.gnu.org/licenses/lgpl.html
 */

/**
 * @class Ext.ux.form.IconComboBox
 * @extends Ext.form.ComboBox
 */
Ext.namespace('Ext.ux.form');
Ext.ux.form.IconCombo = Ext.extend(Ext.form.ComboBox, {
    initComponent:function() {
		this.iconWidth = this.iconWidth || 16;
		var iw = this.iconWidth;
		
		// Add, if not already exist, css for icon width
		if (!Ext.util.CSS.getRule('ux-icon-combo-icon-'+iw)) {
			var css = '.ux-icon-combo-icon-'+iw+' {background-repeat: no-repeat;background-position: 0 50%;width: '+(iw+2)+'px;height: 14px;}'
	        + '.ux-icon-combo-input-'+iw+' {padding-left: '+(iw+9)+'px;}'
	        + '.x-form-field-wrap .ux-icon-combo-icon-'+iw+' {top: 4px;left: 5px;}'
	        + '.ux-icon-combo-item-'+iw+' {background-repeat: no-repeat ! important;background-position: 3px 50% ! important;padding-left: '+(iw+8)+'px ! important;}';
			Ext.util.CSS.createStyleSheet(css, 'ux-IconCombo-css-'+iw);
		}
        
        this.iconClsTpl = this.iconClsTpl || ('{' + this.iconClsField + '}');	
		
        Ext.apply(this, {
            tpl:  '<tpl for=".">'
                + '<div class="x-combo-list-item ux-icon-combo-item-'+iw+' '+ this.iconClsTpl+'">'
                + '{' + this.displayField + '}'
                + '</div></tpl>'
        });
		
		this.iconClsTpl = new Ext.Template(this.iconClsTpl);

        // call parent initComponent
        Ext.ux.form.IconCombo.superclass.initComponent.apply(this, arguments);

    } // eo function initComponent

    ,onRender:function(ct, position) {
        // call parent onRender
        Ext.ux.form.IconCombo.superclass.onRender.apply(this, arguments);

        // adjust styles
        this.wrap.applyStyles({position:'relative'});
        this.el.addClass('ux-icon-combo-input-'+this.iconWidth);

        // add div for icon
        this.icon = Ext.DomHelper.append(this.el.up('div.x-form-field-wrap'), {
            tag: 'div', style:'position:absolute'
        });
    } // eo function onRender

    ,afterRender:function() {
        Ext.ux.form.IconCombo.superclass.afterRender.apply(this, arguments);
        if(undefined !== this.value) {
            this.setValue(this.value);
        }
    } // eo function afterRender
    ,setIconCls:function() {
        var rec = this.store.query(this.valueField || this.displayField, this.getValue()).itemAt(0);
        if(rec && this.icon) {
			this.icon.className = 'ux-icon-combo-icon-'+this.iconWidth +' '+ this.iconClsTpl.apply(rec.data);
        }
    } // eo function setIconCls

    ,reset:function(value) {
       Ext.ux.form.IconCombo.superclass.reset.apply(this, arguments);
       this.icon.className = ''; 
    } // eo function reset

    ,setValue: function(value) {
        Ext.ux.form.IconCombo.superclass.setValue.call(this, value);
        this.setIconCls();
    } // eo function setValue


});

// register xtype
Ext.reg('iconcombo', Ext.ux.form.IconCombo);

