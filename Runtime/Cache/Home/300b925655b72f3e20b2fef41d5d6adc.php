<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
	<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
<title><?php echo C('WEB_SITE_TITLE');?></title>
<link href="/Public/static/bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="/Public/static/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
<link href="/Public/static/bootstrap/css/docs.css" rel="stylesheet">
<link href="/Public/static/bootstrap/css/onethink.css" rel="stylesheet">



<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
<script src="/Public/static/bootstrap/js/html5shiv.js"></script>
<![endif]-->

<!--[if lt IE 9]>
<script type="text/javascript" src="/Public/static/jquery-1.10.2.min.js"></script>
<![endif]-->
<!--[if gte IE 9]><!-->
<script type="text/javascript" src="/Public/static/jquery-2.0.3.min.js"></script>
<script type="text/javascript" src="/Public/static/bootstrap/js/bootstrap.min.js"></script>

<!--<![endif]-->
<!-- 页面header钩子，一般用于加载插件CSS文件和代码 -->

<?php echo hook('pageHeader');?>

</head>
<body>
	<!-- 头部 -->
	<!-- 导航条
================================================== -->
<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <a class="brand" href="<?php echo U('index/index');?>" ></a>
            <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <div class="nav-collapse collapse">
                <ul class="nav">
                    <?php $__NAV__ = M('Channel')->field(true)->where("status=1")->order("sort")->select(); if(is_array($__NAV__)): $i = 0; $__LIST__ = $__NAV__;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$nav): $mod = ($i % 2 );++$i; if(($nav["pid"]) == "0"): ?><li>
                            <a href="<?php echo (get_nav_url($nav["url"])); ?>" target="<?php if(($nav["target"]) == "1"): ?>_blank<?php else: ?>_self<?php endif; ?>"><?php echo ($nav["title"]); ?></a>
                        </li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                </ul>
            </div>
            <div class="nav-collapse collapse pull-right" style="display:none">
                <?php if(is_login()): ?><ul class="nav" style="margin-right:0">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="padding-left:0;padding-right:0"><?php echo get_username();?> <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo U('User/profile');?>">修改密码</a></li>
                                <li><a href="<?php echo U('User/logout');?>">退出</a></li>
                            </ul>
                        </li>
                    </ul>
                <?php else: ?>
                    <ul class="nav" style="margin-right:0">
                        <li>
                            <a href="<?php echo U('User/login');?>">登录</a>
                        </li>
                        <li>
                            <a href="<?php echo U('User/register');?>" style="padding-left:0;padding-right:0">注册</a>
                        </li>
                    </ul><?php endif; ?>
            </div>
        </div>
    </div>
</div>

	<!-- /头部 -->
	
	<!-- 主体 -->
	
<div id="main-container" class="container">
    <div class="row">
        
        <!-- 左侧 nav
        ================================================== -->
            <div class="span3 bs-docs-sidebar">
                
                <ul class="nav nav-list bs-docs-sidenav">
                    <?php echo W('Category/lists', array($category['id'], ACTION_NAME == 'index'));?>
                </ul>
            </div>
        
        
<section style="margin-top:0px">
  <?php if(!empty($data["no"])): ?><div class="span12">
      <form class="login-form" action="<?php echo U(Project/specialIndex);?>" method="post">
          <table class="table table-bordered table-striped responsive-utilities">
              <tr>
                  <td width="20%">评价人</td>
                  <td><?php echo ($data["name"]); ?></td>
              </tr>
              <tr>
                  <td>评价编号</td>
                  <td><?php echo ($data["no"]); ?></td>
              </tr>
              <tr>
                  <td>受评部门</td>
                  <td><?php echo ($data["department"]); ?></td>
              </tr>
              <tr>
                  <td>评价事项</td>
                  <td><?php echo ($data["content"]); ?></td>
              </tr>
              <tr>
                  <td>办理结果</td>
                  <td><?php echo ($data["result"]); ?></td>
              </tr>
              <tr>
                  <td>综合评价</td>
                  <td><input type="radio" name="rank" id="optionsRadios1" value="1"> 好评
                      &nbsp;&nbsp;
                      <input type="radio" name="rank" id="optionsRadios2" value="2"> 中评
                      &nbsp;&nbsp;
                      <input type="radio" name="rank" id="optionsRadios3" value="3"> 差评
                  </td>
              </tr>   
              <tr>
                  <td>评价详情</td>
                  <td>
                      <label>服务质量：&nbsp;<span id="star_1"></span></label>
                      <label>服务效率：&nbsp;<span id="star_2"></span></label>
                      <label>服务态度：&nbsp;<span id="star_3"></span></label>
                  </td>
              </tr>
              <tr>
                  <td>我说两句</td>
                  <td><textarea name="speak" style="width:90%; height:120px"></textarea></td>
              </tr>
              <tr>
                <td colspan="2">此评价由扬州市优化企业发展环境办公室适时推送，评价结果由优化办采集，对评价人保密。</td>
              </tr>
          </table>
    			<br />
          <div class="control-group">
              <div class="controls">
                  <input type="hidden" name="project_id" value="<?php echo ($data["id"]); ?>">
                  <input type="hidden" name="project_no" value="<?php echo ($data["no"]); ?>">
                  <button type="submit" class="btn">提交</button>
              </div>
          </div>
      </form>
	</div>
  <?php else: ?>
      <div class="span12">该评价事件不存在或者已经删除！</div><?php endif; ?>
</section>


    </div>
</div>

<script type="text/javascript">
    $(function(){
        $(window).resize(function(){
            $("#main-container").css("min-height", $(window).height() - 343);
        }).resize();
    })
</script>
	<!-- /主体 -->

	<!-- 底部 -->
	
    <!-- 底部
    ================================================== -->
    <footer class="footer">
      <div class="container">
          <p> 本站由 <strong><a href="http://www.jssdw.com" target="_blank">江苏仕德伟科技有限公司</a></strong> 技术支持</p>
      </div>
    </footer>

<script type="text/javascript">
(function(){
	var ThinkPHP = window.Think = {
		"ROOT"   : "", //当前网站地址
		"APP"    : "/index.php?s=", //当前项目地址
		"PUBLIC" : "/Public", //项目公共目录地址
		"DEEP"   : "<?php echo C('URL_PATHINFO_DEPR');?>", //PATHINFO分割符
		"MODEL"  : ["<?php echo C('URL_MODEL');?>", "<?php echo C('URL_CASE_INSENSITIVE');?>", "<?php echo C('URL_HTML_SUFFIX');?>"],
		"VAR"    : ["<?php echo C('VAR_MODULE');?>", "<?php echo C('VAR_CONTROLLER');?>", "<?php echo C('VAR_ACTION');?>"]
	}
})();
</script>

    <script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
    <script type="text/javascript">
      var url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=<?php echo C('WECHAT_APPID'); ?>&redirect_uri=";
          url += "http://" + window.location.host + "/index.php?s=/Home/Project/specialindex/id/<?php echo $_GET['id']; ?>&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";
      wx.ready(function () {
        wx.onMenuShareAppMessage({
            title: '请您评价', // 分享标题
            desc: '请您对编号<?php echo ($data["no"]); ?>的服务进行评价。', // 分享描述
            link: url, // 分享链接
            imgUrl: '<?php echo "http://".I("server.HTTP_HOST")."/img/pingjia.png" ?>', // 分享图标
            type: '', // 分享类型,music、video或link，不填默认为link
            dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
        });
      });

      wx.config({
        debug: false, 
        appId: '<?php echo C("WECHAT_APPID");?>', 
        timestamp:  <?php echo $tokenArr['now']; ?>,
        nonceStr: "<?php echo $tokenArr['nonceStr']; ?>", 
        signature: "<?php echo $tokenArr['signature']; ?>",
        jsApiList: ['onMenuShareAppMessage'] 
      }); 

    </script>

    <script src="/Public/static/jQueryRaty/jquery.raty.js" type="text/javascript"></script>
    <script type="text/javascript">         
        $('#star_1').raty({ 
            hints: ['1', '2', '3', '4', '5'],
            scoreName: 'rank_info_1',
        });
        $('#star_2').raty({ 
            hints: ['1', '2', '3', '4', '5'],
            scoreName: 'rank_info_2'
        });
        $('#star_3').raty({ 
            hints: ['1', '2', '3', '4', '5'],
            scoreName: 'rank_info_3'
        });

        $(".Validform_checktip")
     </script>
     <?php if(!empty($data["rank"])): ?><script type="text/javascript"> 
       
            $('#star_1').raty('score', <?php echo ($data["rank_info_1"]); ?>);
            $('#star_1').raty('readOnly', true);
            $('#star_2').raty('score', <?php echo ($data["rank_info_2"]); ?>);
            $('#star_2').raty('readOnly', true);
            $('#star_3').raty('score', <?php echo ($data["rank_info_3"]); ?>);
            $('#star_3').raty('readOnly', true);
         </script><?php endif; ?>
 <!-- 用于加载js代码 -->
<!-- 页面footer钩子，一般用于加载插件JS文件和JS代码 -->
<?php echo hook('pageFooter', 'widget');?>
<div class="hidden"><!-- 用于加载统计代码等隐藏元素 -->
	
</div>

	<!-- /底部 -->
</body>
</html>