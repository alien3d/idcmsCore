Ext.namespace('Ext.ux.plugin');
Ext.onReady(function() {
    var CSS = Ext.util.CSS;
    if (CSS) {
        CSS.getRule('.x-hide-nosize') || CSS.createStyleSheet('.x-hide-nosize{height:0px!important;width:0px!important;border:none!important;zoom:1;}.x-hide-nosize * {height:0px!important;width:0px!important;border:none!important;zoom:1;}');
        CSS.refreshCache();
    }
});
(function() {
    var El = Ext.Element,
    A = Ext.lib.Anim,
    supr = El.prototype;
    var VISIBILITY = "visibility",
    DISPLAY = "display",
    HIDDEN = "hidden",
    NONE = "none";
    var fx = {};
    fx.El = {
        setDisplayed: function(value) {
            var me = this;
            me.visibilityCls ? (me[value !== false ? 'removeClass': 'addClass'](me.visibilityCls)) : supr.setDisplayed.call(me, value);
            return me;
        },
        isDisplayed: function() {
            return ! (this.hasClass(this.visibilityCls) || this.isStyle(DISPLAY, NONE));
        },
        fixDisplay: function() {
            var me = this;
            supr.fixDisplay.call(me);
            me.visibilityCls && me.removeClass(me.visibilityCls);
        },
        isVisible: function(deep) {
            var vis = this.visible || (!this.isStyle(VISIBILITY, HIDDEN) && (this.visibilityCls ? !this.hasClass(this.visibilityCls) : !this.isStyle(DISPLAY, NONE)));
            if (deep !== true || !vis) {
                return vis;
            }
            var p = this.dom.parentNode,
            bodyRE = /^body/i;
            while (p && !bodyRE.test(p.tagName)) {
                if (!Ext.fly(p, '_isVisible').isVisible()) {
                    return false;
                }
                p = p.parentNode;
            }
            return true;
        },
        isStyle: supr.isStyle ||
        function(style, val) {
            return this.getStyle(style) == val;
        }
    };
    Ext.override(El.Flyweight, fx.El);
    Ext.ux.plugin.VisibilityMode = function(opt) {
        Ext.apply(this, opt || {});
        var CSS = Ext.util.CSS;
        if (CSS && !Ext.isIE && this.fixMaximizedWindow !== false && !Ext.ux.plugin.VisibilityMode.MaxWinFixed) {
            CSS.updateRule('.x-window-maximized-ct', 'overflow', '');
            Ext.ux.plugin.VisibilityMode.MaxWinFixed = true;
        }
    };
    Ext.extend(Ext.ux.plugin.VisibilityMode, Object, {
        bubble: true,
        fixMaximizedWindow: true,
        elements: null,
        visibilityCls: 'x-hide-nosize',
        hideMode: 'nosize',
        ptype: 'uxvismode',
        init: function(c) {
            var hideMode = this.hideMode || c.hideMode,
            plugin = this,
            bubble = Ext.Container.prototype.bubble,
            changeVis = function() {
                var els = [this.collapseEl, this.actionMode].concat(plugin.elements || []);
                Ext.each(els,
                function(el) {
                    plugin.extend(this[el] || el);
                },
                this);
                var cfg = {
                    visFixed: true,
                    animCollapse: false,
                    animFloat: false,
                    hideMode: hideMode,
                    defaults: this.defaults || {}
                };
                cfg.defaults.hideMode = hideMode;
                Ext.apply(this, cfg);
                Ext.apply(this.initialConfig || {},
                cfg);
            };
            c.on('render',
            function() {
                if (plugin.bubble !== false && this.ownerCt) {
                    bubble.call(this.ownerCt,
                    function() {
                        this.visFixed || this.on('afterlayout', changeVis, this, {
                            single: true
                        });
                    });
                }
                changeVis.call(this);
            },
            c, {
                single: true
            });
        },
        extend: function(el, visibilityCls) {
            el && Ext.each([].concat(el),
            function(e) {
                if (e && e.dom) {
                    if ('visibilityCls' in e) return;
                    Ext.apply(e, fx.El);
                    e.visibilityCls = visibilityCls || this.visibilityCls;
                }
            },
            this);
            return this;
        }
    });
    Ext.preg && Ext.preg('uxvismode', Ext.ux.plugin.VisibilityMode);
    Ext.provide && Ext.provide('uxvismode');
})();
(function() {
    var El = Ext.Element,
    ElFrame, ELD = Ext.lib.Dom,
    A = Ext.lib.Anim,
    Evm = Ext.EventManager,
    E = Ext.lib.Event,
    DOC = document,
    emptyFn = function() {},
    OP = Object.prototype,
    OPString = OP.toString,
    HTMLDoc = '[object HTMLDocument]';
    if (!Ext.elCache || parseInt(Ext.version.replace(/\./g, ''), 10) < 311) {
        alert('Ext Release ' + Ext.version + ' is not supported');
    }
    Ext._documents = {};
    Ext._documents[Ext.id(document, '_doc')] = Ext.elCache;
    var resolveCache = ELD.resolveDocumentCache = function(el, cacheId) {
        var doc = GETDOC(el),
        c = Ext.isDocument(doc) ? Ext.id(doc) : cacheId,
        cache = Ext._documents[c] || null,
        d,
        win;
        if (!cache && doc && (win = doc.parentWindow || doc.defaultView)) {
            if (d = win.frameElement) {
                c = d.id || d.name;
            }
        }
        return cache || Ext._documents[c] || (c ? Ext._documents[c] = {}: null);
    },
    clearCache = ELD.clearDocumentCache = function(cacheId) {
        delete Ext._documents[cacheId];
    };
    El.addMethods || (El.addMethods = function(ov) {
        Ext.apply(El.prototype, ov || {});
    });
    Ext.removeNode = function(n) {
        var dom = n ? n.dom || n: null;
        if (dom && dom.tagName != 'BODY') {
            var el, elc, elCache = resolveCache(dom),
            parent;
            if ((elc = elCache[dom.id]) && (el = elc.el)) {
                if (el.dom) {
                    Ext.enableNestedListenerRemoval ? Evm.purgeElement(el.dom, true) : Evm.removeAll(el.dom);
                }
                delete elCache[dom.id];
                delete el.dom;
                delete el._context;
                el = null;
            } (parent = dom.parentElement || dom.parentNode) && parent.removeChild(dom);
            dom = null;
        }
    };
    var overload = function(pfn, fn) {
        var f = typeof pfn === 'function' ? pfn: function t() {};
        var ov = f._ovl;
        if (!ov) {
            ov = {
                base: f
            };
            ov[f.length || 0] = f;
            f = function t() {
                var o = arguments.callee._ovl;
                var fn = o[arguments.length] || o.base;
                return fn && fn != arguments.callee ? fn.apply(this, arguments) : undefined;
            };
        }
        var fnA = [].concat(fn);
        for (var i = 0, l = fnA.length; i < l; ++i) {
            ov[fnA[i].length] = fnA[i];
        }
        f._ovl = ov;
        var t = null;
        return f;
    };
    Ext.applyIf(Ext, {
        overload: overload(overload, [function(fn) {
            return overload(null, fn);
        },
        function(obj, mname, fn) {
            return obj[mname] = overload(obj[mname], fn);
        }]),
        isArray: function(v) {
            return !! v && OPString.apply(v) == '[object Array]';
        },
        isObject: function(obj) {
            return !! obj && typeof obj == 'object';
        },
        isDocument: function(el, testOrigin) {
            var elm = el ? el.dom || el: null;
            var test = elm && ((OPString.apply(elm) == HTMLDoc) || (elm && elm.nodeType == 9));
            if (test && testOrigin) {
                try {
                    test = !!elm.location;
                } catch(e) {
                    return false;
                }
            }
            return test;
        },
        isWindow: function(el) {
            var elm = el ? el.dom || el: null;
            return elm ? !!elm.navigator || OPString.apply(elm) == "[object Window]": false;
        },
        isIterable: function(v) {
            if (Ext.isArray(v) || v.callee) {
                return true;
            }
            if (/NodeList|HTMLCollection/.test(OPString.call(v))) {
                return true;
            }
            return ((typeof v.nextNode != 'undefined' || v.item) && Ext.isNumber(v.length));
        },
        isElement: function(obj) {
            return obj && Ext.type(obj) == 'element';
        },
        isEvent: function(obj) {
            return OPString.apply(obj) == '[object Event]' || (Ext.isObject(obj) && !Ext.type(o.constructor) && (window.event && obj.clientX && obj.clientX == window.event.clientX));
        },
        isFunction: function(obj) {
            return !! obj && typeof obj == 'function';
        },
        isEventSupported: function(evName, testEl) {
            var TAGNAMES = {
                'select': 'input',
                'change': 'input',
                'submit': 'form',
                'reset': 'form',
                'load': 'img',
                'error': 'img',
                'abort': 'img'
            },
            cache = {},
            onPrefix = /^on/i,
            getKey = function(type, el) {
                var tEl = Ext.getDom(el);
                return (tEl ? (Ext.isElement(tEl) || Ext.isDocument(tEl) ? tEl.nodeName.toLowerCase() : el.self ? '#window': el || '#object') : el || 'div') + ':' + type;
            };
            return function(evName, testEl) {
                evName = (evName || '').replace(onPrefix, '');
                var el, isSupported = false;
                var eventName = 'on' + evName;
                var tag = (testEl ? testEl: TAGNAMES[evName]) || 'div';
                var key = getKey(evName, tag);
                if (key in cache) {
                    return cache[key];
                }
                el = Ext.isString(tag) ? DOC.createElement(tag) : testEl;
                isSupported = ( !! el && (eventName in el));
                isSupported || (isSupported = window.Event && !!(String(evName).toUpperCase() in window.Event));
                if (!isSupported && el) {
                    el.setAttribute && el.setAttribute(eventName, 'return;');
                    isSupported = Ext.isFunction(el[eventName]);
                }
                cache[key] = isSupported;
                el = null;
                return isSupported;
            };
        } ()
    });
    var assertClass = function(el) {
        return El;
        return El[(el.tagName || '-').toUpperCase()] || El;
    };
    var libFlyweight;
    function fly(el, doc) {
        if (!libFlyweight) {
            libFlyweight = new Ext.Element.Flyweight();
        }
        libFlyweight.dom = Ext.getDom(el, null, doc);
        return libFlyweight;
    }
    Ext.apply(Ext, {
        get: El.get = function(el, doc) {
            if (!el) {
                return null;
            }
            var isDoc = Ext.isDocument(el);
            Ext.isDocument(doc) || (doc = DOC);
            var ex, elm, id, cache = resolveCache(doc);
            if (typeof el == "string") {
                elm = Ext.getDom(el, null, doc);
                if (!elm) return null;
                if (cache[el] && cache[el].el) {
                    ex = cache[el].el;
                    ex.dom = elm;
                } else {
                    ex = El.addToCache(new(assertClass(elm))(elm, null, doc));
                }
                return ex;
            } else if (isDoc) {
                if (!Ext.isDocument(el, true)) {
                    return false;
                }
                cache = resolveCache(el);
                if (cache[Ext.id(el)] && cache[el.id].el) {
                    return cache[el.id].el;
                }
                var f = function() {};
                f.prototype = El.prototype;
                var docEl = new f();
                docEl.dom = el;
                docEl.id = Ext.id(el, '_doc');
                docEl._isDoc = true;
                El.addToCache(docEl, null, cache);
                cache[docEl.id].skipGC = true;
                return docEl;
            } else if (el instanceof El) {
                if (el.dom) {
                    el.id = Ext.id(el.dom);
                } else {
                    el.dom = el.id ? Ext.getDom(el.id, true) : null;
                }
                if (el.dom) {
                    cache = resolveCache(el);
                    (cache[el.id] || (cache[el.id] = {
                        data: {},
                        events: {}
                    })).el = el;
                }
                return el;
            } else if (el.tagName || Ext.isWindow(el)) {
                cache = resolveCache(el);
                id = Ext.id(el);
                if (cache[id] && (ex = cache[id].el)) {
                    ex.dom = el;
                } else {
                    ex = El.addToCache(new(assertClass(el))(el, null, doc), null, cache);
                    el.navigator && (cache[id].skipGC = true);
                }
                return ex;
            } else if (el.isComposite) {
                return el;
            } else if (Ext.isArray(el)) {
                return Ext.get(doc, doc).select(el);
            }
            return null;
        },
        getDom: function(el, strict, doc) {
            var D = doc || DOC;
            if (!el || !D) {
                return null;
            }
            if (el.dom) {
                return el.dom;
            } else {
                if (Ext.isString(el)) {
                    var e = D.getElementById(el);
                    if (e && Ext.isIE && strict) {
                        if (el == e.getAttribute('id')) {
                            return e;
                        } else {
                            return null;
                        }
                    }
                    return e;
                } else {
                    return el;
                }
            }
        },
        getBody: function(doc) {
            var D = ELD.getDocument(doc) || DOC;
            return Ext.get(D.body || D.documentElement);
        },
        getDoc: Ext.overload([Ext.getDoc,
        function(doc) {
            return Ext.get(doc, doc);
        }])
    });
    El.data = function(el, key, value) {
        el = El.get(el);
        if (!el) {
            return null;
        }
        var c = resolveCache(el)[el.id].data;
        if (arguments.length == 2) {
            return c[key];
        } else {
            return (c[key] = value);
        }
    };
    El.addToCache = function(el, id, cache) {
        id = id || el.id;
        var C = cache || resolveCache(el);
        C[id] = {
            el: el,
            data: {},
            events: {}
        };
        return el;
    };
    El.NOSIZE = 3;
    var propCache = {},
    camelRe = /(-[a-z])/gi,
    camelFn = function(m, a) {
        return a.charAt(1).toUpperCase();
    },
    opacityRe = /alpha\(opacity=(.*)\)/i,
    trimRe = /^\s+|\s+$/g,
    marginRightRe = /marginRight/,
    propFloat = Ext.isIE ? 'styleFloat': 'cssFloat',
    view = DOC.defaultView,
    VISMODE = 'visibilityMode',
    ELDISPLAY = El.DISPLAY,
    ELVISIBILITY = El.VISIBILITY,
    ELNOSIZE = El.NOSIZE,
    ORIGINALDISPLAY = 'originalDisplay',
    PADDING = "padding",
    MARGIN = "margin",
    BORDER = "border",
    LEFT = "-left",
    RIGHT = "-right",
    TOP = "-top",
    BOTTOM = "-bottom",
    WIDTH = "-width",
    MATH = Math,
    OPACITY = "opacity",
    VISIBILITY = "visibility",
    DISPLAY = "display",
    OFFSETS = "offsets",
    NOSIZE = "nosize",
    HIDDEN = "hidden",
    NONE = "none",
    ISVISIBLE = 'isVisible',
    ISCLIPPED = 'isClipped',
    OVERFLOW = 'overflow',
    OVERFLOWX = 'overflow-x',
    OVERFLOWY = 'overflow-y',
    ORIGINALCLIP = 'originalClip',
    XMASKED = "x-masked",
    XMASKEDRELATIVE = "x-masked-relative",
    borders = {
        l: BORDER + LEFT + WIDTH,
        r: BORDER + RIGHT + WIDTH,
        t: BORDER + TOP + WIDTH,
        b: BORDER + BOTTOM + WIDTH
    },
    paddings = {
        l: PADDING + LEFT,
        r: PADDING + RIGHT,
        t: PADDING + TOP,
        b: PADDING + BOTTOM
    },
    margins = {
        l: MARGIN + LEFT,
        r: MARGIN + RIGHT,
        t: MARGIN + TOP,
        b: MARGIN + BOTTOM
    },
    data = El.data,
    GETDOM = Ext.getDom,
    GET = Ext.get,
    DH = Ext.DomHelper,
    propRe = /^(?:scope|delay|buffer|single|stopEvent|preventDefault|stopPropagation|normalized|args|delegate)$/,
    CSS = Ext.util.CSS,
    getDisplay = function(dom) {
        var d = data(dom, ORIGINALDISPLAY);
        if (d === undefined) {
            data(dom, ORIGINALDISPLAY, d = '');
        }
        return d;
    },
    getVisMode = function(dom) {
        var m = data(dom, VISMODE);
        if (m === undefined) {
            data(dom, VISMODE, m = 1);
        };
        return m;
    };
    function chkCache(prop) {
        return propCache[prop] || (propCache[prop] = prop == 'float' ? propFloat: prop.replace(camelRe, camelFn));
    };
    El.addMethods({
        getDocument: function() {
            return this._context || (this._context = GETDOC(this));
        },
        remove: function(cleanse, deep) {
            var dom = this.dom;
            this.isMasked() && this.unmask();
            if (dom) {
                Ext.removeNode(dom);
                delete this._context;
                delete this.dom;
            }
        },
        appendChild: function(el, doc) {
            return GET(el, doc || this.getDocument()).appendTo(this);
        },
        appendTo: function(el, doc) {
            GETDOM(el, false, doc || this.getDocument()).appendChild(this.dom);
            return this;
        },
        insertBefore: function(el, doc) { (el = GETDOM(el, false, doc || this.getDocument())).parentNode.insertBefore(this.dom, el);
            return this;
        },
        insertAfter: function(el, doc) { (el = GETDOM(el, false, doc || this.getDocument())).parentNode.insertBefore(this.dom, el.nextSibling);
            return this;
        },
        insertFirst: function(el, returnDom) {
            el = el || {};
            if (el.nodeType || el.dom || typeof el == 'string') {
                el = GETDOM(el);
                this.dom.insertBefore(el, this.dom.firstChild);
                return ! returnDom ? GET(el) : el;
            } else {
                return this.createChild(el, this.dom.firstChild, returnDom);
            }
        },
        replace: function(el, doc) {
            el = GET(el, doc || this.getDocument());
            this.insertBefore(el);
            el.remove();
            return this;
        },
        replaceWith: function(el, doc) {
            var me = this;
            if (el.nodeType || el.dom || typeof el == 'string') {
                el = GETDOM(el, false, doc || me.getDocument());
                me.dom.parentNode.insertBefore(el, me.dom);
            } else {
                el = DH.insertBefore(me.dom, el);
            }
            var C = resolveCache(me);
            Ext.removeNode(me.dom);
            me.id = Ext.id(me.dom = el);
            El.addToCache(me.isFlyweight ? new(assertClass(me.dom))(me.dom, null, C) : me);
            return me;
        },
        insertHtml: function(where, html, returnEl) {
            var el = DH.insertHtml(where, this.dom, html);
            return returnEl ? Ext.get(el, GETDOC(el)) : el;
        },
        setVisibilityMode: function(visMode) {
            data(this.dom, VISMODE, visMode);
            return this;
        },
        isVisible: function() {
            return this.visible || Ext.value(data(this.dom, ISVISIBLE), !this.isStyle(VISIBILITY, HIDDEN) && !this.isStyle(DISPLAY, NONE));
        },
        setVisible: function(visible, animate) {
            var me = this,
            dom = me.dom,
            isDisplay, isVisibility, isOffsets, isNosize;
            if (typeof animate == 'string') {
                isDisplay = animate == DISPLAY;
                isVisibility = animate == VISIBILITY;
                isOffsets = animate == OFFSETS;
                isNosize = animate == NOSIZE;
                animate = false;
            } else {
                var visMode = getVisMode(dom);
                isDisplay = visMode == ELDISPLAY;
                isVisibility = visMode == ELVISIBILITY;
                isNosize = visMode == ELNOSIZE;
            }
            if (!animate || !me.anim) {
                if (isNosize) {
                    if (!visible) {
                        me.hideModeStyles = {
                            width: me.getWidth(),
                            height: me.getHeight()
                        };
                        me.applyStyles({
                            width: '0px',
                            height: '0px'
                        });
                    } else {
                        me.applyStyles(me.hideModeStyles || {
                            width: 'auto',
                            height: 'auto'
                        });
                    }
                } else if (isDisplay) {
                    me.setDisplayed(visible);
                } else if (isOffsets) {
                    if (!visible) {
                        me.hideModeStyles = {
                            position: me.getStyle('position'),
                            top: me.getStyle('top'),
                            left: me.getStyle('left')
                        };
                        me.applyStyles({
                            position: 'absolute',
                            top: '-10000px',
                            left: '-10000px'
                        });
                    } else {
                        me.applyStyles(me.hideModeStyles || {
                            position: '',
                            top: '',
                            left: ''
                        });
                    }
                } else {
                    me.fixDisplay();
                    dom.style.visibility = visible ? "visible": HIDDEN;
                }
            } else {
                if (visible) {
                    me.setOpacity(.01);
                    me.setVisible(true);
                }
                me.anim({
                    opacity: {
                        to: (visible ? 1 : 0)
                    }
                },
                me.preanim(arguments, 1), null, .35, 'easeIn',
                function() {
                    if (!visible) {
                        dom.style[isDisplay ? DISPLAY: VISIBILITY] = (isDisplay) ? NONE: HIDDEN;
                        Ext.fly(dom).setOpacity(1);
                    }
                });
            }
            data(dom, ISVISIBLE, visible);
            return me;
        },
        setDisplayed: function(value) {
            if (typeof value == "boolean") {
                data(this.dom, ISVISIBLE, value);
                value = value ? getDisplay(this.dom) : NONE;
            }
            this.setStyle(DISPLAY, value);
            return this;
        },
        fixDisplay: function() {
            var me = this;
            if (me.isStyle(DISPLAY, NONE)) {
                me.setStyle(VISIBILITY, HIDDEN);
                me.setStyle(DISPLAY, getDisplay(me.dom));
                if (me.isStyle(DISPLAY, NONE)) {
                    me.setStyle(DISPLAY, "block");
                }
            }
        },
        enableDisplayMode: function(display) {
            this.setVisibilityMode(El.DISPLAY);
            if (!Ext.isEmpty(display)) {
                data(this.dom, ORIGINALDISPLAY, display);
            }
            return this;
        },
        scrollIntoView: function(container, hscroll) {
            var d = this.getDocument();
            var c = Ext.getDom(container, null, d) || Ext.getBody(d).dom;
            var el = this.dom;
            var o = this.getOffsetsTo(c),
            s = this.getScroll(),
            l = o[0] + s.left,
            t = o[1] + s.top,
            b = t + el.offsetHeight,
            r = l + el.offsetWidth;
            var ch = c.clientHeight;
            var ct = parseInt(c.scrollTop, 10);
            var cl = parseInt(c.scrollLeft, 10);
            var cb = ct + ch;
            var cr = cl + c.clientWidth;
            if (el.offsetHeight > ch || t < ct) {
                c.scrollTop = t;
            } else if (b > cb) {
                c.scrollTop = b - ch;
            }
            c.scrollTop = c.scrollTop;
            if (hscroll !== false) {
                if (el.offsetWidth > c.clientWidth || l < cl) {
                    c.scrollLeft = l;
                } else if (r > cr) {
                    c.scrollLeft = r - c.clientWidth;
                }
                c.scrollLeft = c.scrollLeft;
            }
            return this;
        },
        contains: function(el) {
            try {
                return ! el ? false: ELD.isAncestor(this.dom, el.dom ? el.dom: el);
            } catch(e) {
                return false;
            }
        },
        getScroll: function() {
            var d = this.dom,
            doc = this.getDocument(),
            body = doc.body,
            docElement = doc.documentElement,
            l,
            t,
            ret;
            if (Ext.isDocument(d) || d == body) {
                if (Ext.isIE && ELD.docIsStrict(doc)) {
                    l = docElement.scrollLeft;
                    t = docElement.scrollTop;
                } else {
                    l = window.pageXOffset;
                    t = window.pageYOffset;
                }
                ret = {
                    left: l || (body ? body.scrollLeft: 0),
                    top: t || (body ? body.scrollTop: 0)
                };
            } else {
                ret = {
                    left: d.scrollLeft,
                    top: d.scrollTop
                };
            }
            return ret;
        },
        getStyle: function() {
            var getStyle = view && view.getComputedStyle ?
            function GS(prop) {
                var el = !this._isDoc ? this.dom: null,
                v,
                cs,
                out,
                display,
                wk = Ext.isWebKit,
                display;
                if (!el || !el.style) return null;
                prop = chkCache(prop);
                out = (v = el.style[prop]) ? v: (cs = view.getComputedStyle(el, '')) ? cs[prop] : null;
                if (wk && marginRightRe.test(prop) && out != '0px') {
                    display = this.getStyle('display');
                    el.style.display = 'inline-block';
                    out = view.getComputedStyle(el, '');
                    el.style.display = display;
                }
                if (wk && out == 'rgba(0, 0, 0, 0)') {
                    out = 'transparent';
                }
                return out;
            }: function GS(prop) {
                var el = !this._isDoc ? this.dom: null,
                m,
                cs;
                if (!el || !el.style) return null;
                if (prop == OPACITY) {
                    if (el.style.filter.match) {
                        if (m = el.style.filter.match(opacityRe)) {
                            var fv = parseFloat(m[1]);
                            if (!isNaN(fv)) {
                                return fv ? fv / 100 : 0;
                            }
                        }
                    }
                    return 1;
                }
                prop = chkCache(prop);
                return el.style[prop] || ((cs = el.currentStyle) ? cs[prop] : null);
            };
            var GS = null;
            return getStyle;
        } (),
        setStyle: function(prop, value) {
            if (this._isDoc || Ext.isDocument(this.dom)) return this;
            var tmp, style, camel;
            if (!Ext.isObject(prop)) {
                tmp = {};
                tmp[prop] = value;
                prop = tmp;
            }
            for (style in prop) {
                value = prop[style];
                style == OPACITY ? this.setOpacity(value) : this.dom.style[chkCache(style)] = value;
            }
            return this;
        },
        center: function(centerIn) {
            return this.alignTo(centerIn || this.getDocument(), 'c-c');
        },
        mask: function(msg, msgCls) {
            var me = this,
            dom = me.dom,
            dh = Ext.DomHelper,
            EXTELMASKMSG = "ext-el-mask-msg",
            el, mask;
            if (me.getStyle("position") == "static") {
                me.addClass(XMASKEDRELATIVE);
            }
            if ((el = data(dom, 'maskMsg'))) {
                el.remove();
            }
            if ((el = data(dom, 'mask'))) {
                el.remove();
            }
            mask = dh.append(dom, {
                cls: "ext-el-mask"
            },
            true);
            data(dom, 'mask', mask);
            me.addClass(XMASKED);
            mask.setDisplayed(true);
            if (typeof msg == 'string') {
                var mm = dh.append(dom, {
                    cls: EXTELMASKMSG,
                    cn: {
                        tag: 'div'
                    }
                },
                true);
                data(dom, 'maskMsg', mm);
                mm.dom.className = msgCls ? EXTELMASKMSG + " " + msgCls: EXTELMASKMSG;
                mm.dom.firstChild.innerHTML = msg;
                mm.setDisplayed(true);
                mm.center(me);
            }
            if (Ext.isIE && !(Ext.isIE7 && Ext.isStrict) && me.getStyle('height') == 'auto') {
                mask.setSize(undefined, me.getHeight());
            }
            return mask;
        },
        unmask: function() {
            var me = this,
            dom = me.dom,
            mask = data(dom, 'mask'),
            maskMsg = data(dom, 'maskMsg');
            if (mask) {
                if (maskMsg) {
                    maskMsg.remove();
                    data(dom, 'maskMsg', undefined);
                }
                mask.remove();
                data(dom, 'mask', undefined);
            }
            me.removeClass([XMASKED, XMASKEDRELATIVE]);
        },
        isMasked: function() {
            var m = data(this.dom, 'mask');
            return m && m.isVisible();
        },
        getCenterXY: function() {
            return this.getAlignToXY(this.getDocument(), 'c-c');
        },
        getAnchorXY: function(anchor, local, s) {
            anchor = (anchor || "tl").toLowerCase();
            s = s || {};
            var me = this,
            doc = this.getDocument(),
            vp = me.dom == doc.body || me.dom == doc,
            w = s.width || vp ? ELD.getViewWidth(false, doc) : me.getWidth(),
            h = s.height || vp ? ELD.getViewHeight(false, doc) : me.getHeight(),
            xy,
            r = Math.round,
            o = me.getXY(),
            scroll = me.getScroll(),
            extraX = vp ? scroll.left: !local ? o[0] : 0,
            extraY = vp ? scroll.top: !local ? o[1] : 0,
            hash = {
                c: [r(w * .5), r(h * .5)],
                t: [r(w * .5), 0],
                l: [0, r(h * .5)],
                r: [w, r(h * .5)],
                b: [r(w * .5), h],
                tl: [0, 0],
                bl: [0, h],
                br: [w, h],
                tr: [w, 0]
            };
            xy = hash[anchor];
            return [xy[0] + extraX, xy[1] + extraY];
        },
        anchorTo: function(el, alignment, offsets, animate, monitorScroll, callback) {
            var me = this,
            dom = me.dom;
            function action() {
                fly(dom).alignTo(el, alignment, offsets, animate);
                Ext.callback(callback, fly(dom));
            };
            Ext.EventManager.onWindowResize(action, me);
            if (!Ext.isEmpty(monitorScroll)) {
                Ext.EventManager.on(window, 'scroll', action, me, {
                    buffer: !isNaN(monitorScroll) ? monitorScroll: 50
                });
            }
            action.call(me);
            return me;
        },
        getScroll: function() {
            var d = this.dom,
            doc = this.getDocument(),
            body = doc.body,
            docElement = doc.documentElement,
            l,
            t,
            ret;
            if (d == doc || d == body) {
                if (Ext.isIE && ELD.docIsStrict(doc)) {
                    l = docElement.scrollLeft;
                    t = docElement.scrollTop;
                } else {
                    l = window.pageXOffset;
                    t = window.pageYOffset;
                }
                ret = {
                    left: l || (body ? body.scrollLeft: 0),
                    top: t || (body ? body.scrollTop: 0)
                };
            } else {
                ret = {
                    left: d.scrollLeft,
                    top: d.scrollTop
                };
            }
            return ret;
        },
        getAlignToXY: function(el, p, o) {
            var doc;
            el = Ext.get(el, doc = this.getDocument());
            if (!el || !el.dom) {
                throw "Element.getAlignToXY with an element that doesn't exist";
            }
            o = o || [0, 0];
            p = (p == "?" ? "tl-bl?": (!/-/.test(p) && p != "" ? "tl-" + p: p || "tl-bl")).toLowerCase();
            var me = this,
            d = me.dom,
            a1, a2, x, y, w, h, r, dw = ELD.getViewWidth(false, doc) - 10,
            dh = ELD.getViewHeight(false, doc) - 10,
            p1y,
            p1x,
            p2y,
            p2x,
            swapY,
            swapX,
            docElement = doc.documentElement,
            docBody = doc.body,
            scrollX = (docElement.scrollLeft || docBody.scrollLeft || 0) + 5,
            scrollY = (docElement.scrollTop || docBody.scrollTop || 0) + 5,
            c = false,
            p1 = "",
            p2 = "",
            m = p.match(/^([a-z]+)-([a-z]+)(\?)?$/);
            if (!m) {
                throw "Element.getAlignToXY with an invalid alignment " + p;
            }
            p1 = m[1];
            p2 = m[2];
            c = !!m[3];
            a1 = me.getAnchorXY(p1, true);
            a2 = el.getAnchorXY(p2, false);
            x = a2[0] - a1[0] + o[0];
            y = a2[1] - a1[1] + o[1];
            if (c) {
                w = me.getWidth();
                h = me.getHeight();
                r = el.getRegion();
                p1y = p1.charAt(0);
                p1x = p1.charAt(p1.length - 1);
                p2y = p2.charAt(0);
                p2x = p2.charAt(p2.length - 1);
                swapY = ((p1y == "t" && p2y == "b") || (p1y == "b" && p2y == "t"));
                swapX = ((p1x == "r" && p2x == "l") || (p1x == "l" && p2x == "r"));
                if (x + w > dw + scrollX) {
                    x = swapX ? r.left - w: dw + scrollX - w;
                }
                if (x < scrollX) {
                    x = swapX ? r.right: scrollX;
                }
                if (y + h > dh + scrollY) {
                    y = swapY ? r.top - h: dh + scrollY - h;
                }
                if (y < scrollY) {
                    y = swapY ? r.bottom: scrollY;
                }
            }
            return [x, y];
        },
        adjustForConstraints: function(xy, parent, offsets) {
            return this.getConstrainToXY(parent || this.getDocument(), false, offsets, xy) || xy;
        },
        getConstrainToXY: function(el, local, offsets, proposedXY) {
            var os = {
                top: 0,
                left: 0,
                bottom: 0,
                right: 0
            };
            return function(el, local, offsets, proposedXY) {
                var doc = this.getDocument();
                el = Ext.get(el, doc);
                offsets = offsets ? Ext.applyIf(offsets, os) : os;
                var vw, vh, vx = 0,
                vy = 0;
                if (el.dom == doc.body || el.dom == doc) {
                    vw = ELD.getViewWidth(false, doc);
                    vh = ELD.getViewHeight(false, doc);
                } else {
                    vw = el.dom.clientWidth;
                    vh = el.dom.clientHeight;
                    if (!local) {
                        var vxy = el.getXY();
                        vx = vxy[0];
                        vy = vxy[1];
                    }
                }
                var s = el.getScroll();
                vx += offsets.left + s.left;
                vy += offsets.top + s.top;
                vw -= offsets.right;
                vh -= offsets.bottom;
                var vr = vx + vw;
                var vb = vy + vh;
                var xy = proposedXY || (!local ? this.getXY() : [this.getLeft(true), this.getTop(true)]);
                var x = xy[0],
                y = xy[1];
                var w = this.dom.offsetWidth,
                h = this.dom.offsetHeight;
                var moved = false;
                if ((x + w) > vr) {
                    x = vr - w;
                    moved = true;
                }
                if ((y + h) > vb) {
                    y = vb - h;
                    moved = true;
                }
                if (x < vx) {
                    x = vx;
                    moved = true;
                }
                if (y < vy) {
                    y = vy;
                    moved = true;
                }
                return moved ? [x, y] : false;
            };
        } (),
        getCenterXY: function() {
            return this.getAlignToXY(Ext.getBody(this.getDocument()), 'c-c');
        },
        center: function(centerIn) {
            return this.alignTo(centerIn || Ext.getBody(this.getDocument()), 'c-c');
        },
        findParent: function(simpleSelector, maxDepth, returnEl) {
            var p = this.dom,
            D = this.getDocument(),
            b = D.body,
            depth = 0,
            stopEl;
            if (Ext.isGecko && OPString.call(p) == '[object XULElement]') {
                return null;
            }
            maxDepth = maxDepth || 50;
            if (isNaN(maxDepth)) {
                stopEl = Ext.getDom(maxDepth, null, D);
                maxDepth = Number.MAX_VALUE;
            }
            while (p && p.nodeType == 1 && depth < maxDepth && p != b && p != stopEl) {
                if (Ext.DomQuery.is(p, simpleSelector)) {
                    return returnEl ? Ext.get(p, D) : p;
                }
                depth++;
                p = p.parentNode;
            }
            return null;
        },
        clip: function() {
            var me = this,
            dom = me.dom;
            if (!data(dom, ISCLIPPED)) {
                data(dom, ISCLIPPED, true);
                data(dom, ORIGINALCLIP, {
                    o: me.getStyle(OVERFLOW),
                    x: me.getStyle(OVERFLOWX),
                    y: me.getStyle(OVERFLOWY)
                });
                me.setStyle(OVERFLOW, HIDDEN);
                me.setStyle(OVERFLOWX, HIDDEN);
                me.setStyle(OVERFLOWY, HIDDEN);
            }
            return me;
        },
        unclip: function() {
            var me = this,
            dom = me.dom;
            if (data(dom, ISCLIPPED)) {
                data(dom, ISCLIPPED, false);
                var o = data(dom, ORIGINALCLIP);
                if (o.o) {
                    me.setStyle(OVERFLOW, o.o);
                }
                if (o.x) {
                    me.setStyle(OVERFLOWX, o.x);
                }
                if (o.y) {
                    me.setStyle(OVERFLOWY, o.y);
                }
            }
            return me;
        },
        getViewSize: function() {
            var doc = this.getDocument(),
            d = this.dom,
            isDoc = (d == doc || d == doc.body);
            if (isDoc) {
                var extdom = Ext.lib.Dom;
                return {
                    width: extdom.getViewWidth(),
                    height: extdom.getViewHeight()
                };
            } else {
                return {
                    width: d.clientWidth,
                    height: d.clientHeight
                };
            }
        },
        getStyleSize: function() {
            var me = this,
            w, h, doc = this.getDocument(),
            d = this.dom,
            isDoc = (d == doc || d == doc.body),
            s = d.style;
            if (isDoc) {
                var extdom = Ext.lib.Dom;
                return {
                    width: extdom.getViewWidth(),
                    height: extdom.getViewHeight()
                };
            }
            if (s.width && s.width != 'auto') {
                w = parseFloat(s.width);
                if (me.isBorderBox()) {
                    w -= me.getFrameWidth('lr');
                }
            }
            if (s.height && s.height != 'auto') {
                h = parseFloat(s.height);
                if (me.isBorderBox()) {
                    h -= me.getFrameWidth('tb');
                }
            }
            return {
                width: w || me.getWidth(true),
                height: h || me.getHeight(true)
            };
        }
    });
    Ext.isDefined(El.collectorThreadId) && clearInterval(El.collectorThreadId);
    function garbageCollect() {
        if (!Ext.enableGarbageCollector) {
            clearInterval(El.collectorThreadId);
        } else {
            var eid, el, d, o, EC = Ext.elCache;
            for (eid in EC) {
                o = EC[eid];
                if (o.skipGC) {
                    continue;
                }
                el = o.el;
                d = el.dom;
                if (!d || !d.parentNode || (!d.offsetParent && !DOC.getElementById(eid))) {
                    if (Ext.enableListenerCollection) {
                        Ext.EventManager.removeAll(d);
                    }
                    delete EC[eid];
                }
            }
            if (Ext.isIE) {
                var t = {};
                for (eid in EC) {
                    t[eid] = EC[eid];
                }
                Ext.elCache = Ext._documents[Ext.id(document)] = t;
                t = null;
            }
        }
    }
    if (Ext.enableGarbageCollector) {
        El.collectorThreadId = setInterval(garbageCollect, 30000);
    }
    Ext.apply(ELD, {
        getDocument: function(el, accessTest) {
            var dom = null;
            try {
                dom = Ext.getDom(el, null, null);
            } catch(ex) {}
            var isDoc = Ext.isDocument(dom);
            if (isDoc) {
                if (accessTest) {
                    return Ext.isDocument(dom, accessTest) ? dom: null;
                }
                return dom;
            }
            return dom ? dom.ownerDocument || dom.document: null;
        },
        docIsStrict: function(doc) {
            return (Ext.isDocument(doc) ? doc: this.getDocument(doc)).compatMode == "CSS1Compat";
        },
        getViewWidth: Ext.overload([ELD.getViewWidth ||
        function(full) {},
        function() {
            return this.getViewWidth(false);
        },
        function(full, doc) {
            return full ? this.getDocumentWidth(doc) : this.getViewportWidth(doc);
        }]),
        getViewHeight: Ext.overload([ELD.getViewHeight ||
        function(full) {},
        function() {
            return this.getViewHeight(false);
        },
        function(full, doc) {
            return full ? this.getDocumentHeight(doc) : this.getViewportHeight(doc);
        }]),
        getDocumentHeight: Ext.overload([ELD.getDocumentHeight || emptyFn,
        function(doc) {
            if (doc = this.getDocument(doc)) {
                return Math.max(!this.docIsStrict(doc) ? doc.body.scrollHeight: doc.documentElement.scrollHeight, this.getViewportHeight(doc));
            }
            return undefined;
        }]),
        getDocumentWidth: Ext.overload([ELD.getDocumentWidth || emptyFn,
        function(doc) {
            if (doc = this.getDocument(doc)) {
                return Math.max(!this.docIsStrict(doc) ? doc.body.scrollWidth: doc.documentElement.scrollWidth, this.getViewportWidth(doc));
            }
            return undefined;
        }]),
        getViewportHeight: Ext.overload([ELD.getViewportHeight || emptyFn,
        function(doc) {
            if (doc = this.getDocument(doc)) {
                if (Ext.isIE) {
                    return this.docIsStrict(doc) ? doc.documentElement.clientHeight: doc.body.clientHeight;
                } else {
                    return doc.defaultView.innerHeight;
                }
            }
            return undefined;
        }]),
        getViewportWidth: Ext.overload([ELD.getViewportWidth || emptyFn,
        function(doc) {
            if (doc = this.getDocument(doc)) {
                return ! this.docIsStrict(doc) && !Ext.isOpera ? doc.body.clientWidth: Ext.isIE ? doc.documentElement.clientWidth: doc.defaultView.innerWidth;
            }
            return undefined;
        }]),
        getXY: Ext.overload([ELD.getXY || emptyFn,
        function(el, doc) {
            el = Ext.getDom(el, null, doc);
            var D = this.getDocument(el),
            bd = D ? (D.body || D.documentElement) : null;
            if (!el || !bd || el == bd) {
                return [0, 0];
            }
            return this.getXY(el);
        }])
    });
    var GETDOC = ELD.getDocument,
    flies = El._flyweights;
    Ext.fly = El.fly = function(el, named, doc) {
        var ret = null;
        named = named || '_global';
        if (el = Ext.getDom(el, null, doc)) { (ret = flies[named] = (flies[named] || new El.Flyweight())).dom = el;
            Ext.isDocument(el) && (ret._isDoc = true);
        }
        return ret;
    };
    var flyFn = function() {};
    flyFn.prototype = El.prototype;
    El.Flyweight = function(dom) {
        this.dom = dom;
    };
    El.Flyweight.prototype = new flyFn();
    El.Flyweight.prototype.isFlyweight = true;
    function addListener(el, ename, fn, task, wrap, scope) {
        el = Ext.getDom(el);
        if (!el) {
            return;
        }
        var id = Ext.id(el),
        es = (resolveCache(el)[id] || {}).events || {},
        wfn;
        wfn = E.on(el, ename, wrap);
        es[ename] = es[ename] || [];
        es[ename].push([fn, wrap, scope, wfn, task]);
        if (el.addEventListener && ename == "mousewheel") {
            var args = ["DOMMouseScroll", wrap, false];
            el.addEventListener.apply(el, args);
            Ext.EventManager.addListener(window, 'beforeunload',
            function() {
                el.removeEventListener.apply(el, args);
            });
        }
        if (ename == "mousedown" && Ext.isDocument(el)) {
            Ext.EventManager.stoppedMouseDownEvent.addListener(wrap);
        }
    };
    function createTargeted(h, o) {
        return function() {
            var args = Ext.toArray(arguments);
            if (o.target == Ext.EventObject.setEvent(args[0]).target) {
                h.apply(this, args);
            }
        };
    };
    function createBuffered(h, o, task) {
        return function(e) {
            task.delay(o.buffer, h, null, [new Ext.EventObjectImpl(e)]);
        };
    };
    function createSingle(h, el, ename, fn, scope) {
        return function(e) {
            Ext.EventManager.removeListener(el, ename, fn, scope);
            h(e);
        };
    };
    function createDelayed(h, o, fn) {
        return function(e) {
            var task = new Ext.util.DelayedTask(h);
            (fn.tasks || (fn.tasks = [])).push(task);
            task.delay(o.delay || 10, h, null, [new Ext.EventObjectImpl(e)]);
        };
    };
    function listen(element, ename, opt, fn, scope) {
        var o = !Ext.isObject(opt) ? {}: opt,
        el = Ext.getDom(element),
        task;
        fn = fn || o.fn;
        scope = scope || o.scope;
        if (!el) {
            throw "Error listening for \"" + ename + '\". Element "' + element + '" doesn\'t exist.';
        }
        function h(e) {
            if (!window.Ext) {
                return;
            }
            e = Ext.EventObject.setEvent(e);
            var t;
            if (o.delegate) {
                if (! (t = e.getTarget(o.delegate, el))) {
                    return;
                }
            } else {
                t = e.target;
            }
            if (o.stopEvent) {
                e.stopEvent();
            }
            if (o.preventDefault) {
                e.preventDefault();
            }
            if (o.stopPropagation) {
                e.stopPropagation();
            }
            if (o.normalized) {
                e = e.browserEvent;
            }
            fn.call(scope || el, e, t, o);
        };
        if (o.target) {
            h = createTargeted(h, o);
        }
        if (o.delay) {
            h = createDelayed(h, o, fn);
        }
        if (o.single) {
            h = createSingle(h, el, ename, fn, scope);
        }
        if (o.buffer) {
            task = new Ext.util.DelayedTask(h);
            h = createBuffered(h, o, task);
        }
        addListener(el, ename, fn, task, h, scope);
        return h;
    };
    Ext.apply(Evm, {
        addListener: Evm.on = function(element, eventName, fn, scope, options) {
            if (Ext.isObject(eventName)) {
                var o = eventName,
                e, val;
                for (e in o) {
                    val = o[e];
                    if (!propRe.test(e)) {
                        if (Ext.isFunction(val)) {
                            listen(element, e, o, val, o.scope);
                        } else {
                            listen(element, e, val);
                        }
                    }
                }
            } else {
                listen(element, eventName, options, fn, scope);
            }
        },
        removeListener: Evm.un = function(element, eventName, fn, scope) {
            var el = Ext.getDom(element);
            el && Ext.get(el);
            var elCache = el ? resolveCache(el) : {},
            f = el && ((elCache[el.id] || {
                events: {}
            }).events)[eventName] || [],
            wrap,
            i,
            l,
            k,
            len,
            fnc;
            for (i = 0, len = f.length; i < len; i++) {
                if (Ext.isArray(fnc = f[i]) && fnc[0] == fn && (!scope || fnc[2] == scope)) {
                    fnc[4] && fnc[4].cancel();
                    k = fn.tasks && fn.tasks.length;
                    if (k) {
                        while (k--) {
                            fn.tasks[k].cancel();
                        }
                        delete fn.tasks;
                    }
                    wrap = fnc[1];
                    E.un(el, eventName, E.extAdapter ? fnc[3] : wrap);
                    if (wrap && eventName == "mousewheel" && el.addEventListener) {
                        el.removeEventListener("DOMMouseScroll", wrap, false);
                    }
                    if (wrap && eventName == "mousedown" && Ext.isDocument(el)) {
                        Ext.EventManager.stoppedMouseDownEvent.removeListener(wrap);
                    }
                    f.splice(i, 1);
                    if (f.length === 0) {
                        delete elCache[el.id].events[eventName];
                    }
                    for (k in elCache[el.id].events) {
                        return false;
                    }
                    elCache[el.id].events = {};
                    return false;
                }
            }
        },
        removeAll: function(el) {
            if (! (el = Ext.getDom(el))) {
                return;
            }
            var id = el.id,
            elCache = resolveCache(el) || {},
            es = elCache[id] || {},
            ev = es.events || {},
            f,
            i,
            len,
            ename,
            fn,
            k,
            wrap;
            for (ename in ev) {
                if (ev.hasOwnProperty(ename)) {
                    f = ev[ename];
                    for (i = 0, len = f.length; i < len; i++) {
                        fn = f[i];
                        fn[4] && fn[4].cancel();
                        if (fn[0].tasks && (k = fn[0].tasks.length)) {
                            while (k--) {
                                fn[0].tasks[k].cancel();
                            }
                            delete fn.tasks;
                        }
                        wrap = fn[1];
                        E.un(el, ename, E.extAdapter ? fn[3] : wrap);
                        if (wrap && el.addEventListener && ename == "mousewheel") {
                            el.removeEventListener("DOMMouseScroll", wrap, false);
                        }
                        if (wrap && Ext.isDocument(el) && ename == "mousedown") {
                            Ext.EventManager.stoppedMouseDownEvent.removeListener(wrap);
                        }
                    }
                }
            }
            elCache[id] && (elCache[id].events = {});
        },
        getListeners: function(el, eventName) {
            el = Ext.getDom(el);
            if (!el) {
                return;
            }
            var id = (Ext.get(el) || {}).id,
            elCache = resolveCache(el),
            es = (elCache[id] || {}).events || {};
            return es[eventName] || null;
        },
        purgeElement: function(el, recurse, eventName) {
            el = Ext.getDom(el);
            var id = el.id,
            elCache = resolveCache(el),
            es = (elCache[id] || {}).events || {},
            i,
            f,
            len;
            if (eventName) {
                if (es.hasOwnProperty(eventName)) {
                    f = es[eventName];
                    for (i = 0, len = f.length; i < len; i++) {
                        Evm.removeListener(el, eventName, f[i][0]);
                    }
                }
            } else {
                Evm.removeAll(el);
            }
            if (recurse && el && el.childNodes) {
                for (i = 0, len = el.childNodes.length; i < len; i++) {
                    Evm.purgeElement(el.childNodes[i], recurse, eventName);
                }
            }
        }
    });
    E.getListeners = function(el, eventName) {
        return Ext.EventManager.getListeners(el, eventName);
    };
    Ext.provide && Ext.provide('multidom');
})();
(function() {
    var El = Ext.Element,
    ElFrame, ELD = Ext.lib.Dom,
    EMPTYFN = function() {},
    OP = Object.prototype,
    addListener = function() {
        var handler;
        if (window.addEventListener) {
            handler = function F(el, eventName, fn, capture) {
                el.addEventListener(eventName, fn, !!capture);
            };
        } else if (window.attachEvent) {
            handler = function F(el, eventName, fn, capture) {
                el.attachEvent("on" + eventName, fn);
            };
        } else {
            handler = function F() {};
        }
        var F = null;
        return handler;
    } (),
    removeListener = function() {
        var handler;
        if (window.removeEventListener) {
            handler = function F(el, eventName, fn, capture) {
                el.removeEventListener(eventName, fn, (capture));
            };
        } else if (window.detachEvent) {
            handler = function F(el, eventName, fn) {
                el.detachEvent("on" + eventName, fn);
            };
        } else {
            handler = function F() {};
        }
        var F = null;
        return handler;
    } ();
    if (typeof ELD.getDocument != 'function') {
        alert("MIF 2.1.1 requires multidom support");
    }
    if (!Ext.elCache || parseInt(Ext.version.replace(/\./g, ''), 10) < 311) {
        alert('Ext Release ' + Ext.version + ' is not supported');
    }
    Ext.ns('Ext.ux.ManagedIFrame', 'Ext.ux.plugin');
    var MIM, MIF = Ext.ux.ManagedIFrame,
    MIFC;
    var frameEvents = ['documentloaded', 'domready', 'focus', 'blur', 'resize', 'scroll', 'unload', 'scroll', 'exception', 'message', 'reset'];
    var reSynthEvents = new RegExp('^(' + frameEvents.join('|') + ')', 'i');
    Ext.ux.ManagedIFrame.Element = Ext.extend(Ext.Element, {
        constructor: function(element, forceNew, doc) {
            var d = doc || document,
            elCache = ELD.resolveDocumentCache(d),
            dom = Ext.getDom(element, false, d);
            if (!dom || !(/^(iframe|frame)/i).test(dom.tagName)) {
                return null;
            }
            var id = Ext.id(dom);
            this.dom = dom;
            this.id = id;
            (elCache[id] || (elCache[id] = {
                el: this,
                events: {},
                data: {}
            })).el = this;
            this.dom.name || (this.dom.name = this.id);
            if (Ext.isIE) {
                document.frames && (document.frames[this.dom.name] || (document.frames[this.dom.name] = this.dom));
            }
            this.dom.ownerCt = this;
            MIM.register(this);
            if (!this._observable) { (this._observable = new Ext.util.Observable()).addEvents('documentloaded', 'domready', 'exception', 'resize', 'message', 'blur', 'focus', 'unload', 'scroll', 'reset');
                this._observable.addEvents('_docready', '_docload');
            }
            var H = Ext.isIE ? 'onreadystatechange': 'onload';
            this.dom[H] = this.loadHandler.createDelegate(this);
            this.dom['onerror'] = this.loadHandler.createDelegate(this);
        },
        destructor: function() {
            this.dom[Ext.isIE ? 'onreadystatechange': 'onload'] = this.dom['onerror'] = EMPTYFN;
            MIM.deRegister(this);
            this.removeAllListeners();
            Ext.destroy(this.frameShim, this.DDM);
            this.hideMask(true);
            delete this.loadMask;
            this.reset();
            this.manager = null;
            this.dom.ownerCt = null;
        },
        cleanse: function(forceReclean, deep) {
            if (this.isCleansed && forceReclean !== true) {
                return this;
            }
            var d = this.dom,
            n = d.firstChild,
            nx;
            while (d && n) {
                nx = n.nextSibling;
                deep && Ext.fly(n).cleanse(forceReclean, deep);
                Ext.removeNode(n);
                n = nx;
            }
            this.isCleansed = true;
            return this;
        },
        src: null,
        CSS: null,
        manager: null,
        disableMessaging: true,
        domReadyRetries: 7500,
        focusOnLoad: Ext.isIE,
        eventsFollowFrameLinks: true,
        remove: function() {
            this.destructor.apply(this, arguments);
            ElFrame.superclass.remove.apply(this, arguments);
        },
        getDocument: function() {
            return this.dom ? this.dom.ownerDocument: document;
        },
        submitAsTarget: function(submitCfg) {
            var opt = submitCfg || {},
            D = this.getDocument(),
            form = Ext.getDom(opt.form ? opt.form.form || opt.form: null, false, D) || Ext.DomHelper.append(D.body, {
                tag: 'form',
                cls: 'x-hidden x-mif-form',
                encoding: 'multipart/form-data'
            }),
            formFly = Ext.fly(form, '_dynaForm'),
            formState = {
                target: form.target || '',
                method: form.method || '',
                encoding: form.encoding || '',
                enctype: form.enctype || '',
                action: form.action || ''
            },
            encoding = opt.encoding || form.encoding,
            method = opt.method || form.method || 'POST';
            formFly.set({
                target: this.dom.name,
                method: method,
                encoding: encoding,
                action: opt.url || opt.action || form.action
            });
            if (method == 'POST' || !!opt.enctype) {
                formFly.set({
                    enctype: opt.enctype || form.enctype || encoding
                });
            }
            var hiddens, hd, ps;
            if (opt.params && (ps = Ext.isFunction(opt.params) ? opt.params() : opt.params)) {
                hiddens = [];
                Ext.iterate(ps = typeof ps == 'string' ? Ext.urlDecode(ps, false) : ps,
                function(n, v) {
                    Ext.fly(hd = D.createElement('input')).set({
                        type: 'hidden',
                        name: n,
                        value: v
                    });
                    form.appendChild(hd);
                    hiddens.push(hd);
                });
            }
            opt.callback && this._observable.addListener('_docready', opt.callback, opt.scope, {
                single: true
            });
            this._frameAction = true;
            this._targetURI = location.href;
            this.showMask();
            (function() {
                form.submit();
                hiddens && Ext.each(hiddens, Ext.removeNode, Ext);
                if (formFly.hasClass('x-mif-form')) {
                    formFly.remove();
                } else {
                    formFly.set(formState);
                }
                delete El._flyweights['_dynaForm'];
                formFly = null;
                this.hideMask(true);
            }).defer(100, this);
            return this;
        },
        resetUrl: (function() {
            return Ext.isIE && Ext.isSecure ? Ext.SSL_SECURE_URL: 'about:blank';
        })(),
        setSrc: function(url, discardUrl, callback, scope) {
            var src = url || this.src || this.resetUrl;
            var O = this._observable;
            this._unHook();
            Ext.isFunction(callback) && O.addListener('_docload', callback, scope || this, {
                single: true
            });
            this.showMask();
            (discardUrl !== true) && (this.src = src);
            var s = this._targetURI = (Ext.isFunction(src) ? src() || '': src);
            try {
                this._frameAction = true;
                this.dom.src = s;
                this.checkDOM();
            } catch(ex) {
                O.fireEvent.call(O, 'exception', this, ex);
            }
            return this;
        },
        setLocation: function(url, discardUrl, callback, scope) {
            var src = url || this.src || this.resetUrl;
            var O = this._observable;
            this._unHook();
            Ext.isFunction(callback) && O.addListener('_docload', callback, scope || this, {
                single: true
            });
            this.showMask();
            var s = this._targetURI = (Ext.isFunction(src) ? src() || '': src);
            if (discardUrl !== true) {
                this.src = src;
            }
            try {
                this._frameAction = true;
                this.getWindow().location.replace(s);
                this.checkDOM();
            } catch(ex) {
                O.fireEvent.call(O, 'exception', this, ex);
            }
            return this;
        },
        reset: function(src, callback, scope) {
            this._unHook();
            var loadMaskOff = false,
            s = src,
            win = this.getWindow(),
            O = this._observable;
            if (this.loadMask) {
                loadMaskOff = this.loadMask.disabled;
                this.loadMask.disabled = false;
            }
            this.hideMask(true);
            if (win) {
                this.isReset = true;
                var cb = callback;
                O.addListener('_docload',
                function(frame) {
                    if (this.loadMask) {
                        this.loadMask.disabled = loadMaskOff;
                    };
                    Ext.isFunction(cb) && (cb = cb.apply(scope || this, arguments));
                    O.fireEvent("reset", this);
                },
                this, {
                    single: true
                });
                Ext.isFunction(s) && (s = src());
                s = this._targetURI = Ext.isEmpty(s, true) ? this.resetUrl: s;
                win.location ? (win.location.href = s) : O.fireEvent('_docload', this);
            }
            return this;
        },
        scriptRE: /(?:<script.*?>)((\n|\r|.)*?)(?:<\/script>)/gi,
        update: function(content, loadScripts, callback, scope) {
            loadScripts = loadScripts || this.getUpdater().loadScripts || false;
            content = Ext.DomHelper.markup(content || '');
            content = loadScripts === true ? content: content.replace(this.scriptRE, "");
            var doc;
            if ((doc = this.getFrameDocument()) && !!content.length) {
                this._unHook();
                this.src = null;
                this.showMask();
                Ext.isFunction(callback) && this._observable.addListener('_docload', callback, scope || this, {
                    single: true
                });
                this._targetURI = location.href;
                doc.open();
                this._frameAction = true;
                doc.write(content);
                doc.close();
                this.checkDOM();
            } else {
                this.hideMask(true);
                Ext.isFunction(callback) && callback.call(scope, this);
            }
            return this;
        },
        execCommand: function(command, userInterface, value, validate) {
            var doc, assert;
            if ((doc = this.getFrameDocument()) && !!command) {
                try {
                    Ext.isIE && this.getWindow().focus();
                    assert = validate && Ext.isFunction(doc.queryCommandEnabled) ? doc.queryCommandEnabled(command) : true;
                    return assert && doc.execCommand(command, !!userInterface, value);
                } catch(eex) {
                    return false;
                }
            }
            return false;
        },
        setDesignMode: function(active) {
            var doc;
            (doc = this.getFrameDocument()) && (doc.designMode = (/on|true/i).test(String(active)) ? 'on': 'off');
        },
        getUpdater: function() {
            return this.updateManager || (this.updateManager = new MIF.Updater(this));
        },
        getHistory: function() {
            var h = null;
            try {
                h = this.getWindow().history;
            } catch(eh) {}
            return h;
        },
        get: function(el) {
            var doc = this.getFrameDocument();
            return doc ? Ext.get(el, doc) : doc = null;
        },
        fly: function(el, named) {
            var doc = this.getFrameDocument();
            return doc ? Ext.fly(el, named, doc) : null;
        },
        getDom: function(el) {
            var d;
            if (!el || !(d = this.getFrameDocument())) {
                return (d = null);
            }
            return Ext.getDom(el, d);
        },
        select: function(selector, unique) {
            var d;
            return (d = this.getFrameDocument()) ? Ext.Element.select(selector, unique, d) : d = null;
        },
        query: function(selector) {
            var d;
            return (d = this.getFrameDocument()) ? Ext.DomQuery.select(selector, d) : null;
        },
        removeNode: Ext.removeNode,
        _renderHook: function() {
            this._windowContext = null;
            this.CSS = this.CSS ? this.CSS.destroy() : null;
            this._hooked = false;
            try {
                if (this.writeScript('(function(){(window.hostMIF = parent.document.getElementById("' + this.id + '").ownerCt)._windowContext=' + (Ext.isIE ? 'window': '{eval:function(s){return new Function("return ("+s+")")();}}') + ';})()')) {
                    var w, p = this._frameProxy,
                    D = this.getFrameDocument();
                    if (w = this.getWindow()) {
                        p || (p = this._frameProxy = this._eventProxy.createDelegate(this));
                        addListener(w, 'focus', p);
                        addListener(w, 'blur', p);
                        addListener(w, 'resize', p);
                        addListener(w, 'unload', p);
                        D && addListener(Ext.isIE ? w: D, 'scroll', p);
                    }
                    D && (this.CSS = new Ext.ux.ManagedIFrame.CSS(D));
                }
            } catch(ex) {}
            return this.domWritable();
        },
        _unHook: function() {
            if (this._hooked) {
                this._windowContext && (this._windowContext.hostMIF = null);
                this._windowContext = null;
                var w, p = this._frameProxy;
                if (p && this.domWritable() && (w = this.getWindow())) {
                    removeListener(w, 'focus', p);
                    removeListener(w, 'blur', p);
                    removeListener(w, 'resize', p);
                    removeListener(w, 'unload', p);
                    removeListener(Ext.isIE ? w: this.getFrameDocument(), 'scroll', p);
                }
            }
            ELD.clearDocumentCache && ELD.clearDocumentCache(this.id);
            this.CSS = this.CSS ? this.CSS.destroy() : null;
            this.domFired = this._frameAction = this.domReady = this._hooked = false;
        },
        _windowContext: null,
        getFrameDocument: function() {
            var win = this.getWindow(),
            doc = null;
            try {
                doc = (Ext.isIE && win ? win.document: null) || this.dom.contentDocument || window.frames[this.dom.name].document || null;
            } catch(gdEx) {
                ELD.clearDocumentCache && ELD.clearDocumentCache(this.id);
                return false;
            }
            doc = (doc && Ext.isFunction(ELD.getDocument)) ? ELD.getDocument(doc, true) : doc;
            return doc;
        },
        getDoc: function() {
            var D = this.getFrameDocument();
            return Ext.get(D, D);
        },
        getBody: function() {
            var d;
            return (d = this.getFrameDocument()) ? this.get(d.body || d.documentElement) : null;
        },
        getDocumentURI: function() {
            var URI, d;
            try {
                URI = this.src && (d = this.getFrameDocument()) ? d.location.href: null;
            } catch(ex) {}
            return URI || (Ext.isFunction(this.src) ? this.src() : this.src);
        },
        getWindowURI: function() {
            var URI, w;
            try {
                URI = (w = this.getWindow()) ? w.location.href: null;
            } catch(ex) {}
            return URI || (Ext.isFunction(this.src) ? this.src() : this.src);
        },
        getWindow: function() {
            var dom = this.dom,
            win = null;
            try {
                win = dom.contentWindow || window.frames[dom.name] || null;
            } catch(gwEx) {}
            return win;
        },
        scrollChildIntoView: function(child, container, hscroll) {
            this.fly(child, '_scrollChildIntoView').scrollIntoView(this.getDom(container) || this.getBody().dom, hscroll);
            return this;
        },
        print: function() {
            try {
                var win;
                if (win = this.getWindow()) {
                    Ext.isIE && win.focus();
                    win.print();
                }
            } catch(ex) {
                throw new MIF.Error('printexception', ex.description || ejsonResponse.message || ex);
            }
            return this;
        },
        domWritable: function() {
            return !! Ext.isDocument(this.getFrameDocument(), true) && !!this._windowContext;
        },
        execScript: function(block, useDOM) {
            try {
                if (this.domWritable()) {
                    if (useDOM) {
                        this.writeScript(block);
                    } else {
                        return this._windowContext.eval(block);
                    }
                } else {
                    throw new MIF.Error('execscript-secure-context');
                }
            } catch(ex) {
                this._observable.fireEvent.call(this._observable, 'exception', this, ex);
                return false;
            }
            return true;
        },
        writeScript: function(block, attributes) {
            attributes = Ext.apply({},
            attributes || {},
            {
                type: "text/javascript",
                text: block
            });
            try {
                var head, script, doc = this.getFrameDocument();
                if (doc && typeof doc.getElementsByTagName != 'undefined') {
                    if (! (head = doc.getElementsByTagName("head")[0])) {
                        head = doc.createElement("head");
                        doc.getElementsByTagName("html")[0].appendChild(head);
                    }
                    if (head && (script = doc.createElement("script"))) {
                        for (var attrib in attributes) {
                            if (attributes.hasOwnProperty(attrib) && attrib in script) {
                                script[attrib] = attributes[attrib];
                            }
                        }
                        return !! head.appendChild(script);
                    }
                }
            } catch(ex) {
                this._observable.fireEvent.call(this._observable, 'exception', this, ex);
            } finally {
                script = head = null;
            }
            return false;
        },
        loadFunction: function(fn, useDOM, invokeIt) {
            var name = fn.name || fn;
            var fnSrc = fn.fn || window[fn];
            name && fnSrc && this.execScript(name + '=' + fnSrc, useDOM);
            invokeIt && this.execScript(name + '()');
        },
        loadHandler: function(e, target) {
            var rstatus = (this.dom || {}).readyState || (e || {}).type;
            if (this.eventsFollowFrameLinks || this._frameAction || this.isReset) {
                switch (rstatus) {
                case 'domready':
                case 'DOMFrameContentLoaded':
                case 'domfail':
                    this._onDocReady(rstatus);
                    break;
                case 'load':
                case 'complete':
                    this._onDocLoaded(rstatus);
                    break;
                case 'error':
                    this._observable.fireEvent.apply(this._observable, ['exception', this].concat(arguments));
                    break;
                default:
                }
                this.frameState = rstatus;
            }
        },
        _onDocReady: function(eventName) {
            var w, obv = this._observable,
            D;
            if (!this.isReset && this.focusOnLoad && (w = this.getWindow())) {
                w.focus();
            }
            obv.fireEvent("_docready", this);
            (D = this.getDoc()) && (D.isReady = true);
            if (!this.domFired && (this._hooked = this._renderHook())) {
                this.domFired = true;
                this.isReset || obv.fireEvent.call(obv, 'domready', this);
            }
            this.domReady = true;
            this.hideMask();
        },
        _onDocLoaded: function(eventName) {
            var obv = this._observable,
            w;
            this.domReady || this._onDocReady('domready');
            obv.fireEvent("_docload", this);
            this.isReset || obv.fireEvent("documentloaded", this);
            this.hideMask(true);
            this._frameAction = this.isReset = false;
        },
        checkDOM: function(win) {
            if (Ext.isGecko) {
                return;
            }
            var n = 0,
            frame = this,
            domReady = false,
            b, l, d, max = this.domReadyRetries || 2500,
            polling = false,
            startLocation = (this.getFrameDocument() || {
                location: {}
            }).location.href;
            (function() {
                d = frame.getFrameDocument() || {
                    location: {}
                };
                polling = (d.location.href !== startLocation || d.location.href === frame._targetURI);
                if (frame.domReady) {
                    return;
                }
                domReady = polling && ((b = frame.getBody()) && !!(b.dom.innerHTML || '').length) || false;
                if (d.location.href && !domReady && (++n < max)) {
                    setTimeout(arguments.callee, 2);
                    return;
                }
                frame.loadHandler({
                    type: domReady ? 'domready': 'domfail'
                });
            })();
        },
        filterEventOptionsRe: /^(?:scope|delay|buffer|single|stopEvent|preventDefault|stopPropagation|normalized|args|delegate)$/,
        addListener: function(eventName, fn, scope, options) {
            if (typeof eventName == "object") {
                var o = eventName;
                for (var e in o) {
                    if (this.filterEventOptionsRe.test(e)) {
                        continue;
                    }
                    if (typeof o[e] == "function") {
                        this.addListener(e, o[e], o.scope, o);
                    } else {
                        this.addListener(e, o[e].fn, o[e].scope, o[e]);
                    }
                }
                return;
            }
            if (reSynthEvents.test(eventName)) {
                var O = this._observable;
                if (O) {
                    O.events[eventName] || (O.addEvents(eventName));
                    O.addListener.call(O, eventName, fn, scope || this, options);
                }
            } else {
                ElFrame.superclass.addListener.call(this, eventName, fn, scope || this, options);
            }
            return this;
        },
        removeListener: function(eventName, fn, scope) {
            var O = this._observable;
            if (reSynthEvents.test(eventName)) {
                O && O.removeListener.call(O, eventName, fn, scope || this, options);
            } else {
                ElFrame.superclass.removeListener.call(this, eventName, fn, scope || this);
            }
            return this;
        },
        removeAllListeners: function() {
            Ext.EventManager.removeAll(this.dom);
            var O = this._observable;
            O && O.purgeListeners.call(this._observable);
            return this;
        },
        showMask: function(msg, msgCls, maskCls) {
            var lmask = this.loadMask;
            if (lmask && !lmask.disabled) {
                this.mask(msg || lmask.msg, msgCls || lmask.msgCls, maskCls || lmask.maskCls, lmask.maskEl);
            }
        },
        hideMask: function(forced) {
            var tlm = this.loadMask || {};
            if (forced || (tlm.hideOnReady && this.domReady)) {
                this.unmask();
            }
        },
        mask: function(msg, msgCls, maskCls, maskEl) {
            this._mask && this.unmask();
            var p = Ext.get(maskEl) || this.parent('.ux-mif-mask-target') || this.parent();
            if (p.getStyle("position") == "static" && !p.select('iframe,frame,object,embed').elements.length) {
                p.addClass("x-masked-relative");
            }
            p.addClass("x-masked");
            this._mask = Ext.DomHelper.append(p, {
                cls: maskCls || "ux-mif-el-mask"
            },
            true);
            this._mask.setDisplayed(true);
            this._mask._agent = p;
            if (typeof msg == 'string') {
                this._maskMsg = Ext.DomHelper.append(p, {
                    cls: msgCls || "ux-mif-el-mask-msg",
                    style: {
                        visibility: 'hidden'
                    },
                    cn: {
                        tag: 'div',
                        html: msg
                    }
                },
                true);
                this._maskMsg.setVisibilityMode(Ext.Element.VISIBILITY).center(p).setVisible(true);
            }
            if (Ext.isIE && !(Ext.isIE7 && Ext.isStrict) && this.getStyle('height') == 'auto') {
                this._mask.setSize(undefined, this._mask.getHeight());
            }
            return this._mask;
        },
        unmask: function() {
            var a;
            if (this._mask) { (a = this._mask._agent) && a.removeClass(["x-masked-relative", "x-masked"]);
                if (this._maskMsg) {
                    this._maskMsg.remove();
                    delete this._maskMsg;
                }
                this._mask.remove();
                delete this._mask;
            }
        },
        createFrameShim: function(imgUrl, shimCls) {
            this.shimCls = shimCls || this.shimCls || 'ux-mif-shim';
            this.frameShim || (this.frameShim = this.next('.' + this.shimCls) || Ext.DomHelper.append(this.dom.parentNode, {
                tag: 'img',
                src: imgUrl || Ext.BLANK_IMAGE_URL,
                cls: this.shimCls,
                galleryimg: "no"
            },
            true));
            this.frameShim && (this.frameShim.autoBoxAdjust = false);
            return this.frameShim;
        },
        toggleShim: function(show) {
            var shim = this.frameShim || this.createFrameShim();
            var cls = this.shimCls + '-on'; ! show && shim.removeClass(cls);
            show && !shim.hasClass(cls) && shim.addClass(cls);
        },
        load: function(loadCfg) {
            var um;
            if (um = this.getUpdater()) {
                if (loadCfg && loadCfg.renderer) {
                    um.setRenderer(loadCfg.renderer);
                    delete loadCfg.renderer;
                }
                um.update.apply(um, arguments);
            }
            return this;
        },
        _eventProxy: function(e) {
            if (!e) return;
            e = Ext.EventObject.setEvent(e);
            var be = e.browserEvent || e,
            er, args = [e.type, this];
            if (!be['eventPhase'] || (be['eventPhase'] == (be['AT_TARGET'] || 2))) {
                if (e.type == 'resize') {
                    var doc = this.getFrameDocument();
                    doc && (args.push({
                        height: ELD.getDocumentHeight(doc),
                        width: ELD.getDocumentWidth(doc)
                    },
                    {
                        height: ELD.getViewportHeight(doc),
                        width: ELD.getViewportWidth(doc)
                    },
                    {
                        height: ELD.getViewHeight(false, doc),
                        width: ELD.getViewWidth(false, doc)
                    }));
                }
                er = this._observable ? this._observable.fireEvent.apply(this._observable, args.concat(Array.prototype.slice.call(arguments, 0))) : null;
                (e.type == 'unload') && this._unHook();
            }
            return er;
        },
        sendMessage: function(message, tag, origin) {},
        postMessage: function(message, ports, origin) {}
    });
    ElFrame = Ext.Element.IFRAME = Ext.Element.FRAME = Ext.ux.ManagedIFrame.Element;
    var fp = ElFrame.prototype;
    Ext.override(ElFrame, {
        on: fp.addListener,
        un: fp.removeListener,
        getUpdateManager: fp.getUpdater
    });
    Ext.ux.ManagedIFrame.ComponentAdapter = function() {};
    Ext.ux.ManagedIFrame.ComponentAdapter.prototype = {
        version: 2.12,
        defaultSrc: null,
        unsupportedText: 'Inline frames are NOT enabled\/supported by your browser.',
        hideMode: !Ext.isIE && !!Ext.ux.plugin.VisibilityMode ? 'nosize': 'display',
        animCollapse: Ext.isIE,
        animFloat: Ext.isIE,
        frameConfig: null,
        focusOnLoad: false,
        frameEl: null,
        useShim: false,
        autoScroll: true,
        autoLoad: null,
        getId: function() {
            return this.id || (this.id = "mif-comp-" + (++Ext.Component.AUTO_ID));
        },
        stateEvents: ['documentloaded'],
        stateful: false,
        setAutoScroll: function(auto) {
            var scroll = Ext.value(auto, this.autoScroll === true);
            this.rendered && this.getFrame() && this.frameEl.setOverflow((this.autoScroll = scroll) ? 'auto': 'hidden');
            return this;
        },
        getContentTarget: function() {
            return this.getFrame();
        },
        getFrame: function() {
            if (this.rendered) {
                if (this.frameEl) {
                    return this.frameEl;
                }
                var f = this.items && this.items.first ? this.items.first() : null;
                f && (this.frameEl = f.frameEl);
                return this.frameEl;
            }
            return null;
        },
        getFrameWindow: function() {
            return this.getFrame() ? this.frameEl.getWindow() : null;
        },
        getFrameDocument: function() {
            return this.getFrame() ? this.frameEl.getFrameDocument() : null;
        },
        getFrameDoc: function() {
            return this.getFrame() ? this.frameEl.getDoc() : null;
        },
        getFrameBody: function() {
            return this.getFrame() ? this.frameEl.getBody() : null;
        },
        resetFrame: function() {
            this.getFrame() && this.frameEl.reset.apply(this.frameEl, arguments);
            return this;
        },
        submitAsTarget: function(submitCfg) {
            this.getFrame() && this.frameEl.submitAsTarget.apply(this.frameEl, arguments);
            return this;
        },
        load: function(loadCfg) {
            if (loadCfg && this.getFrame()) {
                var args = arguments;
                this.resetFrame(null,
                function() {
                    loadCfg.submitAsTarget ? this.submitAsTarget.apply(this, args) : this.frameEl.load.apply(this.frameEl, args);
                },
                this);
            }
            this.autoLoad = loadCfg;
            return this;
        },
        doAutoLoad: function() {
            this.autoLoad && this.load(typeof this.autoLoad == 'object' ? this.autoLoad: {
                url: this.autoLoad
            });
        },
        getUpdater: function() {
            return this.getFrame() ? this.frameEl.getUpdater() : null;
        },
        setSrc: function(url, discardUrl, callback, scope) {
            this.getFrame() && this.frameEl.setSrc.apply(this.frameEl, arguments);
            return this;
        },
        setLocation: function(url, discardUrl, callback, scope) {
            this.getFrame() && this.frameEl.setLocation.apply(this.frameEl, arguments);
            return this;
        },
        getState: function() {
            var URI = this.getFrame() ? this.frameEl.getDocumentURI() || null: null;
            var state = this.supr().getState.call(this);
            state = Ext.apply(state || {},
            {
                defaultSrc: Ext.isFunction(URI) ? URI() : URI,
                autoLoad: this.autoLoad
            });
            return state;
        },
        setMIFEvents: function() {
            this.addEvents('documentloaded', 'domready', 'exception', 'message', 'blur', 'focus', 'scroll', 'resize', 'unload', 'reset');
        },
        sendMessage: function(message, tag, origin) {},
        onAdd: function(C) {
            C.relayTarget && this.suspendEvents(true);
        },
        initRef: function() {
            if (this.ref) {
                var t = this,
                levels = this.ref.split('/'),
                l = levels.length,
                i;
                for (i = 0; i < l; i++) {
                    if (t.ownerCt) {
                        t = t.ownerCt;
                    }
                }
                this.refName = levels[--i];
                t[this.refName] || (t[this.refName] = this);
                this.refOwner = t;
            }
        }
    };
    Ext.ux.ManagedIFrame.Component = Ext.extend(Ext.BoxComponent, {
        ctype: "Ext.ux.ManagedIFrame.Component",
        initComponent: function() {
            var C = {
                monitorResize: this.monitorResize || (this.monitorResize = !!this.fitToParent),
                plugins: (this.plugins || []).concat(this.hideMode === 'nosize' && Ext.ux.plugin.VisibilityMode ? [new Ext.ux.plugin.VisibilityMode({
                    hideMode: 'nosize',
                    elements: ['bwrap']
                })] : [])
            };
            MIF.Component.superclass.initComponent.call(Ext.apply(this, Ext.apply(this.initialConfig, C)));
            this.setMIFEvents();
        },
        onRender: function(ct, position) {
            var frCfg = this.frameCfg || this.frameConfig || (this.relayTarget ? {
                name: this.relayTarget.id
            }: {}) || {};
            var frDOM = frCfg.autoCreate || frCfg;
            frDOM = Ext.apply({
                tag: 'iframe',
                id: Ext.id()
            },
            frDOM);
            var el = Ext.getDom(this.el);
            (el && el.tagName == 'iframe') || (this.autoEl = Ext.apply({
                name: frDOM.id,
                frameborder: 0
            },
            frDOM));
            MIF.Component.superclass.onRender.apply(this, arguments);
            if (this.unsupportedText) {
                ct.child('noframes') || ct.createChild({
                    tag: 'noframes',
                    html: this.unsupportedText || null
                });
            }
            var frame = this.el;
            var F;
            if (F = this.frameEl = (this.el ? new MIF.Element(this.el.dom, true) : null)) { (F.ownerCt = (this.relayTarget || this)).frameEl = F;
                F.addClass('ux-mif');
                if (this.loadMask) {
                    var mEl = this.loadMask.maskEl;
                    F.loadMask = Ext.apply({
                        disabled: false,
                        hideOnReady: false,
                        msgCls: 'ext-el-mask-msg x-mask-loading',
                        maskCls: 'ext-el-mask'
                    },
                    {
                        maskEl: F.ownerCt[String(mEl)] || F.parent('.' + String(mEl)) || F.parent('.ux-mif-mask-target') || mEl
                    },
                    Ext.isString(this.loadMask) ? {
                        msg: this.loadMask
                    }: this.loadMask);
                    Ext.get(F.loadMask.maskEl) && Ext.get(F.loadMask.maskEl).addClass('ux-mif-mask-target');
                }
                Ext.apply(F, {
                    disableMessaging: Ext.value(this.disableMessaging, true),
                    focusOnLoad: Ext.value(this.focusOnLoad, Ext.isIE)
                });
                F._observable && (this.relayTarget || this).relayEvents(F._observable, frameEvents.concat(this._msgTagHandlers || []));
                delete this.contentEl;
            }
        },
        afterRender: function(container) {
            MIF.Component.superclass.afterRender.apply(this, arguments);
            if (this.fitToParent && !this.ownerCt) {
                var pos = this.getPosition(),
                size = (Ext.get(this.fitToParent) || this.getEl().parent()).getViewSize();
                this.setSize(size.width - pos[0], size.height - pos[1]);
            }
            this.getEl().setOverflow('hidden');
            this.setAutoScroll();
            var F;
            if (F = this.frameEl) {
                var ownerCt = this.ownerCt;
                while (ownerCt) {
                    ownerCt.on('afterlayout',
                    function(container, layout) {
                        Ext.each(['north', 'south', 'east', 'west'],
                        function(region) {
                            var reg;
                            if ((reg = layout[region]) && reg.split && reg.split.dd && !reg._splitTrapped) {
                                reg.split.dd.endDrag = reg.split.dd.endDrag.createSequence(MIM.hideShims, MIM);
                                reg.split.on('beforeresize', MIM.showShims, MIM);
                                reg._splitTrapped = MIM._splitTrapped = true;
                            }
                        },
                        this);
                    },
                    this, {
                        single: true
                    });
                    ownerCt = ownerCt.ownerCt;
                }
                if ( !! this.ownerCt || this.useShim) {
                    this.frameShim = F.createFrameShim();
                }
                this.getUpdater().showLoadIndicator = this.showLoadIndicator || false;
                var resumeEvents = this.relayTarget && this.ownerCt ? this.ownerCt.resumeEvents.createDelegate(this.ownerCt) : null;
                if (this.autoload) {
                    this.doAutoLoad();
                } else if (this.frameMarkup || this.html) {
                    F.update(this.frameMarkup || this.html, true, resumeEvents);
                    delete this.html;
                    delete this.frameMarkup;
                    return;
                } else {
                    if (this.defaultSrc) {
                        F.setSrc(this.defaultSrc, false);
                    } else {
                        F.reset(null, resumeEvents);
                        return;
                    }
                }
                resumeEvents && resumeEvents();
            }
        },
        beforeDestroy: function() {
            var F;
            if (F = this.getFrame()) {
                F.remove();
                this.frameEl = this.frameShim = null;
            }
            this.relayTarget && (this.relayTarget.frameEl = null);
            MIF.Component.superclass.beforeDestroy.call(this);
        }
    });
    Ext.override(MIF.Component, MIF.ComponentAdapter.prototype);
    Ext.reg('mif', MIF.Component);
    function embed_MIF(config) {
        config || (config = {});
        config.layout = 'fit';
        config.items = {
            xtype: 'mif',
            ref: 'mifChild',
            useShim: true,
            autoScroll: Ext.value(config.autoScroll, this.autoScroll),
            defaultSrc: Ext.value(config.defaultSrc, this.defaultSrc),
            frameMarkup: Ext.value(config.html, this.html),
            loadMask: Ext.value(config.loadMask, this.loadMask),
            disableMessaging: Ext.value(config.disableMessaging, this.disableMessaging),
            focusOnLoad: Ext.value(config.focusOnLoad, this.focusOnLoad),
            frameConfig: Ext.value(config.frameConfig || config.frameCfg, this.frameConfig),
            relayTarget: this
        };
        delete config.html;
        this.setMIFEvents();
        return config;
    };
    Ext.ux.ManagedIFrame.Panel = Ext.extend(Ext.Panel, {
        ctype: 'Ext.ux.ManagedIFrame.Panel',
        bodyCssClass: 'ux-mif-mask-target',
        constructor: function(config) {
            MIF.Panel.superclass.constructor.call(this, embed_MIF.call(this, config));
        }
    });
    Ext.override(MIF.Panel, MIF.ComponentAdapter.prototype);
    Ext.reg('iframepanel', MIF.Panel);
    Ext.ux.ManagedIFrame.Portlet = Ext.extend(Ext.ux.ManagedIFrame.Panel, {
        ctype: "Ext.ux.ManagedIFrame.Portlet",
        anchor: '100%',
        frame: true,
        collapseEl: 'bwrap',
        collapsible: true,
        draggable: true,
        cls: 'x-portlet'
    });
    Ext.reg('iframeportlet', MIF.Portlet);
    Ext.ux.ManagedIFrame.Window = Ext.extend(Ext.Window, {
        ctype: "Ext.ux.ManagedIFrame.Window",
        bodyCssClass: 'ux-mif-mask-target',
        constructor: function(config) {
            MIF.Window.superclass.constructor.call(this, embed_MIF.call(this, config));
        }
    });
    Ext.override(MIF.Window, MIF.ComponentAdapter.prototype);
    Ext.reg('iframewindow', MIF.Window);
    Ext.ux.ManagedIFrame.Updater = Ext.extend(Ext.Updater, {
        showLoading: function() {
            this.showLoadIndicator && this.el && this.el.mask(this.indicatorText);
        },
        hideLoading: function() {
            this.showLoadIndicator && this.el && this.el.unmask();
        },
        updateComplete: function(response) {
            MIF.Updater.superclass.updateComplete.apply(this, arguments);
            this.hideLoading();
        },
        processFailure: function(response) {
            MIF.Updater.superclass.processFailure.apply(this, arguments);
            this.hideLoading();
        }
    });
    var styleCamelRe = /(-[a-z])/gi;
    var styleCamelFn = function(m, a) {
        return a.charAt(1).toUpperCase();
    };
    Ext.ux.ManagedIFrame.CSS = function(hostDocument) {
        var doc;
        if (hostDocument) {
            doc = hostDocument;
            return {
                rules: null,
                destroy: function() {
                    return doc = null;
                },
                createStyleSheet: function(cssText, id) {
                    var ss;
                    if (!doc) return;
                    var head = doc.getElementsByTagName("head")[0];
                    var rules = doc.createElement("style");
                    rules.setAttribute("type", "text/css");
                    Ext.isString(id) && rules.setAttribute("id", id);
                    if (Ext.isIE) {
                        head.appendChild(rules);
                        ss = rules.styleSheet;
                        ss.cssText = cssText;
                    } else {
                        try {
                            rules.appendChild(doc.createTextNode(cssText));
                        } catch(e) {
                            rules.cssText = cssText;
                        }
                        head.appendChild(rules);
                        ss = rules.styleSheet ? rules.styleSheet: (rules.sheet || doc.styleSheets[doc.styleSheets.length - 1]);
                    }
                    this.cacheStyleSheet(ss);
                    return ss;
                },
                removeStyleSheet: function(id) {
                    if (!doc || !id) return;
                    var existing = doc.getElementById(id);
                    if (existing) {
                        existing.parentNode.removeChild(existing);
                    }
                },
                swapStyleSheet: function(id, url) {
                    if (!doc) return;
                    this.removeStyleSheet(id);
                    var ss = doc.createElement("link");
                    ss.setAttribute("rel", "stylesheet");
                    ss.setAttribute("type", "text/css");
                    Ext.isString(id) && ss.setAttribute("id", id);
                    ss.setAttribute("href", url);
                    doc.getElementsByTagName("head")[0].appendChild(ss);
                },
                refreshCache: function() {
                    return this.getRules(true);
                },
                cacheStyleSheet: function(ss, media) {
                    this.rules || (this.rules = {});
                    try {
                        Ext.each(ss.cssRules || ss.rules || [],
                        function(rule) {
                            this.hashRule(rule, ss, media);
                        },
                        this);
                        Ext.each(ss.imports || [],
                        function(sheet) {
                            sheet && this.cacheStyleSheet(sheet, this.resolveMedia([sheet, sheet.parentStyleSheet]));
                        },
                        this);
                    } catch(e) {}
                },
                hashRule: function(rule, sheet, mediaOverride) {
                    var mediaSelector = mediaOverride || this.resolveMedia(rule);
                    if (rule.cssRules || rule.rules) {
                        this.cacheStyleSheet(rule, this.resolveMedia([rule, rule.parentRule]));
                    }
                    if (rule.styleSheet) {
                        this.cacheStyleSheet(rule.styleSheet, this.resolveMedia([rule, rule.ownerRule, rule.parentStyleSheet]));
                    }
                    rule.selectorText && Ext.each((mediaSelector || '').split(','),
                    function(media) {
                        this.rules[((media ? media.trim() + ':': '') + rule.selectorText).toLowerCase()] = rule;
                    },
                    this);
                },
                resolveMedia: function(rule) {
                    var media;
                    Ext.each([].concat(rule),
                    function(r) {
                        if (r && r.media && r.media.length) {
                            media = r.media;
                            return false;
                        }
                    });
                    return media ? (Ext.isIE ? String(media) : media.mediaText) : '';
                },
                getRules: function(refreshCache) {
                    if (!this.rules || refreshCache) {
                        this.rules = {};
                        if (doc) {
                            var ds = doc.styleSheets;
                            for (var i = 0, len = ds.length; i < len; i++) {
                                try {
                                    this.cacheStyleSheet(ds[i]);
                                } catch(e) {}
                            }
                        }
                    }
                    return this.rules;
                },
                getRule: function(selector, refreshCache, mediaSelector) {
                    var rs = this.getRules(refreshCache);
                    if (Ext.type(mediaSelector) == 'string') {
                        mediaSelector = mediaSelector.trim() + ':';
                    } else {
                        mediaSelector = '';
                    }
                    if (!Ext.isArray(selector)) {
                        return rs[(mediaSelector + selector).toLowerCase()];
                    }
                    var select;
                    for (var i = 0; i < selector.length; i++) {
                        select = (mediaSelector + selector[i]).toLowerCase();
                        if (rs[select]) {
                            return rs[select];
                        }
                    }
                    return null;
                },
                updateRule: function(selector, property, value, mediaSelector) {
                    Ext.each((mediaSelector || '').split(','),
                    function(mediaSelect) {
                        if (!Ext.isArray(selector)) {
                            var rule = this.getRule(selector, false, mediaSelect);
                            if (rule) {
                                rule.style[property.replace(camelRe, camelFn)] = value;
                                return true;
                            }
                        } else {
                            for (var i = 0; i < selector.length; i++) {
                                if (this.updateRule(selector[i], property, value, mediaSelect)) {
                                    return true;
                                }
                            }
                        }
                        return false;
                    },
                    this);
                }
            };
        }
    };
    Ext.ux.ManagedIFrame.Manager = function() {
        var frames = {};
        var implementation = {
            _DOMFrameReadyHandler: function(e) {
                try {
                    var $frame;
                    if ($frame = e.target.ownerCt) {
                        $frame.loadHandler.call($frame, e);
                    }
                } catch(rhEx) {}
            },
            shimCls: 'ux-mif-shim',
            register: function(frame) {
                frame.manager = this;
                frames[frame.id] = frames[frame.name] = {
                    ref: frame
                };
                return frame;
            },
            deRegister: function(frame) {
                delete frames[frame.id];
                delete frames[frame.name];
            },
            hideShims: function() {
                var mm = MIF.Manager;
                mm.shimsApplied && Ext.select('.' + mm.shimCls, true).removeClass(mm.shimCls + '-on');
                mm.shimsApplied = false;
            },
            showShims: function() {
                var mm = MIF.Manager; ! mm.shimsApplied && Ext.select('.' + mm.shimCls, true).addClass(mm.shimCls + '-on');
                mm.shimsApplied = true;
            },
            getFrameById: function(id) {
                return typeof id == 'string' ? (frames[id] ? frames[id].ref || null: null) : null;
            },
            getFrameByName: function(name) {
                return this.getFrameById(name);
            },
            getFrameHash: function(frame) {
                return frames[frame.id] || frames[frame.id] || null;
            },
            destroy: function() {
                if (document.addEventListener && !Ext.isOpera) {
                    window.removeEventListener("DOMFrameContentLoaded", this._DOMFrameReadyHandler, false);
                }
            }
        };
        document.addEventListener && !Ext.isOpera && window.addEventListener("DOMFrameContentLoaded", implementation._DOMFrameReadyHandler, false);
        Ext.EventManager.on(window, 'beforeunload', implementation.destroy, implementation);
        return implementation;
    } ();
    MIM = MIF.Manager;
    MIM.showDragMask = MIM.showShims;
    MIM.hideDragMask = MIM.hideShims;
    var winDD = Ext.Window.DD;
    Ext.override(winDD, {
        startDrag: winDD.prototype.startDrag.createInterceptor(MIM.showShims),
        endDrag: winDD.prototype.endDrag.createInterceptor(MIM.hideShims)
    });
    Ext.ux.ManagedIFramePanel = MIF.Panel;
    Ext.ux.ManagedIFramePortlet = MIF.Portlet;
    Ext.ux.ManagedIframe = function(el, opt) {
        var args = Array.prototype.slice.call(arguments, 0),
        el = Ext.get(args[0]),
        config = args[0];
        if (el && el.dom && el.dom.tagName == 'IFRAME') {
            config = args[1] || {};
        } else {
            config = args[0] || args[1] || {};
            el = config.autoCreate ? Ext.get(Ext.DomHelper.append(config.autoCreate.parent || Ext.getBody(), Ext.apply({
                tag: 'iframe',
                frameborder: 0,
                cls: 'x-mif',
                src: (Ext.isIE && Ext.isSecure) ? Ext.SSL_SECURE_URL: 'about:blank'
            },
            config.autoCreate))) : null;
            if (el && config.unsupportedText) {
                Ext.DomHelper.append(el.dom.parentNode, {
                    tag: 'noframes',
                    html: config.unsupportedText
                });
            }
        }
        var mif = new MIF.Element(el, true);
        if (mif) {
            Ext.apply(mif, {
                disableMessaging: Ext.value(config.disableMessaging, true),
                loadMask: !!config.loadMask ? Ext.apply({
                    msg: 'Loading..',
                    msgCls: 'x-mask-loading',
                    maskEl: null,
                    hideOnReady: false,
                    disabled: false
                },
                config.loadMask) : false,
                _windowContext: null,
                eventsFollowFrameLinks: Ext.value(config.eventsFollowFrameLinks, true)
            });
            config.listeners && mif.on(config.listeners);
            if ( !! config.html) {
                mif.update(config.html);
            } else { !! config.src && mif.setSrc(config.src);
            }
        }
        return mif;
    };
    Ext.ux.ManagedIFrame.Error = Ext.extend(Ext.Error, {
        constructor: function(message, arg) {
            this.arg = arg;
            Ext.Error.call(this, message);
        },
        name: 'Ext.ux.ManagedIFrame'
    });
    Ext.apply(Ext.ux.ManagedIFrame.Error.prototype, {
        lang: {
            'documentcontext-remove': 'An attempt was made to remove an Element from the wrong document context.',
            'execscript-secure-context': 'An attempt was made at script execution within a document context with limited access permissions.',
            'printexception': 'An Error was encountered attempting the print the frame contents (document access is likely restricted).'
        }
    });
    Ext.onReady(function() {
        var CSS = new Ext.ux.ManagedIFrame.CSS(document),
        rules = [];
        CSS.getRule('.ux-mif-fill') || (rules.push('.ux-mif-fill{height:100%;width:100%;}'));
        CSS.getRule('.ux-mif-mask-target') || (rules.push('.ux-mif-mask-target{position:relative;zoom:1;}'));
        CSS.getRule('.ux-mif-el-mask') || (rules.push('.ux-mif-el-mask {z-index: 100;position: absolute;top:0;left:0;-moz-opacity: 0.5;opacity: .50;*filter: alpha(opacity=50);width: 100%;height: 100%;zoom: 1;} ', '.ux-mif-el-mask-msg {z-index: 1;position: absolute;top: 0;left: 0;border:1px solid;background:repeat-x 0 -16px;padding:2px;} ', '.ux-mif-el-mask-msg div {padding:5px 10px 5px 10px;border:1px solid;cursor:wait;} '));
        if (!CSS.getRule('.ux-mif-shim')) {
            rules.push('.ux-mif-shim {z-index:8500;position:absolute;top:0px;left:0px;background:transparent!important;overflow:hidden;display:none;}');
            rules.push('.ux-mif-shim-on{width:100%;height:100%;display:block;zoom:1;}');
            rules.push('.ext-ie6 .ux-mif-shim{margin-left:5px;margin-top:3px;}');
        } !! rules.length && CSS.createStyleSheet(rules.join(' '), 'mifCSS');
    });
    Ext.provide && Ext.provide('mif');
})();