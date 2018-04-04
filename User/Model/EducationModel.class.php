<?php
/**
 * 用于验证个人简求教育经历信息
 * @author    Frank
 * @filename  EducationModel.php
 * @Created   2015/1/13 15:58
 */
namespace User\Model;

use Think\Model;

class EducationModel extends Model {
	protected $tableName = "resume_edu";
	protected $_validate = array(
		array('school', 'require', '请填写所有必填项', 3),
		array('specialty', 'require', '请填写所有必填项', 3),
		array('seid', 'require', '请填写所有必填项', 3),
		array('syear', 'require', '请填写所有必填项', 3),
		array('smonth', 'require', '请填写所有必填项', 3),
		array('tyear', 'require', '请填写所有必填项', 3),
		array('tmonth', 'require', '请填写所有必填项', 3),
	);
}