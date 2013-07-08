Ext.require(['Ext.grid.*']);

txt_shop = null;
txt_object = null;
txt_shop_s = null;
txt_object_s = null;
txt_price = null;
txt_sdate = null;
txt_edate = null;
txt_postdate=null;
txt_remark = null;
//锁定快捷键
isLock=false;
Ext.onReady(function () {
	myMask = new Ext.LoadMask($('body').get(0), {
			msg : "请等待，正在执行任务..."
		});
	LoadUI();
	LoadGrid();
	Ext.create(
		'Ext.Viewport', {
		layout : 'border',
		border : false,
		items : [{
				border : false,
				region : 'north',
				height : 180,
				layout : 'anchor',
				margin : '5 5 0 5',
				items : [{
						border : false,
						region : 'north',
						layout : 'table',
						height : 80,
						items : [
							ext_btnAdd,
							ext_btnModify,
							ext_btnSave,
							ext_btnDelete, {
								margin : '15 0 0 30',
								id : 'txt_seach',
								labelWidth : 50,
								xtype : 'textfield',
								labelAlign : 'right',
								fieldLabel : '关键字'
							}, {
								margin : '15 0 0 0',
								xtype : 'button',
								text : '搜索',
								handler : function () {
									gridStore.proxy
									.setExtraParam('tj', Ext.getCmp('txt_seach').getValue());
									gridStore
									.loadPage(1);
								}
							}
						]
					}, {
						border : false,
						region : 'center',
						xtype : 'form',
						layout : {
							type : 'table',
							columns : 4
						},
						defaultType : 'textfield',
						fieldDefaults : {
							labelWidth : 80,
							labelAlign : 'right'
						},
						items : [{
								id : 'txt_shop',
								fieldLabel : '店铺代码',
								xtype : 'triggerfield',
								triggerCls : Ext.baseCSSPrefix + 'form-search-trigger',
								onTriggerClick : function () {
									isLock=true;
									popWin(
										'./DictSelect.php',
										'shop',
										txt_shop,
										txt_shop_s,
										false,
										this
										.getValue(), function () {
										isLock=false;
										Ext.getCmp('txt_object').focus(true);
									});
								},
								listeners : {
									specialkey : function (field, e) {
										if(isLock){
											return;
										}
										if (e.getKey() == Ext.EventObject.ENTER) {
											this.onTriggerClick();
										}
									}
								}
							}, {
								id : 'txt_shop_s',
								fieldLabel : '店铺名称',
								allowBlank : false,
								readOnly : true
							}, {
								id : 'txt_object',
								fieldLabel : '商品代码',
								xtype : 'triggerfield',
								triggerCls : Ext.baseCSSPrefix + 'form-search-trigger',
								code : '',
								onTriggerClick : function () {
									isLock=true;
									popWin(
										'./DictSelect.php',
										'object',
										txt_object,
										txt_object_s,
										false,
										this
										.getValue(), function () {
										isLock=false;
										Ext.getCmp('txt_price').focus(true);
									});
								},
								listeners : {
									specialkey : function (field, e) {
										if(isLock){
											return;
										}
										if (e.getKey() == Ext.EventObject.ENTER) {
											this.onTriggerClick();
										}
									}
								}

							}, {
								id : 'txt_object_s',
								fieldLabel : '商品名称',
								allowBlank : false,
								readOnly : true
							}, {
								id : 'txt_price',
								xtype : 'numberfield',
								fieldLabel : '总额',
								minValue : 0,
								hideTrigger : true,
								allowBlank : false,
								keyNavEnabled : false,
								mouseWheelEnabled : false,
								listeners : {
									specialkey : function (field, e) {
										if (e.getKey() == Ext.EventObject.ENTER) {
											Ext.getCmp('txt_sdate').focus(true);
										}
									}
								}

							}, {
								id : 'txt_sdate',
								fieldLabel : '开始时间',
								xtype : 'datefield',
								format : 'Y-m-d',
								allowBlank : false,
								listeners : {
									specialkey : function (field, e) {
										if (e.getKey() == e.ENTER) {
											Ext.getCmp('txt_edate').focus(true);
										}
									}
								}
							}, {
								id : 'txt_edate',
								fieldLabel : '结束时间',
								xtype : 'datefield',
								format : 'Y-m-d',
								allowBlank : false,
								listeners : {
									specialkey : function (field, e) {
										if (e.getKey() == Ext.EventObject.ENTER) {
											Ext.getCmp('txt_postdate').focus(true);
										}
									}
								}

							}, {
								id : 'txt_postdate',
								fieldLabel : '报销时间',
								xtype : 'datefield',
								format : 'Y-m-d',
								allowBlank : false,
								listeners : {
									specialkey : function (field, e) {
										if (e.getKey() == Ext.EventObject.ENTER) {
											Ext.getCmp('txt_remark').focus(true);
										}
									}
								}

							}, {
								id : 'txt_remark',
								name : 'message',
								fieldLabel : '备注',
								width : 470,
								colspan : 2,
								listeners : {
									specialkey : function (field, e) {
										if (e.getKey() == Ext.EventObject.ENTER) {
											ext_btnSave.fireEvent('click');
										}
									}
								}
							}
						]

					}

				]
			}, {
				region : 'center',
				margin : '5 5 0 5',
				layout : 'fit',
				items : [dataGrid]
			}
		]
	});
	txt_shop = Ext.getCmp('txt_shop');
	txt_shop_s = Ext.getCmp('txt_shop_s');
	txt_object = Ext.getCmp('txt_object');
	txt_object_s = Ext.getCmp('txt_object_s');
	txt_price = Ext.getCmp('txt_price');
	txt_sdate = Ext.getCmp('txt_sdate');
	txt_edate = Ext.getCmp('txt_edate');
	txt_postdate = Ext.getCmp('txt_postdate');
	txt_remark = Ext.getCmp('txt_remark');
});

LoadUI = function () {

	ext_btnAdd = Ext.create('Ext.Button', {
			text : '添加',
			icon : '../image/btn/add.png',
			width : 100,
			margin : '15 0 0 30',
			handler : function () {
				ext_btnAdd.setDisabled(true);
				ext_btnModify.setDisabled(true);
				ext_btnSave.setDisabled(false);
				ext_btnDelete.setDisabled(true);
				$("#hid_id").val("");
				Set_formState(true);
				Clear_form();
				Ext.getCmp('txt_shop').focus(true);
			}
		});
	ext_btnModify = Ext.create('Ext.Button', {
			text : '修改',
			icon : '../image/btn/modify.png',
			width : 100,
			margin : '15 0 0 5',
			handler : function () {
				if (!check_user()) {
					alert('不能操作此条数据');
					return;
				}
				if (ext_btnModify.getText() == "修改") {
					ext_btnSave.setDisabled(false);
					ext_btnModify.setText("取消修改");
					Set_formState(true);
				} else {
					ext_btnSave.setDisabled(true);
					ext_btnModify.setText("修改");
					Set_formState(false);

				}
			}
		});
	ext_btnSave = Ext.create('Ext.Button', {
			text : '保存',
			icon : '../image/btn/save.png',
			width : 100,
			margin : '15 0 0 5',
			listeners : {
				"click" : function () {

					if (!check_save()) {
						alert("数据项目填写不全！");
						return;
					}
					ext_btnAdd.setDisabled(false);
					ext_btnModify.setDisabled(false);
					ext_btnSave.setDisabled(true);
					ext_btnDelete.setDisabled(false);
					save();
				}
			}
		});
	ext_btnDelete = Ext.create('Ext.Button', {
			text : '删除',
			icon : '../image/btn/del.png',
			width : 100,
			margin : '15 0 0 5',
			handler : function () {
				if (!check_user()) {
					alert('不能操作此条数据');
					return;
				}
				del();
			}
		});

};

LoadGrid = function () {

	Ext.define('gridModel', {
		extend : 'Ext.data.Model',
		fields : ['id', 'sdate', 'edate','postdate', {
				name : 'price',
				sortType : 'asFloat'
			}, 'shop', 'object', 'createname', 'shop_s', 'object_s', 'remark', 'createtimestamp']
	});
	gridStore = Ext.create('Ext.data.Store', {
			buffered : false,
			pageSize : 50,
			proxy : {
				type : "ajax",
				url : "./json/wptj_data.php",
				reader : {
					root : 'root',
					totalProperty : 'count'
				},
				extraParams : {
					op : 'select'
				}
			},
			model : 'gridModel',
			autoLoad : true,
			listeners : {
				'load' : function (s, records, successful, eOpts) {
					Set_formState(false);
					if (records.length > 0) {

						dataGrid.getSelectionModel().select(0);
						dataGrid.fireEventArgs("itemclick", [null, records[0],
								null, 0]);
					} else {
						Clear_form();
						ext_btnAdd.setDisabled(false);
						ext_btnModify.setDisabled(true);
						ext_btnSave.setDisabled(true);
						ext_btnDelete.setDisabled(true);
					}
				}
			}
		});

	dataGrid = Ext.create('Ext.grid.Panel', {
			store : gridStore,
			sortableColumns : false,
			'columns' : [{
					xtype : 'rownumberer',
					width : 30,
					sortable : false
				},
				// {
				// text : 'id',
				// width : 120,
				// dataIndex : 'id'
				// },
				{
					text : '店铺代码',
					width : 120,
					dataIndex : 'shop'
				}, {
					text : '店铺',
					width : 200,
					dataIndex : 'shop_s'
				}, {
					text : '物品代码',
					width : 100,
					dataIndex : 'object'
				}, {
					text : '物品',
					width : 200,
					dataIndex : 'object_s'
				}, {
					text : '总额',
					width : 120,
					dataIndex : 'price'
				}, {
					text : '开始时间',
					width : 120,
					dataIndex : 'sdate'
				}, {
					text : '结束时间',
					width : 120,
					dataIndex : 'edate'
				}, {
					text : '报销时间',
					width : 120,
					dataIndex : 'postdate'
				}, {
					text : '备注',
					width : 120,
					// flex : 1,
					dataIndex : 'remark'
				}, {
					text : '创建人',
					width : 120,
					dataIndex : 'createname'
				}, {
					text : '创建时间',
					width : 220,
					dataIndex : 'createtimestamp'
				}
			],

			columnLines : true,
			enableLocking : true,
			bbar : {
				xtype : 'pagingtoolbar',
				store : gridStore,
				displayInfo : true
			},
			iconCls : 'icon-grid',
			margin : '0 0 20 0',
			header : false,
			autoScroll : true,
			listeners : {
				'itemclick' : function (me, record, item, index, e, eOpts) {
					Set_formState(false);
					ext_btnModify.setText("修改");
					ext_btnAdd.setDisabled(false);
					ext_btnModify.setDisabled(false);
					ext_btnSave.setDisabled(true);
					ext_btnDelete.setDisabled(false);

					var data = record.data;
					$("#hid_id").val(data.id);

					txt_shop.setValue(data.shop);
					txt_shop_s.setValue(data.shop_s);
					txt_object.setValue(data.object);
					txt_object_s.setValue(data.object_s);
					txt_object.code = data.object;
					txt_price.setValue(data.price);
					txt_sdate.setValue(data.sdate);
					txt_edate.setValue(data.edate);
					txt_postdate.setValue(data.postdate);
					txt_remark.setValue(data.remark);
				}
			}

		});

};

Set_formState = function (v) {
	txt_shop.setDisabled(!v);
	txt_object.setDisabled(!v);
	txt_price.setDisabled(!v);
	txt_sdate.setDisabled(!v);
	txt_edate.setDisabled(!v);
	txt_postdate.setDisabled(!v);
	txt_remark.setDisabled(!v);
	
};
Clear_form = function () {
	txt_shop.setValue('');
	txt_object.setValue('');
	txt_shop_s.setValue('');
	txt_object_s.setValue('');
	txt_price.setValue('');
	txt_sdate.setValue('');
	txt_edate.setValue('');
	txt_postdate.setValue('');
	txt_remark.setValue('');
};
// 检查当前用户是否和当前记录创建人匹配
check_user = function () {
	var selModel = dataGrid.getSelectionModel();
	if (selModel.hasSelection()) {
		var selected = selModel.getSelection();
		var r = selected[0].data.createname;
		var h = $("#username").val();
		if (r == h || h == 'admin' || r == '') {
			return true;
		}
	}
	return false;
};
check_save = function () {

	if (txt_sdate.getValue() && txt_edate.getValue() && txt_postdate.getValue() && txt_price.getValue()
		 && txt_shop_s.getValue() && txt_object_s.getValue())
		return true;
	else
		return false;

}

save = function () {
	myMask.show();
	var mydata = {
		id : $("#hid_id").val(),
		// 'id', 'sdate', 'edate','price','shop','object','createname'
		sdate : txt_sdate.getValue().format("yyyy-MM-dd"),
		edate : txt_edate.getValue().format("yyyy-MM-dd"),
		price : txt_price.getValue(),
		shop : txt_shop.getValue(),
		object : txt_object.getValue(),
		postdate:txt_postdate.getValue().format("yyyy-MM-dd"),
		remark : txt_remark.getValue()

	};

	$.ajax({
		type : "POST",
		url : "./json/wptj_data.php?op=save",
		data : mydata,
		success : function (msg) {
			if (msg.result == true) {
				gridStore.reload();
				alert("信息: 保存成功!");
			} else {
				alert("错误信息: " + msg.result);
			}
			myMask.hide();
		}
	});
};
del = function () {
	Ext.MessageBox.confirm('确认删除', '您确认要删除此条信息?', function (re) {
		myMask.show();
		if (re == "yes") {
			$.ajax({
				type : "POST",
				url : "./json/wptj_data.php?op=delete",
				data : {
					id : $("#hid_id").val()
				},
				success : function (msg) {
					if (msg.result == true) {
						gridStore.reload();
						alert("信息: 删除成功!");
					} else {
						alert("错误信息: " + msg.result);
					}
					myMask.hide();
				}

			});
		}
	});
};
