<?php
class User extends AppModel {
	var $name = 'User';
	var $validate = array(
		'name' => array(
			'alpha' => array(
				'rule' => array('custom', '/^[A-z ñáéíóúü]+$/'),
                'message' => 'Sólo letras.'
				),
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Falta nombre'
				)
		),
		'last_names' => array(
			'alpha' => array(
				'rule' => array('custom', '/^[A-z ñáéíóúü]+$/'),
                'message' => 'Sólo letras.'
				),
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Faltan apellidos'
				)
		),
		'username' => array(			
			'minLength' => array(
				'rule' => array('minLength', '5'),
				'message' => 'Largo mínimo de 5 caracteres'
				),
			'alphaNumeric' => array(
				'rule' => 'alphaNumeric',
                'message' => 'Sólo letras y números'
				),
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'El usuario no puede estar vacío'
				)			
		),
		'email' => array(
			'email' => array(
		        'rule' => array('email', true),
		        'message' => 'Por favor indique una dirección válida.'
		    ),
		    'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'El e-mail no puede estar vacío'
				)
		),
		'birth_date' => array(
			'date' => array('rule' => array('date'))
		),
		'adress' => array(
			'alpha' => array(
				'rule' => array('custom', '/^[A-z ñáéíóúü\,\.]+$/'),
                'message' => 'Sólo letras, puntos ó comas'
				),
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Falta el lugar de residencia'
				)
		),
		'education_degree' => array(
			'alpha' => array(
				'rule' => array('custom', '/^[A-z ñáéíóúü\,\.]+$/'),
                'message' => 'Sólo letras, puntos ó comas.'
				),
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Falta información académica'
				)
		),
		'photo' => array(
			'image' => array(
				'rule' => array('extension', array('jpeg', 'png', 'jpg')),
				'message' => 'Por favor indique una imágen válida.'
				)
		)
	);

	var $belongsTo = array(
		'Role' => array('className' => 'Role',	'foreignKey' => 'role_id'),
		'Magazine' => array('className' => 'Magazine',	'foreignKey' => 'magazine_id')
	);

	var $actsAs = array('FileBind');

	function beforeSave() {
		if(empty($this->data['User']['photo'])) {
			unset($this->data['User']['photo']);
		} else {
			$this->log($this->data['User']['photo'], LOG_DEBUG);
			$this->data['User']['photo'] = $this->saveFile('User', 'photo');
		}

		return true;
	}

	function parentNode() {
		if (!$this->id && empty($this->data)) {
			return null;
		}
		if (isset($this->data['User']['role_id'])) {
			$roleId = $this->data['User']['role_id'];
		} else {
			$roleId = $this->field('role_id');
		}
		if (!$roleId) {
			return null;
		} else {
			return array('Role' => array('id' => $roleId));
		}
	}

	function bindNode($user) {
		return array('model' => 'Role', 'foreign_key' => $user['User']['role_id']);
	}


}
?>