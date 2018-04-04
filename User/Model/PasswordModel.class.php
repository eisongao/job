<?php
/**
 * @author    Frank
 * @version   $Id$
 * @filename  PasswordModel.class.php
 * @Created   2015/1/14 23:01
 */

namespace User\Model;

use Think\Model;

class PasswordModel extends Model {
	protected $tableName = "user";
	//自动验证
	protected $_validate = array(
		array("password","require","请填写您的密码！"),
		array("password",'/^\S{6,12}$/',"密码至少6位！"),
		array('re_password', 'password', '重复新密码错误！',0,"confirm"),
	);

	//自动完成
	protected $_auto = array(
		array('password', 'md5', 3, 'function'),
	);
}
