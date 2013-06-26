Ext.require( [ 'Ext.grid.*' ]);
txt_code = null;
txt_caption = null;
dictType = "";
Ext.onReady(function() {
	dictType = $('#hid_type').val();
	if (dictType === '') {
		alert('error');
	}
	LoadUI();
	LoadGrid();
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
							}, {
								border : false,
								region : 'center',
								xtype : 'form',
								layout : 'table',
								defaultType : 'textfield',
								fieldDefaults : {
									labelWidth : 50,
									labelAlign : 'right'
								},
								items : [ {
									id : 'txt_code',
									fieldLabel : '代码',
									allowBlank : false
								}, {
									id : 'txt_caption',
									fieldLabel : '名称',
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
	txt_code = Ext.ComponentManager.get('txt_code');
	txt_caption = Ext.ComponentManager.get('txt_caption');
});

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
		fields : [ 'id', 'code', 'type', 'caption' ]
	});
	gridStore = Ext.create('Ext.data.Store', {
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
				type : dictType
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
		}, 
//		{
//			text : 'id',
//			width : 120,
//			dataIndex : 'id'
//		},
		{
			text : '代码',
			width : 120,
			dataIndex : 'code'
		},
//		{
//			text : '类型',
//			width : 200,
//			dataIndex : 'type'
//		},
		{
			text : '名称',
			width : 120,
			flex : 1,
			dataIndex : 'caption'
		}

		],

		columnLines : true,
		enableLocking : true,

		iconCls : 'icon-grid',
		bbar : {
			xtype : 'pagingtoolbar',
			store : gridStore,
			displayInfo : true
		},
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
				txt_code.setValue(data.code);
				txt_caption.setValue(data.caption);
			}
		}

	});

};

Set_formState = function(v) {
	txt_code.setDisabled(!v);
	txt_caption.setDisabled(!v);
};
Clear_form = function() {
	txt_code.setValue('');
	txt_caption.setValue('');
};
save = function() {
	var mydata = {
		id : $("#hid_id").val(),
		code : txt_code.getValue(),
		caption : txt_caption.getValue(),
		type : dictType
	};
	$.ajax( {
		type : "POST",
		url : "./json/wptj_dict.php?op=save",
		data : mydata,
		success : function(msg) {
			if (msg.result==true) {
				gridStore.reload();
				alert("信息: 保存成功!");
			} else {
				alert("错误信息: " + msg.result);
			}
		}
	});
};
del = function() {
	Ext.MessageBox.confirm('确认删除', '您确认要删除此条信息?', function(re) {
		if (re == "yes") {
			$.ajax( {
				type : "POST",
				url : "./json/wptj_dict.php?op=delete",
				data : {
					id : $("#hid_id").val()
				},
				success : function(msg) {
					if (msg.result==true) {
						gridStore.reload();
						alert("信息: 删除成功!");
					} else {
						alert("错误信息: " + msg.result);
					}
				}

			});
		}
	});
};