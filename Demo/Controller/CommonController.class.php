<?php
/*
 * 后台基础控制器
 * @author     Leo
 * @Created  2014/12/28
 */
namespace Demo\Controller;

use Common\Controller\BaseController;

class CommonController extends BaseController {

	/**
	 * 初始化
	 */
	public function _init() {

		//登陆判断
		/* if (!$_SESSION["admin"]) {
			$this->redirect("Login/index");
			exit;
		} */
		//获取管理员数据
		$this->assign("user", $_SESSION["admin"]);
	}
}