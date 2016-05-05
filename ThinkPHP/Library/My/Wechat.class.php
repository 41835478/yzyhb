<?php 

namespace My;
class Wechat {

	var $appid;
	var $appsecret;

	public function __construct() {

        $this->appid     = C('WECHAT_APPID');
        $this->appsecret = C('WECHAT_APPSECRET');

    }


	/**
	 * 通过微信授权页面get的CODE，获取用户信息
	 */
	public function getUserInfo($code) {

		$userData = array();

		$url  = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$this->appid;
		$url .= "&secret=".$this->appsecret."&code=".$code."&grant_type=authorization_code";

		$con  = file_get_contents($url);
		$obj  = json_decode($con);
		$openid        = $obj->openid;
		$access_token  = $obj->access_token;
		$refresh_token = $obj->refresh_token;

		$url     = "https://api.weixin.qq.com/sns/userinfo?access_token=".$access_token."&openid=".$openid."&lang=zh_CN";
		$userObj = json_decode(file_get_contents($url));
		$userData['headImg'] = $userObj->headimgurl;
		$userData['openid'] = $userObj->openid;
		$userData['nickname'] = $userObj->nickname;

		return $userData;
	}

	/**
	 * 通过保存的tokendata获取到api所需的配置信息signature等
	 */
	public function getSignature() {

		$tokenArr  = array();
		$tokenData = $this->getTokenData();
		$tokenArr['url']      = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		$tokenArr['now']      = time();
		$tokenArr['nonceStr'] = "Wm3WZYTPz0wzccnW";

		$string = "jsapi_ticket=".$tokenData['jsapi_ticket']."&noncestr=".$tokenArr['nonceStr']."&timestamp=".$tokenArr['now']."&url=".$tokenArr['url'];
		$tokenArr['signature'] = sha1($string);
		return $tokenArr;
	}

	/**
	 * 获取保存的TokenData：accesstoken、jsapiticket
	 */
	public function getTokenData() {

		$tokenData = array();
		$tokenData = S('tokenData'); // 从缓存获取ACCESS_TOKEN
		if (is_array($tokenData)) {
			$nowtime  = time();
			$difftime = $nowtime - $tokenData['tokentime']; // 判断缓存里面的TOKEN保存了多久；
			if ($difftime > 7000) {  // TOKEN有效时间7200 判断超过7000就重新获取;
				$tokenData['tokentime']    = time();
				$tokenData['access_token'] = $this->getAccessToken(); // 去微信获取最新ACCESS_TOKEN
				$tokenData['jsapi_ticket'] = $this->getJsapiTicket(); // 去微信获取最新JSAPI_TICKET
				S('tokenData',$tokenData); // 放进缓存
			} else {
				return $tokenData;
			}
		} else {
			$tokenData['tokentime']    = time();
			$tokenData['access_token'] = $this->getAccessToken(); // 去微信获取最新ACCESS_TOKEN
			$tokenData['jsapi_ticket'] = $this->getJsapiTicket(); // 去微信获取最新JSAPI_TICKET
			S('tokenData',$tokenData); // 放进缓存
		}
		return $tokenData;
	}
	
	/**
	 * 重新从微信获取accesstoken
	 */
	private function getAccessToken() {

		$con = file_get_contents('https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$this->appid.'&secret='.$this->appsecret);
		$obj = json_decode($con);
		$access_token = $obj->access_token;

		return $access_token;
	}

	/**
	 * 重新从微信获取jsapiticket
	 */
	private function getJsapiTicket() {

		$access_token = $this->getAccessToken();
		$con = file_get_contents('https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token='.$access_token.'&type=jsapi');
		$obj = json_decode($con);
		$jsapi_ticket = $obj->ticket;
	
		return $jsapi_ticket;
	}

}




 ?>