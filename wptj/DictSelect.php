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
<?php
//todo:增加多选的方式
?>
<script type="text/javascript">

	LoadInfo=function(dictType,setDictValue) {
		myMask = new Ext.LoadMask(Ext.getBody(), {
			msg : "请等待，正在执行任务..."
		});
		myMask.show();
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
					type : dictType
					,tj:''	
				}
			},
			model : 'gridModel',
			autoLoad : false,
			listeners:{
				'load':function(){					
					myMask.hide();
					Ext.getCmp('txt_tj').focus();
				}
			}
			
		});
		var selModel = Ext.create('Ext.selection.CheckboxModel',{
				mode:'MULTI'
				//SINGLE,单 SIMPLE 多 
		}); 
		dataGrid = Ext.create('Ext.grid.Panel', {
			store : gridStore,
			selModel:selModel,
			sortableColumns : false,
			 region:'center',			 			
			'columns' : [
			 {
				xtype : 'rownumberer',
				width : 30,
				sortable : false
			}, 
			{
				text : '代码',
				width : 80,
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
			loadMask:false,
			autoScroll : true

		});
		
		Ext.create('Ext.Viewport', {
			layout : 'border',
			renderTo:Ext.getBody(),
			border : false,
			items : [
			         {
			        	 region : 'north',
			        	 layout:'absolute',
			        	 height:40,			        	 
			        	 items:[{
							x:0,
							y:5,
							xtype:'textfield',
							id : 'txt_tj',
							fieldLabel : '关键字',
							labelWidth : 50,
							width:250,
							height:27,
							labelAlign : 'right'
			        	 },
			        	 {
							xtype:'button',
							text : '查询',
							width:40,
							x:265,
							y:7,
							handler:function(){
								myMask.show();
			        		 	gridStore.proxy.setExtraParam('tj',Ext.getCmp('txt_tj').getValue());
							 	gridStore.reload();
							}								
				        }
			        	 ]
				      }
					  ,
					  {
						region : 'south',
			        	layout:'absolute',
			        	height:40,
						items:[
						{
							xtype:'button',
							text : '确定选择',
							width:100,
							x:80,
							y:7,
							handler:function(){
								var selModel = dataGrid.getSelectionModel() ;  
								if (selModel.hasSelection()) {
								    var selected = selModel.getSelection();
									
									Ext.each(selected, function (item) {
										
										 alert(item.data.caption);
									});
                           
								}
							}			
						},
			        	 {
							xtype:'button',
							text : '赋空值',
							x:230,
							y:7,
							width:100,
							handler:function(){
								if(setDictValue){
									setDictValue('','');
									}
							}								
				        }
						]
					  }
					  ,
				    	  dataGrid
				]
				
		});
		gridStore.load();		
	};
	
</script>

</body>
</html>
