Ext.require(['Ext.grid.*']);
txt_sdate = null;
txt_edate = null;
txt_shop = null;
txt_object = null;
txt_shop_s = null;
txt_object_s = null;
Ext.onReady(function () {

	LoadUI();
	LoadGrid();
	Ext.create('Ext.Viewport', {
		layout : 'border',
		border : false,
		items : [{
				border : false,
				region : 'north',
				height : 100,
				layout : 'absolute',
				margin : '5 5 0 5',
				items : [{
						id : 'txt_shop_s',
						fieldLabel : '店铺名称',
						labelWidth : 70,
						labelAlign : 'right',
						width : 220,
						xtype : 'textfield',
						x : 5,
						y : 15,
						readOnly : true
					}, {

						labelWidth : 70,
						labelAlign : 'right',
						width : 220,
						x : 5,
						y : 50,
						id : 'txt_shop',
						fieldLabel : '店铺代码',
						xtype : 'triggerfield',
						triggerCls : Ext.baseCSSPrefix + 'form-search-trigger',
						code : '',
						onTriggerClick : function () {
							popWin('./DictSelect.php', 'shop', txt_shop, txt_shop_s, true, this.getValue());
						},
						listeners : {
							specialkey : function (field, e) {
								if (e.getKey() == Ext.EventObject.ENTER) {
									this.onTriggerClick();
								}
							}
						}
					}, {
						id : 'txt_object_s',
						fieldLabel : '商品名称',
						labelWidth : 70,
						labelAlign : 'right',
						width : 220,
						xtype : 'textfield',
						x : 225,
						y : 15,
						readOnly : true
					}, {
						labelWidth : 70,
						labelAlign : 'right',
						width : 220,
						x : 225,
						y : 50,
						id : 'txt_object',
						fieldLabel : '商品代码',
						xtype : 'triggerfield',
						triggerCls : Ext.baseCSSPrefix + 'form-search-trigger',
						code : '',
						onTriggerClick : function () {
							popWin('./DictSelect.php', 'object', txt_object, txt_object_s, true, this.getValue());
						},
						listeners : {
							specialkey : function (field, e) {
								if (e.getKey() == Ext.EventObject.ENTER) {
									this.onTriggerClick();
								}
							}
						}
					}, {
						id : 'txt_sdate',
						x : 440,
						y : 15,
						labelWidth : 70,
						labelAlign : 'right',
						fieldLabel : '起止时间',
						xtype : 'datefield',
						format : 'Y-m-d',
						allowBlank : false
					}, {
						id : 'txt_edate',
						x : 440,
						y : 50,
						labelWidth : 70,
						labelAlign : 'right',
						fieldLabel : '截止时间',
						xtype : 'datefield',
						format : 'Y-m-d',
						allowBlank : false
					}, ext_btnFind,ext_btnExport

				]
			}, {
				region : 'center',
				margin : '5 5 0 5',
				layout : 'fit',
				items : [dataGrid]
			}
		]
	});
	txt_sdate = Ext.getCmp('txt_sdate');
	txt_edate = Ext.getCmp('txt_edate');
	txt_shop = Ext.getCmp('txt_shop');
	txt_object = Ext.getCmp('txt_object');
	txt_shop_s = Ext.getCmp('txt_shop_s');
	txt_object_s = Ext.getCmp('txt_object_s');
	//设置初始值
	v = new Date();
	v.setDate(1);
	txt_sdate.setValue(v);
	v.setMonth(v.getMonth() + 1);
	v.setDate(0);
	txt_edate.setValue(v);
});

LoadUI = function () {

	ext_btnFind = Ext.create('Ext.Button', {
			text : '查询',
			icon : '../image/btn/find.png',
			width : 100,
			x : 705,
			y : 15,
			handler : function () {
				try {
					gridStore.proxy.setExtraParam('report', 'report2');
					gridStore.proxy.setExtraParam('shop', txt_shop.getValue());
					gridStore.proxy.setExtraParam('object', txt_object.getValue());
					gridStore.proxy.setExtraParam('sdate', txt_sdate.getValue().format("yyyy-MM-dd"));
					gridStore.proxy.setExtraParam('edate', txt_edate.getValue().format("yyyy-MM-dd"));
					gridStore.reload();
				} catch (e) {
					alert("条件设置错误!");
				}
			}
		});
		ext_btnExport = Ext.create('Ext.Button', {
			text : '导出',
			icon : '../image/btn/export.png',
			width : 100,
			x : 845,
			y : 15,
			handler : function () {

				try {
					$('#hid_report').val('report2');
					$('#hid_start').val(0);
					$('#hid_limit').val(10000);
					$('#hid_shop').val(txt_shop.getValue());
					$('#hid_object').val(txt_object.getValue());
					$('#hid_sdate').val(txt_sdate.getValue().format("yyyy-MM-dd"));
					$('#hid_edate').val(txt_edate.getValue().format("yyyy-MM-dd"));
					$('#exportform').submit();

				} catch (e) {
					alert("条件设置错误!");
				}
			}
		});
};

LoadGrid = function () {
	// id,sdate, edate,
	// price,sumday,nowday,nowprice,lostday,lostprice,shop,object
	Ext.define('gridModel', {
		extend : 'Ext.data.Model',
		fields : ['id', 'sdate', 'edate', 'price', 'sumday', 'nowday',
			'nowprice', 'shop', 'object', 'shop_s', 'object_s']
	});
	gridStore = Ext.create('Ext.data.Store', {
			buffered : false,
			pageSize : 25,
			proxy : {
				type : "ajax",
				actionMethods : 'post',
				url : "./json/wptj_report.php",
				reader : {
					root : 'root',
					totalProperty : 'count'
				},
				extraParams : {
					report : 'report2',
					sdate : '2013-06-21',
					edate : '2013-06-21'
				}
			},
			model : 'gridModel',
			autoLoad : false
		});

	dataGrid = Ext.create('Ext.grid.Panel', {
			store : gridStore,
			features : [{
					ftype : 'summary',
					dock : 'bottom'
				}
			],
			sortableColumns : false,
			'columns' : [{
					xtype : 'rownumberer',
					width : 30,
					sortable : false,
					summaryRenderer : function (value) {
						return '合计&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
					}
				}, {
					text : '店铺代码',
					width : 70,
					dataIndex : 'shop'
				}, {
					text : '店铺名称',
					//			flex : 1,
					width : 200,
					dataIndex : 'shop_s'
				}, {
					text : '物品代码',
					width : 70,
					dataIndex : 'object'
				}, {
					text : '物品名称',
					width : 200,
					dataIndex : 'object_s'
				}, {
					text : '总金额',
					width : 100,
					dataIndex : 'price',
					summaryRenderer : function (value) {
						if (gridStore.proxy.reader.jsonData) {
							return gridStore.proxy.reader.jsonData.price_sum;
						}
						return 0;
					}
				}, {
					text : '摊销起始日期',
					width : 120,
					dataIndex : 'sdate'
				}, {
					text : '摊销截止日期',
					width : 120,
					dataIndex : 'edate'
				}, {
					text : '总摊销天数',
					width : 100,
					dataIndex : 'sumday'
				}, {
					text : '本期摊销天数',
					width : 120,
					dataIndex : 'nowday'
				}, {
					text : '本期摊销金额',
					width : 120,
					dataIndex : 'nowprice',
					summaryRenderer : function (value) {
						if (gridStore.proxy.reader.jsonData) {
							return gridStore.proxy.reader.jsonData.nowprice_sum;
						}
						return 0;
					}
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
			header : false,
			autoScroll : true

		});

};
