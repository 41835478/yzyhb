<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: echoshiki <echoshiki@outlook.com> 
// +----------------------------------------------------------------------

namespace Home\Model;
use Think\Model;

/**
 * 分类模型
 */
class RankModel extends Model{

	// 判断是否评价过 
	public function isRank($openId, $projectId) {
		$map['user_openid'] = $openId;
		$map['project_id']  = $projectId;
		$num = $this->where($map)->count();
		$result = ($num > 0) ? false : true;
		return $result;
	}
}