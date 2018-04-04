<?php
/**
 * 用于验证个人简求工作经历信息
 * @author    Frank
 * @filename  WorkModel.php
 * @Created   2015/1/13 15:58
 */
namespace User\Model;

use Think\Model;

class WorkModel extends Model {
	protected $tableName = "resume_work";
	protected $_validate = array(
		array('comname', 'require', '请填写所有必填项', 3),
		array('job', 'require', '请填写所有必填项', 3),
		array('pay', 'require', '请填写所有必填项', 3),
		array('syear', 'require', '请填写所有必填项', 3),
		array('smonth', 'require', '请填写所有必填项', 3),
		array('tyear', 'require', '请填写所有必填项', 3),
		array('wdesc', 'require', '请填写所有必填项', 3),
	);
}