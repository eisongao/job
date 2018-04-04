<?php
/**
 * 用于验证个人简求项目经验信息
 * @author    Frank
 * @filename  EduactionModel.php
 * @Created   2015/1/13 15:58
 */
namespace User\Model;

use Think\Model;

class ProjectModel extends Model {
	protected $tableName = "resume_pro";
	protected $_validate = array(
		array('pname', 'require', '请填写所有必填项', 3),
		array('post', 'require', '请填写所有必填项', 3),
		array('syear', 'require', '请填写所有必填项', 3),
		array('smonth', 'require', '请填写所有必填项', 3),
		array('tyear', 'require', '请填写所有必填项', 3),
		array('tmonth', 'require', '请填写所有必填项', 3),
		array('prodesc', 'require', '请填写所有必填项', 3),
	);
}