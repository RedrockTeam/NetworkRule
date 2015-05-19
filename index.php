<?php
	if($_SERVER['REQUEST_METHOD'] == "POST" && !empty($_POST['vt'])){
		if($_POST['vt'] == 1){
			vote('good');
		}elseif($_POST['vt'] == 2){
			vote('bad');
		}
	}

	function vote($type = "good"){
		$arr = getVotes();
		$type == "good" ? $arr['good'] ++ : $arr['bad'] ++;
		file_put_contents("vote_data.json", json_encode($arr));
		return $type === "good" ? $arr['good'] : $arr['bad'];
	}

	function getVotes(){
		$json = @file_get_contents("vote_data.json");
		if($json){
			return json_decode($json, true);
		}

		$basic = array(
			"good" => 0,
			"bad" => 0
		);

		file_put_contents("vote_data.json", json_encode($basic));
		return $basic;
	}

	$info = getVotes();

?>
<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <title>重邮学生网络文明行为规范</title>

    <link href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
	<style>
		body{
			background-color: #F2F2F2;
			padding: 0 20px;
		}

		.container{
			overflow: hidden;
			margin: 0 auto 100px;
		}

		.content{
			font-weight: bold;
			font-size: 16px;
		}

		.tc{
			text-align: center;
		}
		.ti2{
			text-indent: 2em;
		}

		.vote-group{
			width: 100%;
			position: absolute;
			left: 0;
			margin: 20px auto 0;
		}

		.vote{
			float: left;
			width: 50%;
			color: #68B235;
			/*line-height: 38px;*/
			cursor: pointer;
			padding: 0 12px;
		}

		.good{
			text-align: right;
		}

		.vote img{
			margin-right: 8px;
		}

		.vote-number{
			color: #000;
			font-weight: bold;
		}
	</style>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="container">
    	<h1 class="tc">重庆邮电大学学生网络文明行为规范</h1>
		<div class="row content">
			<p class="tc">（讨论稿）</p>
			<p class="tc">遵纪守法，不昧良知</p>
			<p class="tc">诚实友善，远离虚假</p>
			<p class="tc">有益健康，抵制黄毒</p>
			<p class="tc">善于学习，防止沉溺</p>
			<p class="tc">自护助他，杜绝欺诈</p>
			<p class="tc">网络公德，人人有责</p>
		</div>

		<div class="row">
			<p>注解：</p>
			<p class="ti2">“遵纪守法，不昧良知”——自觉遵守国家有关互联网的法律、法规和政策；主动摒弃违背公共利益，背离中华民族优良传统的网络行为。</p>
			<p class="ti2">“诚实友善，远离虚假”——坚持诚实守信，与人为善的网络交际礼仪；并以客观、公正的原则甄别信息的真伪；杜绝制造、传播、轻信虚假信息。</p>
			<p class="ti2">“有益健康，抵制黄毒”——理性使用网络资源，做到健康上网；坚决抵制淫秽、色情、暴力等有害信息，摒弃低级趣味之风。</p>
			<p class="ti2">“善于学习，防止沉溺”——积极利用网络开展学习，合理规范网络作息，让网络成为实现自身成长成才的平台。</p>
			<p class="ti2">“自护助他，杜绝欺诈”——在树立网络自我防范意识的同时，积极利用网络帮助他人；坚决抵制各类网络欺诈行为。</p>
			<p class="ti2">“网络公德，人人有责”——网络世界既是虚拟的，也是现实的；既需要纪律的规范、法律的规范，更需要道德的规范和每一个人的践行。</p>
		</div>

		<div class="row vote-group">
			<div class="vote good">
				<img src="good.jpg" height="38" width="36">
				有道理
				<span class="vote-number"><?=$info['good']?></span>
			</div>
			<div class="vote bad">
				<img src="bad.jpg" height="38" width="36">
				不全面
				<span class="vote-number"><?=$info['bad']?></span>
			</div>
		</div>
    </div>

    <script src="http://cdn.bootcss.com/jquery/1.11.2/jquery.min.js"></script>
    <script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <script>
    	!function($){
    		var voted = false;
    		$('.good').on('click', function(){
    			if(voted) return;
    			$.post(location.href, {vt: 1}, handlerer("good"));
    			voted = true;
    		});

    		$('.bad').on('click', function(){
    			if(voted) return;
    			$.post(location.href, {vt: 2}, handlerer("bad"));
    			voted = true;
    		});

    		function handlerer(type){
    			type = type == "good" ? "good" : "bad";
    			return function(){
    				$vn = $('.' + type).find('.vote-number');
    				n = parseInt($vn.html())+1;
    				$vn.html(n);
    			}
    		}
    	}(jQuery);
    </script>
  </body>
</html>