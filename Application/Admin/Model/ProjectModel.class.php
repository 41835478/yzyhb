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

class ProjectModel extends Model {

    protected $_validate = array(
    	 array('type','require','必须选择事件类型！'),
    	 array('to','require','必须选择受评类型！'),
    );


    /**
	 * 生成事件编号（PJ+年+月+次数）
	 * @param string $content 封装内容
	 */
    public function makeNo() {
    	$num  = 1;
    	$year = date('Y',time());
    	$thisMonth = date('m',time());
    	$nextMonth = $thisMonth + 1;
    	$time1 = mktime(0,0,0,$thisMonth,1,$year);  //取得本月1日时间戳
    	$time2 = mktime(0,0,0,$nextMonth,1,$year);  //取得下月1日时间戳
    	$map['date'] = array('between',array($time1,$time2));  //获取当月数据
    	$num += $this->where($map)->count();  //计算月间数据量
    	if (strlen($num) == 1) { $num = '0'.$num; }
    	$no = 'PJ-'.$year.$thisMonth.$num;
    	return $no;
    }



}
