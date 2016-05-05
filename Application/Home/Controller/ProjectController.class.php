<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.jssdw.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: liucheng <echoshiki@outlook.com>
// +----------------------------------------------------------------------

namespace Home\Controller;

/**
 * 评价详情
 * 2016.04.06
 */
class ProjectController extends HomeController {

	public function index(){

		if (I('get.id')) {
			$map['id'] = I('get.id');
			$conf['PROJECT_TYPE'] = C('PROJECT_TYPE');
			$conf['TO'] 		  = C('TO');
			$conf['RANK'] 		  = C('RANK');
			$data 		   = D('Project')->where($map)->find();
			$data['staff'] = unserialize($data['staff']);
			// 调用微信类 生成Signature 分享链接用
			$wechat   = new \My\Wechat();
    		$tokenArr = $wechat->getSignature();
    		// 通过code请求用户信息
    		$userData = $wechat->getUserInfo(I('get.code'));  // 获取用户信息 
    		if (session('userData.nickname') == '') {
    			session('userData',$userData);  // 将微信用户信息写入session
    		}
		}

		if (I('post.')) {
			$Rank = D('rank');
			if (!I('post.rank')) { $this->error('请选择总体评价。'); }	
			$dataIns = I('post.');
			$dataIns['user_openid']   = session('userData.openid') ? session('userData.openid') : $this->error('用户信息获取失败。');
			$dataIns['user_nickname'] = session('userData.nickname');
			$dataIns['user_img']      = session('userData.headImg');
			$dataIns['project_type']  = 1;
			$dataIns['rank_date']     = time();
			if (!$Rank->isRank($dataIns['user_openid'],$dataIns['project_id'])) {
				$this->error('您已经做过评价。');
			}
			$result = M('rank')->add($dataIns);
			if ($result) { $this->success('评价成功，感谢您的参与！');}
		} else {
			$this->assign('conf',$conf);
			$this->assign('data',$data);
			$this->assign('tokenArr',$tokenArr);
			$this->display($category['template_index']);
		}

	}

	public function specialIndex(){

		if (I('get.id')) {
			$map['id']     = I('get.id');
			$conf['RANK']  = C('RANK');
			$data 		   = D('Special')->where($map)->find();
			// 调用微信类 生成Signature
			$wechat   = new \My\Wechat();
    		$tokenArr = $wechat->getSignature();
    		// 通过code请求用户信息
    		$userData = $wechat->getUserInfo(I('get.code'));  // 获取用户信息 
    		if (session('userData.nickname') == '') {
    			session('userData',$userData);  // 将微信用户信息写入session
    		}
		}

		if (I('post.')) {
			$Rank = D('rank');
			if (!I('post.rank'))        { $this->error('请选择总体评价。'); }	
			if (!I('post.rank_info_1')) { $this->error('请选择服务质量。'); }
			if (!I('post.rank_info_2')) { $this->error('请选择服务态度。'); }
			if (!I('post.rank_info_3')) { $this->error('请选择服务效率。'); }
			$dataIns = I('post.');
			$dataIns['user_openid']   = session('userData.openid') ? session('userData.openid') : $this->error('用户信息获取失败。');
			$dataIns['user_img'] 	  = session('userData.headImg');
			$dataIns['user_nickname'] = session('userData.nickname');
			$dataIns['project_type']  = 2;
			$dataIns['rank_date'] = time();
			if (!$Rank->isRank($dataIns['user_openid'],$dataIns['project_id'])) {
				$this->error('您已经做过评价。');
			}
			$result = $Rank->add($dataIns);
			if ($result) { $this->success('评价成功，感谢您的参与！');}
		} else {
			$this->assign('conf',$conf);
			$this->assign('data',$data);
			$this->assign('tokenArr',$tokenArr);
			$this->display($category['template_index']);
		}
	}

}
