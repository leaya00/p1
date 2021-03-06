Ext.require( [ 'Ext.grid.*' ]);
txt_date = null;
txt_shop = null;
txt_object = null;
txt_shop_s = null;
txt_object_s = null;
txt_txtj = null;
Ext
		.onReady(function() {

			LoadUI();
			LoadGrid();
			var tjstates = Ext.create('Ext.data.Store', {
				fields : [ 'value', 'caption' ],
				data : [ {
					"value" : "tx1",
					"caption" : "未摊销完"
				}, {
					"value" : "tx2",
					"caption" : "已摊销完"
				} 
				, {
					"value" : "tx3",
					"caption" : "全部"
				}]
			});
			Ext
					.create(
							'Ext.Viewport',
							{
								layout : 'border',
								border : false,
								items : [
										{
											border : false,
											region : 'north',
											height : 100,
											layout : 'absolute',
											margin : '5 5 0 5',
											items : [
													{
														id : 'txt_shop_s',
														fieldLabel : '店铺名称',
														labelWidth : 70,
														labelAlign : 'right',
														width : 220,
														xtype : 'textfield',
														x : 5,
														y : 15,
														readOnly : true
													},
													{

														labelWidth : 70,
														labelAlign : 'right',
														width : 220,
														x : 5,
														y : 45,
														id : 'txt_shop',
														fieldLabel : '店铺代码',
														xtype : 'triggerfield',
														triggerCls : Ext.baseCSSPrefix + 'form-search-trigger',
														code : '',
														onTriggerClick : function() {
															popWin(
																	'./DictSelect.php',
																	'shop',
																	txt_shop,
																	txt_shop_s,
																	true,
																	this
																			.getValue());
														},
														listeners : {
															specialkey : function(
																	field, e) {
																if (e.getKey() == Ext.EventObject.ENTER) {
																	this
																			.onTriggerClick();
																}
															}
														}

													},
													{
														id : 'txt_object_s',
														fieldLabel : '商品名称',
														labelWidth : 70,
														labelAlign : 'right',
														width : 220,
														xtype : 'textfield',
														x : 225,
														y : 15,
														readOnly : true
													},
													{
														labelWidth : 70,
														labelAlign : 'right',
														width : 220,
														x : 225,
														y : 45,
														id : 'txt_object',
														fieldLabel : '商品代码',
														xtype : 'triggerfield',
														triggerCls : Ext.baseCSSPrefix + 'form-search-trigger',
														code : '',
														onTriggerClick : function() {
															popWin(
																	'./DictSelect.php',
																	'object',
																	txt_object,
																	txt_object_s,
																	true,
																	this
																			.getValue());
														},
														listeners : {
															specialkey : function(
																	field, e) {
																if (e.getKey() == Ext.EventObject.ENTER) {
																	this
																			.onTriggerClick();
																}
															}
														}

													},
													{
														id : 'txt_date',
														x : 460,
														y : 15,
														labelAlign : 'right',
														fieldLabel : '报表截止时间',
														xtype : 'datefield',
														format : 'Y-m-d',
														allowBlank : false
													},
													{
														xtype : 'combobox',
														labelAlign : 'right',
														x : 460,
														y : 45,
														id : 'txt_txtj',
														fieldLabel : '摊销状态',
														store : tjstates,
														editable : false,
														queryMode : 'local',
														displayField : 'caption',
														valueField : 'value',
														value : 'tx1'
													}, ext_btnFind,
													ext_btnExport ]

										}, {
											region : 'center',
											margin : '5 5 0 5',
											layout : 'fit',
											items : [ dataGrid ]
										} ]
							});

			txt_date = Ext.getCmp('txt_date');
			txt_shop = Ext.getCmp('txt_shop');
			txt_object = Ext.getCmp('txt_object');
			txt_shop_s = Ext.getCmp('txt_shop_s');
			txt_object_s = Ext.getCmp('txt_object_s');
			txt_txtj = Ext.getCmp('txt_txtj');

			// 设置初始值
			txt_date.setValue(new Date());
		});

LoadUI = function() {

	ext_btnFind = Ext.create('Ext.Button', {
		text : '查询',
		icon : '../image/btn/find.png',
		width : 100,
		x : 740,
		y : 15,
		handler : function() {
			try {
				gridStore.proxy.setExtraParam('report', 'report1');
				gridStore.proxy.setExtraParam('shop', txt_shop.getValue());
				gridStore.proxy.setExtraParam('object', txt_object.getValue());
				gridStore.proxy.setExtraParam('txtj', txt_txtj.getValue());
				gridStore.proxy.setExtraParam('date', txt_date.getValue()
						.format("yyyy-MM-dd"));
				gridStore.loadPage(1);
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
		handler : function() {

			try {
				$('#hid_report').val('report1');
				$('#hid_start').val(0);
				$('#hid_limit').val(10000);
				$('#hid_shop').val(txt_shop.getValue());
				$('#hid_object').val(txt_object.getValue());
				$('#hid_date').val(txt_date.getValue().format("yyyy-MM-dd"));
				$('#hid_txtj').val(txt_txtj.getValue());
				$('#exportform').submit();

			} catch (e) {
				alert("条件设置错误!");
			}
		}
	});
};

LoadGrid = function() {
	// id,sdate, edate,
	// price,sumday,nowday,nowprice,lostday,lostprice,shop,object
	Ext.define('gridModel', {
		extend : 'Ext.data.Model',
		fields : [ 'id', 'sdate', 'edate', 'postdate', {
			name : 'price',
			sortType : 'asFloat'
		}, {
			name : 'sumday',
			sortType : 'asFloat'
		}, {
			name : 'nowday',
			sortType : 'asFloat'
		}, {
			name : 'nowprice',
			sortType : 'asFloat'
		}, {
			name : 'lostday',
			sortType : 'asFloat'
		}, {
			name : 'lostprice',
			sortType : 'asFloat'
		}, 'shop', 'object', 'shop_s', 'object_s' ]
	});
	gridStore = Ext.create('Ext.data.Store', {
		buffered : false,
		pageSize : 50,
		proxy : {
			type : "ajax",
			actionMethods : 'post',
			url : "./json/wptj_report.php",
			reader : {
				root : 'root',
				totalProperty : 'count',
				mymeta : 'sum1'
			}
		},
		model : 'gridModel',
		autoLoad : false
	});

	dataGrid = Ext.create('Ext.grid.Panel', {
		store : gridStore,
		features : [ {
			ftype : 'summary',
			dock : 'bottom'
		} ],
		sortableColumns : false,
		'columns' : [ {
			xtype : 'rownumberer',
			width : 30,
			sortable : false,
			summaryRenderer : function(value) {
				return '合计&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			}
		}, {
			text : '店铺代码',
			width : 70,
			dataIndex : 'shop'

		}, {
			text : '店铺名称',
			// flex : 1,
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
			summaryRenderer : function(value) {
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
			text : '报销日期',
			width : 120,
			dataIndex : 'postdate'
		}, {
			text : '总摊销天数',
			width : 100,
			dataIndex : 'sumday'
		}, {
			text : '已摊销天数',
			width : 100,
			dataIndex : 'nowday'
		}, {
			text : '已摊销金额',
			width : 100,
			dataIndex : 'nowprice',
			summaryRenderer : function(value) {
				if (gridStore.proxy.reader.jsonData) {
					return gridStore.proxy.reader.jsonData.nowprice_sum;
				}
				return 0;
			}
		}, {
			text : '剩余摊销天数',
			width : 120,
			dataIndex : 'lostday'
		}, {
			text : '剩余摊销金额',
			width : 120,
			dataIndex : 'lostprice',
			summaryRenderer : function(value) {
				if (gridStore.proxy.reader.jsonData) {
					return gridStore.proxy.reader.jsonData.lostprice_sum;
				}
			}
		} ],

		columnLines : true,
		enableLocking : true,

		iconCls : 'icon-grid',
		bbar : {
			xtype : 'pagingtoolbar',
			store : gridStore,
			displayInfo : true
		},
		header : false,
		autoScroll : true

	});

};
