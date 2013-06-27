Ext.require([ 'Ext.grid.*' ]);
txt_date = null;
txt_shop = null;
txt_object = null;
Ext.onReady(function() {

	LoadUI();
	LoadGrid();
	Ext.create('Ext.Viewport', {
		layout : 'border',
		border : false,
		items : [ {
			border : false,
			region : 'north',
			height : 60,
			layout : 'absolute',
			margin : '5 5 0 5',
			items : [ {

				labelWidth : 50,
				labelAlign : 'right',
				width : 200,
				x : 5,
				y : 15,
				id : 'txt_shop',
				fieldLabel : '店铺',
				xtype : 'triggerfield',
				editable : false,
				triggerCls : Ext.baseCSSPrefix + 'form-search-trigger',
				code : '',
				onTriggerClick : function() {
					popWin('./DictSelect.php', 'shop', this);
				}

			}, {
				labelWidth : 50,
				labelAlign : 'right',
				width : 200,
				x : 205,
				y : 15,
				id : 'txt_object',
				fieldLabel : '商品',
				xtype : 'triggerfield',
				editable : false,
				triggerCls : Ext.baseCSSPrefix + 'form-search-trigger',
				code : '',
				onTriggerClick : function() {
					popWin('./DictSelect.php', 'object', this);
				}

			}, {
				id : 'txt_date',
				x : 425,
				y : 15,
				fieldLabel : '报表截止时间',
				xtype : 'datefield',
				format : 'Y-m-d',
				allowBlank : false
			}, ext_btnFind,

			]

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
	txt_date.setValue(new Date());
});

LoadUI = function() {

	ext_btnFind = Ext.create('Ext.Button', {
		text : '查询',
		icon : '../image/btn/find.png',
		width : 100,
		x : 705,
		y : 15,
		handler : function() {
			try {
				gridStore.proxy.setExtraParam('report', 'report1');
				gridStore.proxy.setExtraParam('shop', txt_shop.code);
				gridStore.proxy.setExtraParam('object', txt_object.code);
				gridStore.proxy.setExtraParam('date', txt_date.getValue()
						.format("yyyy-MM-dd"));
				gridStore.reload();
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
		fields : [ 'id', 'sdate', 'edate', 'price', 'sumday', 'nowday',
				'nowprice', 'lostday', 'lostprice', 'shop', 'object', 'shop_s',
				'object_s' ]
	});
	gridStore = Ext.create('Ext.data.Store', {
		buffered : false,
		pageSize : 300,
		proxy : {
			type : "ajax",
			actionMethods : 'post',
			url : "./json/wptj_report.php",
			reader : {
				root : 'root',
				totalProperty : 'count'
			}
		},
		model : 'gridModel',
		autoLoad : false
	});

	dataGrid = Ext.create('Ext.grid.Panel', {
		store : gridStore,
		sortableColumns : false,
		'columns' : [ {
			xtype : 'rownumberer',
			width : 30,
			sortable : false
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
			dataIndex : 'price'
		}, {
			text : '摊销起始日期',
			width : 100,
			dataIndex : 'sdate'
		}, {
			text : '摊销截止日期',
			width : 100,
			dataIndex : 'edate'
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
			dataIndex : 'nowprice'
		}, {
			text : '剩余摊销天数',
			width : 100,
			dataIndex : 'lostday'
		}, {
			text : '剩余摊销金额',
			width : 100,

			dataIndex : 'lostprice'
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
		autoScroll : true

	});

};
