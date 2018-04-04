<?php
/*
 * 职位管理控制器
 * @author     Leo
 * @Created  2015/1/3
 */
namespace User\Controller;

class CompanyController extends CommonController {

	public function index() {
		$data = D('Admin/company')->find($this->company['id']);
		$data['description']  = str_replace("<br/>","\n",htmlspecialchars_decode($data['description']));
		$this->assign('data',$data);
		//企业性质
		$this->assign("attr",getTag(C('ATTRID')));
		//企业规模
		$this->assign("size",getTag(C('SIZEID')));
		//公司行业
		$this->assign("industry",getTag(C('TRADE')));
		//所在城市
		$this->assign('city',city(2));
		$this->display();
	}

	/**
	 * 更新企业资料
	 */
	public function update(){
		$do = D('Admin/company');
		if($do->create()){
			if(I('description')){
				$do->description = str_br($do->description);
			}
			if($do->where('id='.$this->company['id'])->save()){
				$this->success("保存成功");
			}else{
				$this->error("保存失败");
			}
		}else{
			$this->error($do->getError());
		}
	}
}