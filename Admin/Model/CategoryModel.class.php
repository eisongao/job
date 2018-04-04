<?php
/*
 * 分类模型类
 * @author    Leo
 * @filename DemoModel.class.php
 * @Created  2014/12/28 18:20
 */
namespace Admin\Model;

use Think\Model;

class CategoryModel extends Model {

	//自动验证
	protected $_validate = array(
		array('module', 'require', '请选择所属模块'),
		array('pid', 'require', '请选择上级分类'),
		array('name', 'require', '请填写分类名称'),
	);

}
