<!DOCTYPE html>
<html lang="zh_CN">
<head>
	<meta charset="UTF-8">
	<title>Mark版--聊天室</title>
	
	<!-- 先加载css -->
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/qq.css" />

</head>
<body>
	<div style="padding-top:100px;">
		当前在线人:	
		<div  id="add_users">
			
		</div>
	</div>
	<div class="container">
		<div class="row">
			<div id="show_div" style="display:none; text-align:center;">
				<div style="display:inline-block;">
					<input type="text" id="need_name" placeholder="请输入您的大名" />
					<button onclick="set_name()" id="name_button">确认</button>
				</div>
			</div>
			<h1 class="text-center"></h1>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="com_form">
		        	<textarea class="input" id="saytext" name="saytext"></textarea>
		        	<p><input type="button" id="submit" class="sub_btn" value="提交"><span class="emotion">表情</span></p>
		        </div>
			</div>
		</div>
		<h3>聊天内容 </h3>
		<div class="row">
			<div class="col-md-12">
				<div id="msg">

				</div>
			</div>
		</div>
	</div>
</body>

<!-- 最后加载js -->
<script src="js/jquery-1.8.3.min.js"></script>
<script src="js/chat.js"></script>
<script src="js/qq.js"></script>
</html>
