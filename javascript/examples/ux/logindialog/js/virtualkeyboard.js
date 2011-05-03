Ext.ns('Ext.ux');

/**
 * Licensed under GNU LESSER GENERAL PUBLIC LICENSE Version 3
 *
 * Inspired from: HTML Virtual Keyboard Interface Script - v1.11
 *   http://www.greywyvern.com/code/js/keyboard.html
 *   Copyright (c) 2008 - GreyWyvern
 *  Licenced for free distribution under the BSDL
 *   http://www.opensource.org/licenses/bsd-license.php

 *
 * @author Edouard Fattal <efattal@gmail.com>
 * @url http://efattal.fr/extjs/examples/virtualkeyboard
 */

/**
 * @class Ext.ux.VirtualKeyboard
 * @extends Ext.Component
 */ 
Ext.ux.VirtualKeyboard = Ext.extend(Ext.Component, {
	/* ***** Create keyboards **************************************** */
	keyboardTarget: null,
	languageSelection: false,
	numpad: true,
	keyCenter: 3,
	layoutDDK: {},
	shift: false,
	capslock: false,
	alternate: false,
	dead: false,
	deadKeysOn: false,
	Languages: {
	
		
	},
	deadKey: {
		'"': [ // Umlaut / Diaeresis / Greek Dialytika
			["a", "\u00e4"], ["e", "\u00eb"], ["i", "\u00ef"], ["o", "\u00f6"], ["u", "\u00fc"], ["y", "\u00ff"], ["\u03b9", "\u03ca"], ["\u03c5", "\u03cb"],
			["A", "\u00c4"], ["E", "\u00cb"], ["I", "\u00cf"], ["O", "\u00d6"], ["U", "\u00dc"], ["Y", "\u0178"], ["\u0399", "\u03aa"], ["\u03a5", "\u03ab"]
		],
		'\u00a8': [ // Umlaut / Diaeresis / Greek Dialytika
			["a", "\u00e4"], ["e", "\u00eb"], ["i", "\u00ef"], ["o", "\u00f6"], ["u", "\u00fc"], ["y", "\u00ff"], ["\u03b9", "\u03ca"], ["\u03c5", "\u03cb"],
			["A", "\u00c4"], ["E", "\u00cb"], ["I", "\u00cf"], ["O", "\u00d6"], ["U", "\u00dc"], ["Y", "\u0178"], ["\u0399", "\u03aa"], ["\u03a5", "\u03ab"]
		],
		'~': [ // Tilde
			["a", "\u00e3"], ["o", "\u00f5"], ["n", "\u00f1"],
			["A", "\u00c3"], ["O", "\u00d5"], ["N", "\u00d1"]
		],
		'^': [ // Circumflex
			["a", "\u00e2"], ["e", "\u00ea"], ["i", "\u00ee"], ["o", "\u00f4"], ["u", "\u00fb"], ["w", "\u0175"], ["y", "\u0177"],
			["A", "\u00c2"], ["E", "\u00ca"], ["I", "\u00ce"], ["O", "\u00d4"], ["U", "\u00db"], ["W", "\u0174"], ["Y", "\u0176"]
		],
		'\u02c7': [ // Baltic caron
			["c", "\u010D"], ["s", "\u0161"], ["z", "\u017E"], ["r", "\u0159"], ["d", "\u010f"], ["t", "\u0165"], ["n", "\u0148"], ["l", "\u013e"], ["e", "\u011b"],
			["C", "\u010C"], ["S", "\u0160"], ["Z", "\u017D"], ["R", "\u0158"], ["D", "\u010e"], ["T", "\u0164"], ["N", "\u0147"], ["L", "\u013d"], ["E", "\u011a"]
		],
		'\u02d8': [ // Romanian and Turkish breve
			["a", "\u0103"], ["g", "\u011f"],
			["A", "\u0102"], ["G", "\u011e"]
		],
		'`': [ // Grave
			["a", "\u00e0"], ["e", "\u00e8"], ["i", "\u00ec"], ["o", "\u00f2"], ["u", "\u00f9"],
			["A", "\u00c0"], ["E", "\u00c8"], ["I", "\u00cc"], ["O", "\u00d2"], ["U", "\u00d9"]
		],
		"'": [ // Acute / Greek Tonos
			["a", "\u00e1"], ["e", "\u00e9"], ["i", "\u00ed"], ["o", "\u00f3"], ["u", "\u00fa"], ["\u03b1", "\u03ac"], ["\u03b5", "\u03ad"], ["\u03b7", "\u03ae"], ["\u03b9", "\u03af"], ["\u03bf", "\u03cc"], ["\u03c5", "\u03cd"], ["\u03c9", "\u03ce"],
			["A", "\u00c1"], ["E", "\u00c9"], ["I", "\u00cd"], ["O", "\u00d3"], ["U", "\u00da"], ["\u0391", "\u0386"], ["\u0395", "\u0388"], ["\u0397", "\u0389"], ["\u0399", "\u038a"], ["\u039f", "\u038c"], ["\u03a5", "\u038e"], ["\u03a9", "\u038f"]
		],
		'\u00b4':[ // Acute / Greek Tonos
			["a", "\u00e1"], ["e", "\u00e9"], ["i", "\u00ed"], ["o", "\u00f3"], ["u", "\u00fa"], ["\u03b1", "\u03ac"], ["\u03b5", "\u03ad"], ["\u03b7", "\u03ae"], ["\u03b9", "\u03af"], ["\u03bf", "\u03cc"], ["\u03c5", "\u03cd"], ["\u03c9", "\u03ce"],
			["A", "\u00c1"], ["E", "\u00c9"], ["I", "\u00cd"], ["O", "\u00d3"], ["U", "\u00da"], ["\u0391", "\u0386"], ["\u0395", "\u0388"], ["\u0397", "\u0389"], ["\u0399", "\u038a"], ["\u039f", "\u038c"], ["\u03a5", "\u038e"], ["\u03a9", "\u038f"]
		],
		'\u0384': [ // Acute / Greek Tonos
			["a", "\u00e1"], ["e", "\u00e9"], ["i", "\u00ed"], ["o", "\u00f3"], ["u", "\u00fa"], ["\u03b1", "\u03ac"], ["\u03b5", "\u03ad"], ["\u03b7", "\u03ae"], ["\u03b9", "\u03af"], ["\u03bf", "\u03cc"], ["\u03c5", "\u03cd"], ["\u03c9", "\u03ce"],
			["A", "\u00c1"], ["E", "\u00c9"], ["I", "\u00cd"], ["O", "\u00d3"], ["U", "\u00da"], ["\u0391", "\u0386"], ["\u0395", "\u0388"], ["\u0397", "\u0389"], ["\u0399", "\u038a"], ["\u039f", "\u038c"], ["\u03a5", "\u038e"], ["\u03a9", "\u038f"]
		],
		'\u02dd': [ // Hungarian Double Acute Accent
			["o", "\u0151"], ["u", "\u0171"],
			["O", "\u0150"], ["U", "\u0170"]
		],
		'\u0385': [ // Greek Dialytika + Tonos
			["\u03b9", "\u0390"], ["\u03c5", "\u03b0"]
		],
		'\u00b0': [ // Ring
			["a", "\u00e5"],
			["A", "\u00c5"]
		],
		'\u00ba': [ // Ring
			["a", "\u00e5"],
			["A", "\u00c5"]
		]
	},

	initComponent : function(options){
                Ext.ux.VirtualKeyboard.superclass.initComponent.call(this);
		
		Ext.apply(this, {
			language: this.language || 'US',
			deadKeysButtonText: this.deadKeysButtonText || 'Type accented letters',
			//deadKeysButtonTip: this.deadKeysButtonTip || 'Dead keys are used to generate accented letters',
			autoDestroy: true
		});
		
		Ext.apply(this, options);
		
		this.addEvents(
			'keypress'
		);
		
		/*this.on('beforedestroy', function(){
			this.keyboard.removeAllListeners();
			delete this.keyboard;
		}, this);*/
		
	},

	onRender: function(ct, position){
		this.initKeyboard(ct);
		Ext.ux.VirtualKeyboard.superclass.onRender.call(this, ct, position);
	},
	
	initKeyboard : function(ct){
		this.keyboardTarget.el.on('click', this.IESel, this);
		this.keyboardTarget.el.on('keyup', this.IESel, this);
		this.keyboardTarget.el.on('select', this.IESel, this);

		this.keyboard = ct.createChild({
			tag: 'div',
			cls: 'x-keyboard x-panel'
		});
		
		this.keyboard.setStyle({width: this.width || 370});

		var layouts = 0;
		for (lang in this.Languages) if (typeof this.Languages[lang] == "object") layouts++;

		var dh = Ext.DomHelper;
		
		var ktbarItems = [];

		if (this.languageSelection) {
		
			var values = [];
			for (ktype in this.Languages) {
				if (typeof this.Languages[ktype] == "object") {
					values.push([ktype, ktype]);
				}
			}

			this.languageSelector = new Ext.form.ComboBox({
                                store: values,
				forceSelection: true,
				triggerAction: 'all',
				editable: false,
				readOnly: true,
				height: 15,
				width: 100,
				value: this.language,
				listeners: {
					'select': function(combo, record) {
						this.language = record.data.value;
						this.buildKeys();
					},
					expand: function(){
						this.selectingLanguage = true;
					},
					collapse: function(){
						this.selectingLanguage = false;
					},
					scope: this
				}
			});
			ktbarItems.push(this.languageSelector);
		}
		else{
			ktbarItems.push(this.language);
		}
		ktbarItems.push('-', {
			text: this.deadKeysButtonText,
                        iconCls: 'ux-accented-icon',
			//tooltip: this.deadKeysButtonTip,
			enableToggle: true,
			listeners: {
				toggle: function(btn, pressed){
					this.deadKeysOn = pressed;
					this.keyModify("");
				},
				scope: this
			}
		});
		
		this.ktbar = new Ext.Toolbar({
			renderTo: this.keyboard,
			items: ktbarItems
		});
		
		if (!this.languageSelection){
			Ext.fly(this.ktbar.items.items[0].getEl()).setStyle({fontWeight: 'bold'});
		}
		
		var wrap = this.keyboard.createChild({
			tag: 'div',
			cls: 'x-panel-bwrap'
		});
		
		var mc = wrap.createChild({
			tag: 'div',
			cls: 'x-panel-body'
		});

		this.keysContainer = mc.createChild({
			tag: 'div'
		});

		this.buildKeys();
	},
	
	getTBar: function(){
		return this.ktbar;
	},
	
	buildKeys: function() {
		this.shift = this.capslock = this.alternate = this.dead = false;
		//this.deadKeysOn = (this.layoutDDK[this.language]) ? false : this.deadCheckbox.checked;
		
		this.keysContainer.update('');

		var dh = Ext.DomHelper;

		for (var x = 0, hasdeadKey = false, lyt; lyt = this.Languages[this.language][x++];) {
			var table = dh.append(this.keysContainer, {
				tag: 'table',
				cellSpacing: '1',
				cellPadding:'0',
				border: '0',
				cls: (lyt.length <= this.keyCenter ? 'keyboardInputCenter' : '') + ' keys',
				align: (lyt.length <= this.keyCenter ? 'center' : ''),
				html: ''
			});

			if(Ext.isIE && table.firstChild){
				table.removeChild(table.firstChild);
			}
			var tbody = dh.append(table, {tag: 'tbody'});
			var tr = dh.append(tbody, {tag: 'tr'});

			for (var y = 0, lkey; lkey = lyt[y++];) {
				if (!this.layoutDDK[this.language] && !hasdeadKey){
					for (var z = 0; z < lkey.length; z++){
						if (this.deadKey[lkey[z]]){
							hasdeadKey = true;
							break;
						}
					}
				}

			var alive = false;
			if (this.deadKeysOn){
				for (key in this.deadKey){
					if (key === lkey[0]){
						alive = true;
					}
				}
			}
			//var cls = ['x-btn', 'x-btn-center'];
			var cls = [];
			if(alive)
				cls.push('alive');
			if (lyt.length > this.keyCenter && y == lyt.length)
				cls.push('last');
				
			var td = dh.append(tr, {
				tag: 'td',
				cls: cls.join(' '),
				html: lkey[0] == " " ? "&nbsp;" : lkey[0]
			});

			if (lkey[0] == " ")
				td.id = "spacebar";

			Ext.fly(td).on('mouseover', function(event, target) { if (!Ext.fly(target).hasClass('dead') && target.firstChild.nodeValue != "\xa0") Ext.fly(target).addClass('hover'); });
			Ext.fly(td).on('mouseout', function(event, target) { if (!Ext.fly(target).hasClass('dead')) Ext.fly(target).removeClass(['hover', 'pressed']); });
			Ext.fly(td).on('mousedown', function(event, target) { if (!Ext.fly(target).hasClass('dead')) Ext.fly(target).addClass('pressed'); });
			Ext.fly(td).on('mouseup', function(event, target) { if (!Ext.fly(target).hasClass('dead') && target.firstChild.nodeValue != "\xa0") Ext.fly(target).removeClass('pressed'); });
			Ext.fly(td). swallowEvent('dblclick', true);
			
			td.modifier = lkey[1];

			switch (lkey[1]) {
				case "Caps":
				case "Shift":
				case "Alt":
				case "AltGr":
					Ext.fly(td).on('click', function(event, target) {
						this.keyModify(target.modifier);
					}, this, {stopEvent: true});
					break;
				case "Tab":
					Ext.fly(td).on('click', function(event, target) {
						this.keyInsert("\t");
					}, this, {stopEvent: true});
					break;
				case "Bksp":
					Ext.fly(td).on('click', function() {
						this.keyboardTarget.focus();
						var dom = this.keyboardTarget.el.dom;
						if (dom.setSelectionRange) {
							var srt = dom.selectionStart;
							var len = dom.selectionEnd;
							if (srt < len) srt++;
							this.keyboardTarget.setValue(dom.value.substr(0, srt - 1) + dom.value.substr(len));
							dom.setSelectionRange(srt - 1, srt - 1);
						} else if (dom.createTextRange) {
							try { this.range.select(); } catch(e) {}
							this.range = document.selection.createRange();
							if (!this.range.text.length)
								this.range.moveStart('character', -1);
							this.range.text = "";
						} else this.keyboardTarget.setValue(dom.value.substr(0, dom.value.length - 1));
						if (this.shift) this.keyModify("Shift");
						if (this.alternate) this.keyModify("AltGr");
						return true;
					}, this);
					break;
				
				case "Enter":
					//if (self.keyboardTarget.nodeName == "TEXTAREA") { this.keyInsert("\n"); } else self.VKI_close();
					Ext.fly(td).on('click', function(event, target) {
						this.keyInsert("\n");
					}, this, {stopEvent: true});
					break;
					
				default:
					Ext.fly(td).on('click', function(event, target) {
						var keyValue = target.firstChild.nodeValue;
						if(keyValue == "\xa0"){
							keyValue = " ";
						}
						if (this.deadKeysOn && this.dead) {
							if (this.dead != keyValue) {
							for (key in this.deadKey) {
								if (key == this.dead) {
								if (keyValue != " ") {
									for (var z = 0, rezzed = false, dk; dk = this.deadKey[key][z++];) {
									if (dk[0] == keyValue) {
										this.keyInsert(dk[1]);
										rezzed = true;
										break;
									}
									}
								} else {
									this.keyInsert(this.dead);
									rezzed = true;
								}
								break;
								}
							}
							} else rezzed = true;
						}
						this.dead = false;

						if (!rezzed && keyValue != "\xa0") {
							if (this.deadKeysOn) {
							for (key in this.deadKey) {
								if (key == keyValue) {
								this.dead = key;
								this.className = "dead";
								if (this.shift) this.keyModify("Shift");
								if (this.alternate) this.keyModify("AltGr");
								break;
								}
							}
							if (!this.dead) this.keyInsert(keyValue);
							} else this.keyInsert(keyValue);
						}
						this.keyModify("");
					}, this, {stopEvent: true});
					delete td;
				}
				delete tr;
				for (var z = lkey.length; z < 4; z++) lkey[z] = "\xa0";
			}
			delete table;
			delete tbody;
		}
	},
	
	keyModify: function(type){
		switch (type) {
			case "Alt":
			case "AltGr": this.alternate = !this.alternate; break;
			case "Caps": this.capslock = !this.capslock; break;
			case "Shift": this.shift = !this.shift; break;
		}
		var vchar = 0;
		if (!this.shift != !this.capslock) vchar += 1;
	
		var tables = this.keyboard.select('table.keys');
		for (var x = 0; x < tables.getCount(); x++) {
			var tds = tables.item(x).select('td');
			for (var y = 0; y < tds.getCount(); y++) {
				td = tds.item(y);
				var dead = alive = isTarget = false;
				if(!this.Languages[this.language][x]){
					//alert('stop');
				}
				
				var lkey = this.Languages[this.language][x][y];
		
				switch (lkey[1]) {
					case "Alt":
					case "AltGr":
					if (this.alternate) dead = true;
					break;
					case "Shift":
					if (this.shift) dead = true;
					break;
					case "Caps":
					if (this.capslock) dead = true;
					break;
					case "Tab":
					case "Enter":
					case "Bksp":
						break;
					default:
						var char = lkey[vchar + ((this.alternate && lkey.length == 4) ? 2 : 0)];
						if (type)
							td.update(char);
						if (this.deadKeysOn) {
							if (this.dead) {
								if (char == this.dead)
									dead = true;
								for (var z = 0; z < this.deadKey[this.dead].length; z++){
									if (char == this.deadKey[this.dead][z][0]) {
										isTarget = true;
										break;
									}
								}
							}
							for (key in this.deadKey){
								if (key === char) {
									alive = true;
									break;
								}
							}
						}
				}
				td.dom.className = (dead) ? "dead" : ((isTarget) ? "target" : ((alive) ? "alive" : ""));
				if (y == tds.getCount() - 1 && tds.getCount() > this.keyCenter) td.addClass('last');
			}
		}
	},
	
	keyInsert: function(keyValue){
		this.fireEvent('keyPress', this, keyValue);
		
		if(this.keyboardTarget){
			this.keyboardTarget.focus();
			var dom = this.keyboardTarget.el.dom;
			if (dom.setSelectionRange) {
				var srt = dom.selectionStart;
				var len = dom.selectionEnd;
				dom.value = dom.value.substr(0, srt) + keyValue + dom.value.substr(len);
				if (keyValue == "\n" && window.opera) srt++;
				dom.setSelectionRange(srt + keyValue.length, srt + keyValue.length);
			} else if (dom.createTextRange) {
				try { this.range.select(); } catch(e) {}
				this.range = document.selection.createRange();
				this.range.text = keyValue;
				this.range.collapse(true);
				this.range.select();
			} else
				this.keyboardTarget.setValue(this.keyboardTarget.getValue() + keyValue);
			if (this.shift) this.keyModify("Shift");
			if (this.alternate) this.keyModify("AltGr");
			this.keyboardTarget.focus();
		}
	},

	getXType: function(){
		return 'virtualkeyboard';
	},
	
	IESel: function (event, target){
		if (target.createTextRange){
			this.range = document.selection.createRange();
		}
	}
});

Ext.reg('virtualkeyboard', Ext.ux.VirtualKeyboard);