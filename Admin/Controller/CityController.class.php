<?php
/*
 * 城市管理控制器
 * @author     Liuli
 * @version    $Id$
 * @Created  14-12-31
 */
namespace Admin\Controller;

class CityController extends CommonController {

	public function index() {
		$this->display();
	}
	/**
	 * 查询城市列表信息
	 */
	public function citylist(){
		$do = M("city");

		/* 初始化分页查询条件 */
		$pageSize       = I('iDisplayLength');    //每页记录数
		$maxRows        = $do->count();           //总记录数
		$page           = I("iDisplayStart");     //当前起始索引
		$field          = array("id", "pid", "name",  "sort"); //查询字段
		$order          = I('iSortCol_0') != null ? $field[intval(I('iSortCol_0'))] . " " . I("sSortDir_0") : "id desc";//排序
		$where          = I('sSearch') != "" ? "name like '%" . I('sSearch') . "%'" : ""; //搜素标题title
		$DisplayRecords = $do->where($where)->count();
		$data           = $do->field($field)->where($where)->order($order)->limit($page, $pageSize)->select(); //获取数据

		/* 返回给客户端数据 */
		$list["sEcho"]                = I("sEcho"); //来自客户端 sEcho 的没有变化的复制品
		$list["iTotalRecords"]        = $maxRows;   //总记录数
		$list["iTotalDisplayRecords"] = $DisplayRecords;   //过滤之后，实际的行数
		$list["aaData"]               = $data;      //表中数据

		$this->ajaxReturn($list);
		$this->display();
	}

	/**
	 * 执行添加
	 */
	public function insert(){
		$mod=D('city');
		if(!$mod->create()){
			$this->error($mod->getError());
		}else{
			if($id=$mod->add()){
				$this->success("添加成功！",U('index'));
			}else{
				$this->error($mod->gerError());
			}
		}
	}

	/**
	 * 执行删除
	 */
	public function delete(){
		if(M('city')->delete(I('id'))){
			$this->success("删除成功！");
		}else{
			$this->error("删除失败！");
		}
	}

	/**
	 * 执行修改
	 */
	public function update(){
		$mod = D("city");
		if ($mod->create()) {
			if ($mod->save()) {
				$this->success("修改成功", U("index"));
			} else {
				$this->error("修改失败");
			}
		} else {
			$this->error($mod->getError());
		}
		$this->display();
	}

	/**
	 * 加载添加页面
	 */
	public function add(){
		$this->display('edit');
	}

	/**
	 * 加载修改页面
	 */
	public function edit(){
		$data = D('city')->find(I('id', 0));
		$this->assign('data', $data);
		$this->display();
	}
}