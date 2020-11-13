<?php
class Magazine extends AppModel {
	var $name = 'Magazine';
	var $validate = array(
		'name' => array(
			'notempty' => array('rule' => array('notempty'))
		),
	);

	var $hasMany = array(
		'Article' => array('className' => 'Article',	'foreignKey' => 'magazine_id',	'dependent' => false),
		'User' => array('className' => 'User',	'foreignKey' => 'magazine_id',	'dependent' => false)
	);

}
?>