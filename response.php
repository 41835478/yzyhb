<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
<?php 

	$appid  = "wx6ae8dc812609161f";
	$secret = "51a91bf1217b9bd0daa32fdbf882fcf2";

	$code = $_GET['code'];

	$url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$appid."&secret=".$secret."&code=".$code."&grant_type=authorization_code";

	$content = file_get_contents($url);
	$arr = json_decode($content);
	$access_token = $arr->access_token;
	$refresh_token = $arr->refresh_token;
	$openid = $arr->openid;

	$url = "https://api.weixin.qq.com/sns/userinfo?access_token=".$access_token."&openid=".$openid."&lang=zh_CN";
	$userObj = json_decode(file_get_contents($url));
	$headImg = $userObj->headimgurl;

 ?>
	<p>你的登录资料：</p>
	<p>OpenID：<?php echo $userObj->openid; ?></p>
	<p>Nickname：<?php echo  $userObj->nickname; ?></p>
	<p>City：<?php echo $userObj->city; ?></p>
	<p>Province：<?php echo  $userObj->province; ?></p>
	<p>Country：<?php echo  $userObj->country; ?></p>
	<p>头像： <img src="<?php echo $headImg ?>" width="200" height="200"/></p>
