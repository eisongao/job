<?php
/*
 * 角色模型类
 * @author     Leo
 * @Created  2015/1/3
 */
namespace Admin\Model;

use Think\Model;

class NodeModel extends Model {

	//自动验证
	protected $_validate = array(
		array('name', 'require', '请填写节点名称'),
		array('title', 'require', '请填写节点描述'),
	);

}
