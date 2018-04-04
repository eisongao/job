<?php
/*
 *
 * @author     Never、more
 * @Created  2015/1/13
 */
namespace Home\Widget;
use Home\Controller\CommonController;
//评论扩展
class CommentWidget extends CommonController{
	//根据传入的模块ID和父ID查找对应的信息
	public function index($mid,$pid){
		$mod = D('comment');
		//封装搜索条件
		$where[] = "mid =".$mid;
		$where[] = "pid =".$pid;
		$where[] = "status = 1";
		$clist = $mod->where($where)->select();
		foreach($clist as $k=>$v){
			//父评论ID不为0时（即此条评论为回复）查找对应信息
			if($v['puid']!=0) {
				$oldcontent = $mod->where("id=" . $v['puid'])->getField("content");
				$olduid = $mod->where("id=" . $v['puid'])->getField("uid");
			}
			$uid = $v['uid'];
			$umod = M('user');
			//查找被评论人的昵称
			$oldalias = $umod->where("id=".$olduid)->getField("alias");
			//查找评论人的信息
			$ulist = $umod->field("id,status",ture)->find($uid);
			foreach($ulist as $key=>$value){
				//将被评论信息放入对应数组
				$glist = defaultPhoto($uid);
				$clist[$k][$key] = $value;
				$clist[$k]['photo'] = $glist['photo'];
				$clist[$k]['oldcontent'] = $oldcontent;
				$clist[$k]['oldalias'] = $oldalias;
			}
		}
		$this->assign('mid',$mid);
		$this->assign('pid',$pid);
		$this->assign("clist",$clist);
		$this->display("Public:comment");
	}
}