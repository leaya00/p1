
popWin = function(url, dictType, dist_cm,isMuti) {
	
		var pop_win = Ext
			.create(
					'Ext.window.Window',
					{
						title : '选择项目',
						height : 500,
						width : 400,
						layout : 'fit',
						resizable : false,
						modal : true,
						items : {
							region : 'center',
							html : '<iframe id="select_iframe" src="' + url + '" width="100%" height="100%" frameborder="0" ></iframe>'
						},
						listeners : {
							'close':function(){
								$('#select_iframe').attr('src','about:blank');
							}
						}
						
					});
	
	pop_win.show();
	var setDictValue = function(code, caption) {
		dist_cm.setValue(caption);
		dist_cm.code = code;
		pop_win.close();
	};
	$('#select_iframe').load(function() {
		// 装载内容
			if($('#select_iframe').attr('src')){
				$('#select_iframe').get(0).contentWindow.LoadInfo(dictType,
						setDictValue,isMuti);
			}

		});
};