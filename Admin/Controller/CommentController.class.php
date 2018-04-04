<?php
/*
 *
 * @author     Never、more
 * @Created  2015/1/12
 */
namespace Admin\Controller;

class CommentController extends CommonController{
	/**
	 * 加载显示页面
	 */
	public function index(){
		$this->display();
	}

	/**
	 * 获取分页信息
	 */
	public function  commentList() {
		$do = M("comment");

		/* 初始化分页查询条件 */
		$pageSize       = I('iDisplayLength');    //每页记录数
		$maxRows        = $do->count();           //总记录数
		$page           = I("iDisplayStart");     //当前起始索引
		$field          = array("id", "uid","pid","puid","mid","content", "addtime", "status"); //查询字段
		$order          = I('iSortCol_0') != null ? $field[intval(I('iSortCol_0'))] . " " . I("sSortDir_0") : "addtime desc";//排序
		$where          = I('sSearch') != "" ? "content like '%" . I('sSearch') . "%'" : ""; //搜素标题title
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
	 * 执行修改
	 */
	public function update(){
		//修改评论状态
		$status = I('status');
		$id = I('id');
		$mod = M('comment');
		$mod->where('id='.$id)->setField("status",$status);
	}
}