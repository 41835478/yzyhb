<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.jssdw.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: liucheng <echoshiki@outlook.com>
// +----------------------------------------------------------------------

namespace Admin\Controller;

/**
 * 评价事件控制器 搜索
 * @author liucheng <echoshiki@outlook.com>
 */
class StaffController extends AdminController {

	function index() {
		// C('LIST_ROWS',20);   //指定常量值
		// $list = $this->lists('staff');
		
		$Staff = M('Staff'); // 实例化User对象
		$count = $Staff->count();// 查询满足要求的总记录数
		$Page  = new \Think\Page($count,25);// 实例化分页类 传入总记录数和每页显示的记录数(25)
		$show  = $Page->show();// 分页显示输出
		$list  = $Staff->limit($Page->firstRow.','.$Page->listRows)->select(); 
		 
		$conf['COMPANY_TYPE']  = C('COMPANY_TYPE');
		$conf['AREA'] 		   = C('AREA');
		$conf['COMPANY_GROUP'] = C('COMPANY_GROUP');
		$this->assign('list',$list);
		$this->assign('conf',$conf);
		$this->assign('_page',$show);
		$this->meta_title = '关联资料列表';
        $this->display();
	}

	function staffAdd() {	
		if (I('post.')) {
			$Staff = D('Staff');
			if(!$Staff->create()){ $this->error($Staff ->getError()); }
			$data = I('post.');
			$data['name'] = trimall($data['name']);  //去除空格
			$data['company_person'] = trimall($data['company_person']);  //去除空格
			$result = $Staff->add($data);
			if ($result) { $this->success('资料录入成功！'); }
		}

		$conf['COMPANY_GROUP'] = C('COMPANY_GROUP');
		$conf['AREA'] 		   = C('AREA');
		$conf['COMPANY_TYPE']  = C('COMPANY_TYPE');

		$this->assign('conf',$conf);
		$this->meta_title = '添加资料';
        $this->display();
	}

	function staffEdit() {
		if (I('post.')) {
			$Staff = D('Staff');
			if(!$Staff->create()){ $this->error($Staff ->getError()); }
			$data = I('post.');
			$data['name'] = trimall($data['name']);  //去除空格
			$data['company_person'] = trimall($data['company_person']);  //去除空格
			$result = $Staff->save($data);
			if ($result) { $this->success('资料录入成功！'); }
		}

		if (I('get.id')) {
			$map['id'] = I('get.id');
			$data = D('Staff')->where($map)->find();

			$conf['COMPANY_GROUP'] = C('COMPANY_GROUP');
			$conf['AREA'] 		   = C('AREA');
			$conf['COMPANY_TYPE']  = C('COMPANY_TYPE');

			$this->assign('conf',$conf);
			$this->assign('data',$data);				
		}
		$this->meta_title = '修改资料';
	    $this->display();	
		
	}


	function staffDel() {
		$id  = array_unique((array)I('ids',0)); 
  		if ($id[0] == 0) { $this->error('未选中任何资料。'); }
		$map['id'] = array('in',I('ids'));
		M('Staff')->where($map)->delete();
        $this->success('资料删除成功！'); 
	}

}