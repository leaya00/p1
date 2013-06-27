Ext.require([ 'Ext.grid.*' ]);

txt_shop = null;
txt_object = null;
txt_price = null;
txt_sdate = null;
txt_edate = null;
Ext.onReady(function() {
	myMask = new Ext.LoadMask($('body').get(0), {
		msg : "请等待，正在执行任务..."
	});
	// myMask.show();
	// myMask.hide();
	LoadUI();
	LoadGrid();
	LoadDict();
	Ext.create('Ext.Viewport', {
		layout : 'border',
		border : false,
		items : [
				{
					border : false,
					region : 'north',
					height : 150,
					layout : 'anchor',
					margin : '5 5 0 5',
					items : [
							{
								border : false,
								region : 'north',
								height : 80,
								items : [ ext_btnAdd, ext_btnModify,
										ext_btnSave, ext_btnDelete ]
							},
							{
								border : false,
								region : 'center',
								xtype : 'form',
								layout : {
									type : 'table',
									columns : 3
								},
								defaultType : 'textfield',
								fieldDefaults : {
									labelWidth : 80,
									labelAlign : 'right'
								},
								items : [
										{
											id : 'txt_shop',
											fieldLabel : '店铺',
											xtype : 'triggerfield',
											editable : false,
											triggerCls : Ext.baseCSSPrefix
													+ 'form-search-trigger',
											code : '',
											onTriggerClick : function() {
												popWin('./DictSelect.php',
														'shop',this);
											}

										},
										{
											id : 'txt_object',
											fieldLabel : '商品',
											xtype : 'triggerfield',
											editable : false,
											triggerCls : Ext.baseCSSPrefix
													+ 'form-search-trigger',
											code : '',
											onTriggerClick : function() {
												popWin('./DictSelect.php',
														'object',this);
											}

										}, {
											id : 'txt_price',
											xtype : 'numberfield',
											fieldLabel : '总额',
											minValue : 0, // prevents negative
											// numbers
											// Remove spinner buttons, and arrow
											// key and mouse wheel listeners
											hideTrigger : true,
											keyNavEnabled : false,
											mouseWheelEnabled : false

										}, {
											id : 'txt_sdate',
											fieldLabel : '开始时间',
											xtype : 'datefield',
											format : 'Y-m-d',
											allowBlank : false
										}, {
											id : 'txt_edate',
											fieldLabel : '结束时间',
											xtype : 'datefield',
											format : 'Y-m-d',
											allowBlank : false

										} ]

							}

					]
				}, {
					region : 'center',
					margin : '5 5 0 5',
					layout : 'fit',
					items : [ dataGrid ]
				} ]
	});
	txt_shop = Ext.getCmp('txt_shop');
	txt_object = Ext.getCmp('txt_object');
	txt_price = Ext.getCmp('txt_price');
	txt_sdate = Ext.getCmp('txt_sdate');
	txt_edate = Ext.getCmp('txt_edate');
});
LoadDict = function() {
	Ext.define('dictModel', {
		extend : 'Ext.data.Model',
		fields : [ 'id', 'code', 'type', 'caption' ]
	});
	shopStore = Ext.create('Ext.data.Store', {
		buffered : false,
		pageSize : 300,
		proxy : {
			type : "ajax",
			url : "./json/wptj_dict.php",
			reader : {
				root : 'root',
				totalProperty : 'count'
			},
			extraParams : {
				op : 'select',
				type : 'shop'
			}
		},
		model : 'dictModel',
		autoLoad : true
	// remoteFilter: true
	});
	objectStore = Ext.create('Ext.data.Store', {
		buffered : false,
		pageSize : 300,
		proxy : {
			type : "ajax",
			url : "./json/wptj_dict.php",
			reader : {
				root : 'root',
				totalProperty : 'count'
			},
			extraParams : {
				op : 'select',
				type : 'object'
			}
		},
		model : 'dictModel',
		autoLoad : true

	});

};
LoadUI = function() {

	ext_btnAdd = Ext.create('Ext.Button', {
		text : '添加',
		icon : '../image/btn/add.png',
		width : 100,
		margin : '15 0 0 30',
		handler : function() {
			ext_btnAdd.setDisabled(true);
			ext_btnModify.setDisabled(true);
			ext_btnSave.setDisabled(false);
			ext_btnDelete.setDisabled(true);
			$("#hid_id").val("");
			Set_formState(true);
			Clear_form();
		}
	});
	ext_btnModify = Ext.create('Ext.Button', {
		text : '修改',
		icon : '../image/btn/modify.png',
		width : 100,
		margin : '15 0 0 5',
		handler : function() {
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
		handler : function() {
			ext_btnAdd.setDisabled(false);
			ext_btnModify.setDisabled(false);
			ext_btnSave.setDisabled(true);
			ext_btnDelete.setDisabled(false);
			save();
		}
	});
	ext_btnDelete = Ext.create('Ext.Button', {
		text : '删除',
		icon : '../image/btn/del.png',
		width : 100,
		margin : '15 0 0 5',
		handler : function() {
			del();
		}
	});

};

LoadGrid = function() {

	Ext.define('gridModel', {
		extend : 'Ext.data.Model',
		fields : [ 'id', 'sdate', 'edate', 'price', 'shop', 'object',
				'createname', 'shop_s', 'object_s' ]
	});
	gridStore = Ext.create('Ext.data.Store', {
		buffered : false,
		pageSize : 300,
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
			'load' : function(s, records, successful, eOpts) {
				Set_formState(false);
				if (records.length > 0) {

					dataGrid.getSelectionModel().select(0);
					dataGrid.fireEventArgs("itemclick", [ null, records[0],
							null, 0 ]);
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
		'columns' : [ {
			xtype : 'rownumberer',
			width : 30,
			sortable : false
		}, {
			text : 'id',
			width : 120,
			dataIndex : 'id'
		}, {
			text : '店铺',
			width : 120,
			dataIndex : 'shop_s'
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
			text : '创建人',
			width : 120,
			flex : 1,
			dataIndex : 'createname'
		} ],

		columnLines : true,
		enableLocking : true,

		iconCls : 'icon-grid',
		margin : '0 0 20 0',
		header : false,
		autoScroll : true,
		listeners : {
			'itemclick' : function(me, record, item, index, e, eOpts) {
				Set_formState(false);
				ext_btnModify.setText("修改");
				ext_btnAdd.setDisabled(false);
				ext_btnModify.setDisabled(false);
				ext_btnSave.setDisabled(true);
				ext_btnDelete.setDisabled(false);

				var data = record.data;
				$("#hid_id").val(data.id);

				txt_shop.setValue(data.shop_s);
				txt_shop.code = data.shop;
				txt_object.setValue(data.object_s);
				txt_object.code = data.object;
				txt_price.setValue(data.price);
				txt_sdate.setValue(data.sdate);
				txt_edate.setValue(data.edate);
			}
		}

	});

};

Set_formState = function(v) {
	txt_shop.setDisabled(!v);
	txt_object.setDisabled(!v);
	txt_price.setDisabled(!v);
	txt_sdate.setDisabled(!v);
	txt_edate.setDisabled(!v);
};
Clear_form = function() {
	txt_shop.setValue('');
	txt_object.setValue('');
	txt_price.setValue('');
	txt_sdate.setValue('');
	txt_edate.setValue('');
};
save = function() {
	myMask.show();
	var mydata = {
		id : $("#hid_id").val(),
		// 'id', 'sdate', 'edate','price','shop','object','createname'
		sdate : txt_sdate.getValue().format("yyyy-MM-dd"),
		edate : txt_edate.getValue().format("yyyy-MM-dd"),
		price : txt_price.getValue(),
		shop : txt_shop.code,
		object : txt_object.code,
		createname : 'test'
	};
	$.ajax({
		type : "POST",
		url : "./json/wptj_data.php?op=save",
		data : mydata,
		success : function(msg) {
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
del = function() {
	Ext.MessageBox.confirm('确认删除', '您确认要删除此条信息?', function(re) {
		myMask.show();
		if (re == "yes") {
			$.ajax({
				type : "POST",
				url : "./json/wptj_data.php?op=delete",
				data : {
					id : $("#hid_id").val()
				},
				success : function(msg) {
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

