<?php
/*
 * 友情链接操作类
 * @author     Liuli
 * @version    $Id$
 * @Created  14-12-30
 */
namespace Admin\Controller;

class LinkController extends CommonController {
	/**
	 * 显示列表页
	 */
	public function index() {
		$this->display();
	}

	/**
	 * 查询数据
	 */
	public function linklist(){
		$do = M("link");

		/* 初始化分页查询条件 */
		$pageSize       = I('iDisplayLength');    //每页记录数
		$maxRows        = $do->count();           //总记录数
		$page           = I("iDisplayStart");     //当前起始索引
		$field          = array("id", "title", "url","desc", "sort"); //查询字段
		$order          = I('iSortCol_0') != null ? $field[intval(I('iSortCol_0'))] . " " . I("sSortDir_0") : "sort desc";//排序
		$where          = I('sSearch') != "" ? "title like '%" . I('sSearch') . "%'" : ""; //搜素标题title
		$DisplayRecords = $do->where($where)->count();
		$data           = $do->field($field)->where($where)->order($order)->limit($page, $pageSize)->select(); //获取数据

		/* 返回给客户端数据 */
		$list["sEcho"]                = I("sEcho"); //来自客户端 sEcho 的没有变化的复制品
		$list["iTotalRecords"]        = $maxRows;   //总记录数
		$list["iTotalDisplayRecords"] = $DisplayRecords;   //过滤之后，实际的行数
		$list["aaData"]               = $data;      //表中数据

		$this->ajaxReturn($list);
	}

	/**
	 * 执行添加数据
	 */
	public function insert(){
		$do                 = D('link');
		if (!$do->create()) {
			$this->error($do->getError());
		} else {
			if ($id = $do->add()) {
				$this->success('添加成功！', U("index"));
			} else {
				$this->error($do->getError());
			}
		}
	}

	/**
	 * 执行删除数据
	 */
	public function delete(){
		if(D('link')->delete(I('id'))){
			$this->success("删除成功！");
		}else{
			$this->error("删除失败！");
		}

	}

	/**
	 * 执行修改
	 */
	public function update(){

		$do = D("link");
		if ($do->create()) {
			if ($do->save()) {
				$this->success("修改成功", U("index"));
			} else {
				$this->error("修改失败");
			}
		} else {
			$this->error($do->getError());
		}
	}

	/**
	 * 执行排序,供前台页面显示
	 */
	public function sort(){
		$list=D('link')->order('sort asc')->select();
		$this->assign("list",$list);
		$this->display();
	}

	/**
	 * 加载修改页面
	 */
	public function edit(){
		$data = D('link')->find(I('id', 0));
		$this->assign('data', $data);
		$this->display();
	}

	/**
	 * 加载添加页面
	 */
	public function add(){
		$this->display('edit');
	}
}