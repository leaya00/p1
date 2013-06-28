<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>备份</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=7" />

<script src="../js/jquery-1.7.1.min.js" type="text/javascript"></script>
<link href="../js/ext-4.2.1/resources/css/ext-all-neptune.css"
	rel="stylesheet" type="text/css" />
<script src="../js/ext-4.2.1/ext-all-debug.js" type="text/javascript"></script>
<script src="../js/ext-4.2.1/locale/ext-lang-zh_CN.js"
	type="text/javascript"></script>
	<style type="text/css">
	.x-combo-list-item { height: 30px;} 
	</style>
</head>
<body>
<script>
	
	Ext.require([
    'Ext.form.*',
    'Ext.layout.container.Absolute',
    'Ext.window.Window'
]);
txt_filename=null
Ext.onReady(function() {
	

    Ext.define('fileModel', {
        extend: 'Ext.data.Model',
        fields: ['filename']
    });
    fileStore = Ext.create('Ext.data.Store',
       {
           buffered: false,
//           pageSize: 300,
           proxy: {
               type: "ajax",
               url: "./json/backup.php",
               actionMethods:'post',//            
               extraParams: { op:'getfilelist' }
           },
           model: 'fileModel',
           autoLoad: true         
       });
    var form = Ext.create('Ext.form.Panel', {
        layout: 'absolute',
        url: 'save-form.php',
        defaultType: 'textfield',
		fieldDefaults: {
			labelWidth: 60,
			labelAlign:'right'
		},
        border: false,
		region:'center',
        items: [		
		{
			x: 20,
            y: 130,
			id:'txt_filename',
			width:380,			
			xtype: 'combobox',
			allowBlank: false,
			store: fileStore,
			valueField: 'filename',
			displayField: 'filename',
			typeAhead: true,
			queryMode: 'local',
			emptyText: '请选择想恢复的备份文件...'
        },
        {
			xtype:'button',
			text: '备份',
			x: 300,
            y: 30,
            width:100,
           
		    renderTo: Ext.getBody(),
		    handler: function() {
				run_backup();
		    	}
			}
		,{
			xtype:'button',
			text: '恢复',
			x: 300,
            y: 180,
            width:100,
		    renderTo: Ext.getBody(),
		    handler: function() {
				if(!txt_filename.getValue()){
					return;
				}
				var re=window.confirm("确定要恢复["+txt_filename.getValue()+"]备份文件吗？");
					if(re){
						run_restore();
					}
		    	}
			}
		]
    });
    
    
    var win = Ext.create('Ext.window.Window', {
        autoShow: true,
        title: '备份和恢复',
        width: 500,
        height: 300,
		closable:false,
		draggable:false,
		resizable:false,
		layout:'border',
        plain:true,
        items: [form]
    });
    myMask = new Ext.LoadMask(win, { msg: "请等待，正在执行任务..." });
    txt_filename=Ext.getCmp('txt_filename');
});
run_backup=function(){
	  myMask.show();
	$.ajax( {
		type : "POST",
		url : "./json/backup.php",
		data : {
			op:'backup'
		},
		success : function(msg) {
			  myMask.hide();
			if (msg.result==true) {
				//gridStore.reload();
				alert("信息: 备份成功!");
			} else {
				alert("错误信息: " + msg.result);
			}
		}

	});
	
};
run_restore=function(){
	  myMask.show();
	$.ajax( {
		type : "POST",
		url : "./json/backup.php",
		data : {
			op:'restore',
			filename:txt_filename.getValue()
		},
		success : function(msg) {			
			 myMask.hide();
			if (msg.result==true) {
				//gridStore.reload();
				alert("信息: 恢复成功!");
			} else {
				alert("错误信息: " + msg.result);
			}
		}

	});
	
};
	</script>
</body>
</html>
