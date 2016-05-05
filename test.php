<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0"> 

<?php 
	$appid  = "wx6ae8dc812609161f";
	$secret = "51a91bf1217b9bd0daa32fdbf882fcf2";

	$content1 = file_get_contents('https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$secret);
	$arr1 = json_decode($content1);
	$access_token = $arr1->access_token;

	$content2 = file_get_contents('https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token='.$access_token.'&type=jsapi');
	$arr2 = json_decode($content2);
	$jsapi_ticket = $arr2->ticket;

	$nonceStr = 'Wm3WZYTPz0wzccnW';
	$timestamp = time();
	$url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];;

	$string = "jsapi_ticket=".$jsapi_ticket."&noncestr=".$nonceStr."&timestamp=".$timestamp."&url=".$url;

	$signature = sha1($string);
  ?>


<?php 
	$urls = "http://linshikongjian.sk71.sdwlsym.com/response.php";
	// 获取用户信息
	$mp_url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$appid."&redirect_uri=".$urls."&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";

	echo "<a style='font-size:60px' href='".$mp_url."'>click me</a>";
 ?>


<script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>
	wx.ready(function () {
		wx.onMenuShareAppMessage({
		    title: '查看用户资料', // 分享标题
		    desc: '微信api接口开发测试', // 分享描述
		    link: window.location.href, // 分享链接
		    imgUrl: 'https://ss1.baidu.com/70cFfyinKgQFm2e88IuM_a/forum/pic/item/adaf2edda3cc7cd9684f8ce83e01213fb80e91a5.jpg', // 分享图标
		    type: '', // 分享类型,music、video或link，不填默认为link
		    dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
		    success: function () { 
		        // 用户确认分享后执行的回调函数
		        alert('hello world;');
		    },
		    cancel: function () { 
		        // 用户取消分享后执行的回调函数
		        alert('cancle');
		    }
		});
	});

	wx.config({
	    debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
	     
	    jsApiList: ['onMenuShareAppMessage'] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
	});	

</script>


