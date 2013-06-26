<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<script src="../js/jquery-1.7.1.min.js" type="text/javascript"></script>
<link href="../js/ext-4.2.1/resources/css/ext-all-neptune.css"
	rel="stylesheet" type="text/css" />
<script src="../js/ext-4.2.1/ext-all-debug.js" type="text/javascript"></script>
<script src="../js/ext-4.2.1/locale/ext-lang-zh_CN.js"
	type="text/javascript"></script>
<script src="../js/utils.js" type="text/javascript"></script>

</head>
<body>
<script type="text/javascript">
	Ext.onReady(function() {
		LoadGrid();
		Ext.create('Ext.Viewport', {
			layout : 'border',
			border : false,
			items : [
			         {
			        	 region : 'north',
			        	 layout:'fit',
			        	 items:{
							xtype:'textfield',
							id : 'txt_code',
							fieldLabel : '关键字',
							labelWidth : 50,
							labelAlign : 'right',
							enableKeyEvents:true,
							listeners : {
								'keydown' : function(me, e, eOpts) {
									 if(e.getKey()==13){
										 gridStore.proxy.setExtraParam('tj',this.getValue());
										 gridStore.reload();
									 }
								}
							}
			        	 }
				      },
				      {
				    	  region:'center',
				    	  items:dataGrid
					     }
				      
				]
		});
	
		
	});
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
				actionMethods:'post',
				url : "./json/wptj_dict.php?op=filter",
				reader : {
					root : 'root',
					totalProperty : 'count'
				},
				extraParams : {					
					type : 'shop'//dictType
					,tj:'xxx'	
				}
			},
			model : 'gridModel',
			autoLoad : true
			
		});
		dataGrid = Ext.create('Ext.grid.Panel', {
			store : gridStore,
			sortableColumns : false,
			'columns' : [
			 {
				xtype : 'rownumberer',
				width : 30,
				sortable : false
			}, 
			{
				text : '代码',
				width : 120,
				dataIndex : 'code'
			},
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
			header : false,
			autoScroll : true,
			listeners : {
				'itemclick' : function(me, record, item, index, e, eOpts) {
					alert(111);
				}
			}

		});
	};
</script>

</body>
</html>
