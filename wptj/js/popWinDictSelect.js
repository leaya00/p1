
popWin = function (url, dictType, dist_cm, dist_cm_s, isMuti, defaultTJ, onClosed) {
	var pop_win = Ext
		.create(
			'Ext.window.Window', {
			title : '选择项目',
			height : 500,
			width : 500,
			layout : 'fit',
			resizable : false,
			modal : true,
			items : {
				region : 'center',
				html : '<iframe id="select_iframe"  width="100%" height="100%" frameborder="0" ></iframe>'
			},
			listeners : {
				'close' : function () {
					$('#select_iframe').attr('src', 'about:blank');
					if (onClosed) {
						onClosed();
					}
				}
			}

		});

	pop_win.show();
	var setDictValue = function (code, caption) {
		dist_cm_s.setValue(caption);
		dist_cm.setValue(code);
		pop_win.close();

	};
	$('#select_iframe').attr('src', url);
	loadFun = function () {
		// 装载内容
		if ($('#select_iframe').attr('src')) {
			$('#select_iframe').get(0).contentWindow.LoadInfo(dictType,
				setDictValue, isMuti, defaultTJ);
		}

	};
	if ($('#select_iframe').get(0).attachEvent) {
		 $('#select_iframe').get(0).attachEvent("onload", function () {
			loadFun(); //IE
		});
	} else {
		$('#select_iframe').get(0).onload = function () {
			loadFun(); //非IE
		};
	}

};
