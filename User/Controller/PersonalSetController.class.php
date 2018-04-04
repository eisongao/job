<?php
/**
 * 个人账号设置
 * @author    Frank
 * @filename  PersonalSet.php
 * @Created   2015/1/14 6:19
 */
namespace User\Controller;

use Think\Controller;

class PersonalSetController extends CommonController {
	/**
	 * 账号设置首页
	 */
	public function index() {
		$uid               = session('user.id');
		$userinfo          = M('user')->where('id=' . $uid)->field('username,email,alias,photo')->find();
		$userinfo['photo'] = defaultPhoto($uid)['photo'];
		$this->assign('userinfo', $userinfo);
		$this->display();
	}

	/**
	 * 修改密码页
	 */
	public function editPassword() {
		$this->display('password');
	}

	/**
	 * 执行密码修改
	 */
	public function password() {
		$do = D("Password");
		if (!I('old_password')) {
			$this->error("请填写原密码");
			exit;
		}
		if (!preg_match('/^\S{6,12}$/', I('password'))) {
			$this->error("新密码格式错误");
			exit;
		}
		if (!I('re_password')) {
			$this->error("请重复填写新密码");
			exit;
		}
		if (I("password") != I('re_password')) {
			$this->error("两次输入的新密码不一致");
			exit;
		}
		$old_password = $do->where('id=' . session('user.id'))->getField("password");
		if (md5(I('old_password')) != $old_password) {
			$this->error("原密码输入错误");
			exit;
		}
		$do->where('id=' . session('user.id'))->setField("password", md5(I('password')));
		$this->success("密码修改成功", $_SERVER['HTTP_REFERER']);
	}

	/**
	 * 图片上传
	 */
	public function uploadLogo() {

		//配置上传参数
		$config = array(
			// 允许上传的文件后缀
			'allowExts' => array('jpg', 'jpeg', 'gif', 'png'),
			//'autoSub'   => false,
			// 图片文件保存目录
			'rootPath'  => C('UPLOAD_PATH') . 'Picture/photo_tmp/',
		);

		//实例化上传类
		$do = new \Think\Upload($config);

		//执行上传
		$info = $do->uploadOne($_FILES['logo']);
            // dump($_FILES['logo']);die;

		//返回结果
		if ($info) {
			//生成缩略图文件名
			$thumb = pathinfo($info["savename"], PATHINFO_FILENAME) . "_thumb.";
			$thumb .= pathinfo($info["savename"], PATHINFO_EXTENSION);
			//生成缩略图
			$image = new \Think\Image();
			$image->open(C("UPLOAD_PATH") . '/Picture/photo_tmp/' . $info['savename']);
			$image->thumb(180, 180)->save(C("UPLOAD_PATH") . "/Picture/photo_tmp/" . $thumb);
			//删除原图
			unlink(C("UPLOAD_PATH") . "/Picture/photo_tmp/" . $info["savename"]);
			$info['path']     = C('IMG_URL') . 'photo_tmp/' . $thumb;
			$info['width']    = $image->width();
			$info['height']   = $image->height();
			$info['savename'] = $thumb;
			$this->ajaxReturn(array(
				//上传后的返回信息
				'info'   => $info,
				'status' => "1",
			));
		} else {
			$this->ajaxReturn(array(
				'status' => $do->getError(),
			));
		}
	}

	/**
	 * 保存logo图片
	 */
	public function  saveLogo() {
		$image = new \Think\Image();
		$image->open(C("UPLOAD_PATH") . '/Picture/photo_tmp/' . I('origin_image_name'));
		$savepath = C("UPLOAD_PATH") . '/Picture/photo/';
		if (!file_exists($savepath)) {
			mkdir($savepath, 0777, true);
		}
		$res = $image->crop(I('w'), I('h'), I('x1'), I('y1'))->save($savepath . I('origin_image_name'));
		if ($res) {
			//删除原图
			unlink(C("UPLOAD_PATH") . '/Picture/photo_tmp/' . I('origin_image_name'));
			//获取原Logo路径
			$oldpath = M('user')->where('id=' . session('user.id'))->getField("photo");
			$oldpath = "." . $oldpath;

			//Logo路径导入数据库
			$photo_path = C('IMG_URL') . 'photo/' . I('origin_image_name');
			$set        = M('user')->where('id=' . session('user.id'))->setfield("photo", $photo_path);
			//删除原logo
			if ($set && file_exists($oldpath)) {
				unlink($oldpath);
			}
			$this->ajaxReturn(array(
				'info'   => $photo_path,
				'status' => 1
			));

		}
	}

}