<?php
/*
 * 前台首页显示
 * @author     Liuli
 * @version    $Id$
 * @Created  15-1-6
 */
namespace Home\Controller;


class IndexController extends CommonController {
	public function index() {
		//行业分类
		$cate = getCate(C('JOB'));
		//技术类推荐
		$cate[0]['spe'] = array(
			array('id' => 39, 'name' => "PHP"),
			array('id' => 30, 'name' => "iOS"),
			array('id' => 29, 'name' => "Android"),
			array('id' => 40, 'name' => "Java"),
		);
		//产品类推荐
		$cate[1]['spe'] = array(
			array('id' => 98, 'name' => "产品总监"),
			array('id' => 99, 'name' => "产品经理"),
			array('id' => 104, 'name' => "产品助理"),
		);
		//设计类推荐
		$cate[2]['spe'] = array(
			array('id' => 143, 'name' => "设计总监"),
			array('id' => 115, 'name' => "UI设计"),
			array('id' => 137, 'name' => "交互设计师"),
		);
		//运营/编辑类
		$cate[3]['spe'] = array(
			array('id' => 171, 'name' => "运营总监"),
			array('id' => 177, 'name' => "社区运营"),
			array('id' => 189, 'name' => "内容编辑"),
		);
		//市场/销售类
		$cate[4]['spe'] = array(
			array('id' => 227, 'name' => "销售经理"),
			array('id' => 228, 'name' => "销售专员"),
			array('id' => 213, 'name' => "市场营销"),
		);
		//职能类
		$cate[5]['spe'] = array(
			array('id' => 146, 'name' => "人事专员"),
			array('id' => 206, 'name' => "客服代表"),
			array('id' => 160, 'name' => "助理"),
		);
		$this->assign('cate', $cate);
		//幻灯图片
		$pic = M('news')->where('status=1')->order('level desc')->field('id,title')->limit(6)->select();
		$this->assign('pic',$pic);
		//热招企业
		$where['status'] = 1;
		$hotcompany      = M("company")->where($where)->order('level desc')->select();
		/*foreach ($hotcompany as $k => $v) {
			$hotcompany[$k]['cname'] = substr($v['cname'], 0, 10);
		}*/
		$this->assign("hotcompany", $hotcompany);

		//热门职位列表
		$where['status'] = 1;
		$hjob = D("job");
		$hotjob=$hjob->relation(true)->where($where)->order('edittime desc')->limit(0, 15)->select();
		foreach ($hotjob as $k => $v) {
			//月薪
			$hotjob[$k]['payid'] = number_format($v['payid'] * 1000);
			//分类
			$category = getCateInfo($v['cid']);
			$hotjob[$k]['cid'] = $category['name'];
			//dump($category['name']);

			//工作经历
			$year = getTagInfo($v['year']);
			if ($year['id'] == 29) {//将0年改为“不限”
				$hotjob[$k]['year'] = "不限";
			} else {
				$hotjob[$k]['year'] = $year['tagname'];
			}
			//统计被评论次
			$comment                = M("comment");
			$comwhere['mid']        = C('JOB');//封装模块id查询条件
			$comwhere['pid']        = $v['id'];//封装当前职位信息的id
			$num                    = $comment->where($comwhere)->count();
			$hotjob[$k]['flushnum'] = $num;    //将刷新字段的值在此临时设置成评论统计条数
			//学历
			$eid               = getTagInfo($v['eid']);
			$hotjob[$k]['eid'] = $eid['tagname'];
			//城市
			$city                 = getCityInfo($v['cityid']);
			$hotjob[$k]['cityid'] = $city['name'];
			//显示时间

			$hotjob[$k]['edittime'] = tranTime($hotjob[$k]['edittime']);

		}
		$this->assign("hotjob",$hotjob);
		//dump($hotjob);
		//登录后
		$user=$_SESSION['user'];
		$usertype= $user['usertype'];
		$this->assign("usertype",$usertype);
		$company=$this->company;
		$this->assign("company",$company);
		//头像
		$photo=defaultPhoto($user['id']);
		$userphoto=$photo['photo'];
		$this->assign("userphoto",$userphoto);

		$this->display();
	}

	//加载 全部 北京 上海 广州 深圳 杭州 城市下的职位列表
	public function city() {
		/*if (!$_GET['cityid'] == 0) {
			$where['cityid'] = $_GET['cityid'];
		}*/
		if (!$_GET['cityid'] == 0 && !$_GET['cityid'] == null) {
			$where['cityid'] = $_GET['cityid'];
			$where['status'] = 1;
		}else{
			$where['status'] = 1;
		}

		$hjob            = D("job");
		$hotjob          = $hjob->relation(true)->where($where)->order('edittime desc')->limit(0, 15)->select();
		foreach ($hotjob as $k => $v) {
			//月薪
			$hotjob[$k]['payid'] = number_format($v['payid'] * 1000);
			//分类
			$category = getCateInfo($v['cid']);
			$hotjob[$k]['cid'] = $category['name'];
			//工作经历
			$year = getTagInfo($v['year']);
			if ($year['id'] == 29) {//将0年改为“不限”
				$hotjob[$k]['year'] = "不限";
			} else {
				$hotjob[$k]['year'] = $year['tagname'];
			}
			//统计被评论次
			$comment                = M("comment");
			$comwhere['mid']        = C('JOB');//封装模块id查询条件
			$comwhere['pid']        = $v['id'];//封装当前职位信息的id
			$num                    = $comment->where($comwhere)->count();
			$hotjob[$k]['flushnum'] = $num;    //将刷新字段的值在此临时设置成评论统计条数
			//学历
			$eid               = getTagInfo($v['eid']);
			$hotjob[$k]['eid'] = $eid['tagname'];
			//城市
			$city                 = getCityInfo($v['cityid']);
			$hotjob[$k]['cityid'] = $city['name'];
			//显示时间
			$hotjob[$k]['edittime'] = tranTime($hotjob[$k]['edittime']);

		}
		//echo json_encode($hotjob);
		$this->ajaxReturn($hotjob);
	}
}