	// 网页刷新或者关闭的提示信息.......
	// $(window).bind('beforeunload',function(){
 //        if (true) {
 //            return('刷新或离开页面后用户名需重新填写!!');
 //        }
 //    })
    
    // 调用websocket
	var url = 'ws://127.0.0.1',

	port = 8090;
	var user_arr = '';

	var urlss = 'user.php';
	var ws = new WebSocket(url+':'+port);
	console.log(ws);
	ws.onopen = function(){

		var newname = $.trim($('.text-center').text());
		// var username = $.trim($.session.get('websocket_username'));
		if (newname == '') {
			alert('请给自己起一个响亮的名字!!!');
			$('#show_div').show();
			return false;
		}
		// msg = $("input[name='saytext']").val();
		msg = $("#saytext").val();
		if (msg == '') {
			alert('请输入内容');
			return false;
		}
		msg = newname + ':' + msg;
		ws.send(msg);
		msg = $("#saytext").val('');
		// $("input[name='saytext']").val('');
	}

	ws.onmessage = function(e) {
		// console.log("收到服务端的消息：" + e.data);
		var new_str = replace_em(e.data);
		$("#saytext").val('');
		$("#msg").append(new_str+'<br />');
	}

	$(function() {
		$('.emotion').qqFace({
			id : 'facebox', //表情盒子的ID
			assign:'saytext', //给那个控件赋值
			path:'face/'	//表情存放的路径
		});
		$.post(urlss,'',function (data) {
   			user_arr = data.split(' ');
		});
		$("#submit").on('click',function() {
			ws.onopen();
		});
	});

	// 给自己起名字
	function set_name () {
		var true_name = $('#need_name').val();
		// 名字不允许为单个的数字......
		var num_arr = ['1','2','3','4','5','6','7','8','9','0'];

		var check_type = typeof(user_arr);
		if (check_type == 'undefined') {
			alert('请再次点击确认');
			return false;
		};

		if (true_name == '') {
			alert('请输入大名');
			return false;
		}else if ($.inArray(true_name,num_arr) != -1) {
			alert('您输入的大名不合法');
			return false;
		}else if (($.inArray(true_name,user_arr) != -1)) {
			alert('您输入的大名已经存在,请换一个');
			return false;
		}else if (true_name.indexOf('1') >= 0) {
			alert('大名中不能包含数字1');
			return false;
		}else{
			$('.text-center').text(true_name);
			$('#show_div').hide();
			var msg = '1'+true_name+':'+'我是新人,请多多指教';
			ws.send(msg);
		}
	}

	// 持续更新在线的人
	setInterval(function () {
		urls = 'user.php';
		$.post(urls,'',function (data) {
			var arr = data.split(' ');
			var trs = "";
			$.each(arr,function(n,val) {
				if (val != '') {
					trs += "<span style='color:red;padding:5px;'>"+$.trim(val)+"</span>";
				};
            });
			$("#add_users").html(trs);
		})
	},1500)

	//匹配输入的表情 .... 
	function replace_em(str){
		str = str.replace(/\</g,'&lt;');
		str = str.replace(/\>/g,'&gt;');
		str = str.replace(/\n/g,'<br/>');
		str = str.replace(/\[em_([0-9]*)\]/g,'<img src="face/$1.gif" border="0" />');
		return str;
	}
