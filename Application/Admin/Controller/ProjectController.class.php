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
class ProjectController extends AdminController {

	function index() {
		$Project = D('Project');
		$Rank    = D('Rank');

		C('LIST_ROWS',30);   //指定常量值
		$list = $this->lists('Project');

		foreach ($list as $key => $value) {
			$list[$key]['rank']  = $Rank->getCounts($value['id']);
			$list[$key]['staff'] = unserialize($value['staff']);
		}

		$conf['PROJECT_TYPE'] = C('PROJECT_TYPE');
		$conf['TO'] 		 = C('TO');
		$conf['RANK'] 		 = C('RANK');

		$this->assign('list',$list);
		$this->assign('conf',$conf);
		$this->meta_title = '事件列表';
        $this->display();
	}

	function projectAdd() {	
		if (I('post.')) {
			$Project = D('Project');
			if(!$Project->create()){ $this->error($Project->getError()); }
			$data = I('post.');
			$data['no']    = $Project->makeNo();
			$data['date']  = time();
			if ($data['staff'][0]['name'] == "") { $this->error("至少填写一列受评对象"); }
			$data['staff'] = serialize($data['staff']);
			$result = $Project->add($data);
			if ($result) { $this->success('创建事件成功！'); }
		}
		if (I('get.name')) {
			$map['name'] = I('get.name','','strip_tags');
			$data = M('Staff')->field('name,duty,department,company')->where($map)->find();
			echo $jsonData = json_encode($data);   // 前台传递json数据，自动完成表单填充
			return false;
		}

		$conf['projectType'] = C('PROJECT_TYPE');
		$conf['to'] 		 = C('TO');
		$this->assign('conf',$conf);
		$this->meta_title = '添加事件';
        $this->display();
	}

	function projectDel() {
		$id  = array_unique((array)I('ids',0)); 
  		if ($id[0] == 0) { $this->error('未选中任何评价事件。'); }
		$map['id'] = array('in',I('ids'));
		M('Project')->where($map)->delete();
        $this->success('评价事件删除成功！'); 
	}

	function projectView() {

		$Rank    = D('Rank');
		$Project = D('Project');

		if (I('post.')) {
			 // if(!$Project->create()){ $this->error($Project->getError()); }
			 $update = I('post.');
			 $result = $Project->save($update);
			 if ($result) { $this->success('更新事件成功！'); }
		}

		$map['id']     = I('get.id');
		$data          = $Project->where($map)->find();
		$data['staff'] = unserialize($data['staff']);
		$data['rank']  = $Rank->getCounts(I('get.id'));  // 统计好中差评价个数

		$conf['PROJECT_TYPE'] = C('PROJECT_TYPE');  // 事件类型
		$conf['TO']   		  = C('TO');  // 受评类型
		$conf['RANK']         = C('RANK'); 

		$this->assign('data',$data);
		$this->assign('conf',$conf);
 		$this->meta_title = '事件详情';
    $this->display();
	}

	function specialIndex() {

		C('LIST_ROWS',30);   //指定常量值
		$list = $this->lists('Special');

		$conf['RANK'] = C('RANK');
		$this->assign('list',$list);
		$this->assign('conf',$conf);
		$this->meta_title = '特殊事件';
        $this->display();
	}

	function specialAdd() {
		if (I('post.')) {
			$Special = D('Special');
			if(!$Special->create()){ $this->error($Special ->getError()); }
			$data = I('post.');
			$data['no']    = $Special->makeNo();
			$data['date']  = time();
			$result = $Special->add($data);
			if ($result) { $this->success('创建事件成功！'); }
		}
		$this->meta_title = '创建特殊事件';
        $this->display();
	}

	function specialView() {
		$map['id'] = I('get.id');

		if (I('post.')) {
			 $update = I('post.');
			 $result = D('Special')->save($update);
			 if ($result) { $this->success('更新事件成功！'); }
		}

		$data = D('Special')->where($map)->find();
		$conf['RANK'] = C('RANK');
		$this->assign('data',$data);
		$this->assign('conf',$conf);
 		$this->meta_title = '事件详情';
        $this->display();
	}

	function specialDel() {
		$id  = array_unique((array)I('ids',0)); 
  		if ($id[0] == 0) { $this->error('未选中任何评价事件。'); }
		$map['id'] = array('in',I('ids'));
		M('Special')->where($map)->delete();
        $this->success('评价事件删除成功！'); 
	}

	function qrView() {
		if (I('get.url')) {
			makeQr(I('get.url'));
		}
	}

	function rankRecord() {

		$Rank = D('Rank');
		$map['project_type'] = I('get.type') ? I('get.type') : $this->error('缺失事件类型。');
		$map['project_id']   = I('get.id') ? I('get.id') : array('neq', 0);

		$count = $Rank->count();
		$Page  = new \Think\Page($count,30);
		$show  = $Page->show();

		$list = $Rank->where($map)->limit($Page->firstRow.','.$Page->listRows)->select();

		$conf['RANK'] = C('RANK');
		$this->assign('list',$list);
		$this->assign('conf',$conf);
		$this->assign('_page',$show);
 		$this->meta_title = '事件详情';
 		if (I('get.type') == 1) {
 			$this->display('rankProject');
 		} else {
 			$this->display('rankSpecial');
 		} 
	}

	function rankDel() {

		$id  = array_unique((array)I('ids',0)); 
  		if ($id[0] == 0) { $this->error('未选中任何评价记录。'); }
		$map['id'] = array('in',I('ids'));
		M('Rank')->where($map)->delete();
        $this->success('评价记录删除成功！'); 
	}

}