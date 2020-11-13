<?php
class Role extends AppModel {
	var $name = 'Role';
//	var $displayField = 'rol';
	var $actsAs = array('Acl' => array('type' => 'requester'));

	var $validate = array(
		'rol' => array(
			'notempty' => array('rule' => array('notempty'))
		),
	);

	public function parentNode() {
		return null;
	}
}
?>