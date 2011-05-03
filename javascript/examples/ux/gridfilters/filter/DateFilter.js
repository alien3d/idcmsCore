Ext.ux.grid.filter.DateFilter=Ext.extend(Ext.ux.grid.filter.Filter,{afterText:'After',beforeText:'Before',compareMap:{before:'lt',after:'gt',on:'eq'},dateFormat:'m/d/Y',menuItems:['before','after','-','on'],menuItemCfgs:{selectOnFocus:true,width:125},onText:'On',pickerOpts:{},init:function(config){var menuCfg,i,len,item,cfg,Cls;menuCfg=Ext.apply(this.pickerOpts,{minDate:this.minDate,maxDate:this.maxDate,format:this.dateFormat,listeners:{scope:this,select:this.onMenuSelect}});this.fields={};for(i=0,len=this.menuItems.length;i<len;i++){item=this.menuItems[i];if(item!=='-'){cfg={itemId:'range-'+item,text:this[item+'Text'],menu:new Ext.menu.DateMenu(Ext.apply(menuCfg,{itemId:item})),listeners:{scope:this,checkchange:this.onCheckChange}};Cls=Ext.menu.CheckItem;item=this.fields[item]=new Cls(cfg);}this.menu.add(item);}},onCheckChange:function(){this.setActive(this.isActivatable());this.fireEvent('update',this);},onInputKeyUp:function(field,e){var k=e.getKey();if(k==e.RETURN&&field.isValid()){e.stopEvent();this.menu.hide(true);return;}},onMenuSelect:function(menuItem,value,picker){var fields=this.fields,field=this.fields[menuItem.itemId];field.setChecked(true);if(field==fields.on){fields.before.setChecked(false,true);fields.after.setChecked(false,true);}else{fields.on.setChecked(false,true);if(field==fields.after&&fields.before.menu.picker.value<value){fields.before.setChecked(false,true);}else if(field==fields.before&&fields.after.menu.picker.value>value){fields.after.setChecked(false,true);}}this.fireEvent('update',this);},getValue:function(){var key,result={};for(key in this.fields){if(this.fields[key].checked){result[key]=this.fields[key].menu.picker.getValue();}}return result;},setValue:function(value,preserve){var key;for(key in this.fields){if(value[key]){this.fields[key].menu.picker.setValue(value[key]);this.fields[key].setChecked(true);}else if(!preserve){this.fields[key].setChecked(false);}}this.fireEvent('update',this);},isActivatable:function(){var key;for(key in this.fields){if(this.fields[key].checked){return true;}}return false;},getSerialArgs:function(){var args=[];for(var key in this.fields){if(this.fields[key].checked){args.push({type:'date',comparison:this.compareMap[key],value:this.getFieldValue(key).format(this.dateFormat)});}}return args;},getFieldValue:function(item){return this.fields[item].menu.picker.getValue();},getPicker:function(item){return this.fields[item].menu.picker;},validateRecord:function(record){var key,pickerValue,val=record.get(this.dataIndex);if(!Ext.isDate(val)){return false;}val=val.clearTime(true).getTime();for(key in this.fields){if(this.fields[key].checked){pickerValue=this.getFieldValue(key).clearTime(true).getTime();if(key=='before'&&pickerValue<=val){return false;}if(key=='after'&&pickerValue>=val){return false;}if(key=='on'&&pickerValue!=val){return false;}}}return true;}});