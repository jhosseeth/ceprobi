<?php
class Article extends AppModel {
	var $name = 'Article';
	var $validate = array(
		'title' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'El título no puede estar vacío.'
			)
		),
		'magazine_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Por favor seleccione una revista.'
				)
		),
		'autor_user_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Por favor seleccione un autor.'
				)
		),
		'revisor_user_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Por favor seleccione un revisor.'
				)
		),
	);

	var $belongsTo = array(
		'Magazine' => array('className' => 'Magazine',	'foreignKey' => 'magazine_id'),
		'AutorUser' => array('className' => 'User',	'foreignKey' => 'autor_user_id'),
		'RevisorUser' => array('className' => 'User',	'foreignKey' => 'revisor_user_id')
	);

	var $actsAs = array('FileBind');

	function beforeSave() {
		if(empty($this->data['Article']['article']['name'])) {
			unset($this->data['Article']['article']);
		} else {
			$this->data['Article']['article'] = $this->saveFile('Article', 'article');
		}
		if(empty($this->data['Article']['photo_article']['name'])) {
			unset($this->data['Article']['photo_article']);
		} else {
			$this->data['Article']['photo_article'] = $this->saveFile('Article', 'photo_article');
		}
		return true;
	}

	function afterSave($created) {

		App::import('model', 'ArticleTag');
		$AT = new ArticleTag();
		$AT->deleteAll(array('article_id' => $this->id));
		$newTags = split(",", $this->data['Article']['tag_ids']);
		foreach ($newTags as $tagId) {
			$AT->create();
			$AT->save(array(
				'article_id' => $this->id,
				'tag_id'	 => $tagId
			));
		}

	}

}
?>