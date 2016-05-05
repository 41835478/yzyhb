<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: liucheng <echoshiki@outlook.com>
// +----------------------------------------------------------------------

namespace Admin\Model;
use Think\Model;

class RankModel extends Model {

    // 判断是否评价过 
	public function isRank($openId, $projectId) {
		$map['user_openid'] = $openId;
		$map['project_id']  = $projectId;
		$num = $this->where($map)->count();
		$result = ($num > 0) ? false : true;
		return $result;
	}

	// 统计评价事件好中差个数 
	public function getCounts($id = "") {
		$data = array();
		$data['r_1']   = $this->where(array('project_id'=>$id,'rank'=>'1'))->count();
		$data['r_2']   = $this->where(array('project_id'=>$id,'rank'=>'2'))->count();
		$data['r_3']   = $this->where(array('project_id'=>$id,'rank'=>'3'))->count();
		return $data;
	}



}