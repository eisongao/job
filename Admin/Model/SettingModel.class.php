<?php
/*
 * @author    Leo
 * @filename DemoModel.class.php
 * @Created  2014/12/28 18:20
 */
namespace Admin\Model;

use Think\Model;

class SettingModel extends Model {

	protected $tableName = "User";

	//自动验证
	protected $_validate = array(
		array('old_password', 'require', '请填写原密码'),
		array('password', 'require', '请填写新密码'),
		array('repassword', 'password', '重复新密码错误',0,"confirm"),
	);
	//自动完成
	protected $_auto = array(
		array('password', 'md5', 1, 'function'),
	);

}

