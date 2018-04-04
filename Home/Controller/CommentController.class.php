<?php
/*
 *
 * @author     Never、more
 * @Created  2015/1/11
 */
namespace Home\Controller;

class CommentController extends CommonController{
	/**
	 * 查找被评论的评论和被评论者信息信息
	 */
	public function ssearch(){
		$mod = M('comment');
		$res = M('user');
		//根据评论ID查找对应的评论内容
		$oldcontent = $mod->where("id=".I('id'))->getField("content");
		//根据评论ID查找对应的评论者信息
		$olduid = $mod->where("id=".I('id'))->getField("uid");
		$oldalias = $res->where("id=".$olduid)->getField("alias");
		$list['oldcontent'] = $oldcontent;
		$list['oldalias'] = $oldalias;
		//返回json格式查询数据
		echo json_encode($list);
	}
	//执行评论添加
	public function doadd(){
		$mod = M('comment');
		//封装添加时间
		$_POST['addtime'] = time();
		//封装信息
		$mod->create($_POST);
		//执行添加
		if($mod->add()){
			$this->success("评论成功！");
		}else{
			$this->error("评论失败！");
		}
	}
}