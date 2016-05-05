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

class StaffModel extends Model {

    protected $_validate = array(
    	 array('name','require','必须填写挂钩干部名称！'),
    	 array('company','require','必须填写企业名称！'),
    	 array('company_person','require','必须填写企业负责人名称！'),
    	 array('duty','require','必须填写单位职务！'),
    	 array('department','require','必须填写单位部门！'),
    	 array('area','require','必须选择所在区域！'),
    	 array('group','require','必须选择分组！'),
    	 array('company_type','require','必须选择企业类型！'),
    );

}