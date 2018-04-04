<?php
/*
 * Rbac 节点管理
 * @author     Leo
 * @Created  2015/1/2
 */
namespace Admin\Controller;

class NodeController extends CommonController {

	/**
	 * 浏览节点
	 */
	public function index() {
		$data = D('node')->order("sort desc")->select();
		$list = getNodeArr($data);
		$this->assign('list', $list);
		$this->display();
	}

	/**
	 * 添加页面
	 */
	public function add() {
		//获取节点列表
		$data = D('node')->where("level<3")->order("sort desc")->select();
		$list = getNodeArr($data);
		$this->assign('list', $list);
		$this->display("edit");
	}

	/**
	 * 执行添加
	 */
	public function insert() {
		$do = D("node");
		if ($do->create()) {
			//拼装pid与level
			$tmp       = explode("|", I('pid'));
			$do->pid   = $tmp[1];
			$do->level = $tmp[0] + 1;
			if ($do->add()) {
				$this->success("添加成功", U("Node/index"));
			} else {
				$this->error("添加失败");
			}
		} else {
			$this->error($do->getError());
		}
	}

	/**
	 * 执行删除
	 */
	public function delete() {
		$do = D("node");
		//判断是否有子节点
		$data = $do->where("pid=" . I("id", 0))->count();
		if ($data && $data > 0) {
			$this->error("该节点下含有子节点,请先删除子节点");
			exit;
		}
		if ($do->delete(I("id", 0))) {
			//删除角色_节点表中的数据
			M("role_node")->where("node_id=" . I("id"))->delete();
			$this->success("节点删除成功", U("Node/index"));
		} else {
			$this->error("节点删除失败");
		}
	}

	/**
	 * 修改页面
	 */
	public function edit() {
		$data = D("node")->find(I("id", 0));
		//获取节点列表
		$list = D('node')->where("level<3")->order("sort desc")->select();
		foreach ($list as $k => $v) {
			if ($v["id"] == $data["pid"]) {
				$list[$k]["selected"] = "selected";
			}
		}
		$list = getNodeArr($list);
		$this->assign('list', $list);
		$this->assign("data", $data);
		$this->display("edit");
	}

	/**
	 * 执行修改
	 */
	public function update() {
		$do = D("node");
		if ($do->create()) {
			//拼装pid与level
			$tmp       = explode("|", I('pid'));
			$do->pid   = $tmp[1];
			$do->level = $tmp[0] + 1;
			if ($do->save()) {
				$this->success("修改成功!", U("Node/index"));
			} else {
				$this->error("修改失败");
			}
		} else {
			$this->error($do->getError());
		}
	}
}