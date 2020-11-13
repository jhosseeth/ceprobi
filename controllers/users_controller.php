<?php
class UsersController extends AppController {

	var $name = 'Users';
	var $paginate = array('order'=>array('User.id'=>'desc'));
	var $authMap = array(
		'Administrador'=>array('*'),
		'Autor'=>array('edit', 'subscribe'),
		'Revisor'=>array('edit', 'subscribe'),
		'*' => array('index','view','add')
	);

	function beforeFilter() {
		$this->Auth->userScope = array('User.status' => 1);
		parent::beforeFilter();
	}

    function afterFilter() {
        if($this->action == 'login') {
            $this->_loadSession();
        }
        parent::afterFilter();
    }

	function index($conditions = null) {
		$this->User->recursive = 0;
		$this->set('users', $this->paginate(null, $conditions));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash('<div class="alert alert-error"><img class="flashImg" alt="" src="/img/alert.png"><strong>¡Lo sentimos!</strong> Id de usuario inválida.</div>');
			$this->redirect(array('action' => 'index'));
		}
		$user = $this->User->find('first', array('conditions'=>array('User.id'=>$id), 'recursive'=>0));
		$this->paginate = array('Article' => array('order' => array('Article.id' => 'desc')));
		$this->loadModel('Article');
		$conditions = array('Article.status' => 1, 'OR'=>array('Article.autor_user_id'=>$id, 'Article.revisor_user_id'=>$id));
		$articles =  $this->paginate('Article', $conditions);
//		$articles = $this->Article->find('all', array('conditions'=>array('OR'=>array('Article.autor_user_id'=>$id, 'Article.revisor_user_id'=>$id))));
		$this->set(compact('user','articles'));
	}

	function add() {
		if (!empty($this->data)) {
			$this->log($this->data, LOG_DEBUG);
			$this->User->create();
			if ($this->User->save($this->data)) {
				$this->Session->setFlash('<div class="alert alert-success"><img class="flashImg" alt="" src="/img/success.png">Usuario guardado correctamente.</div>');
				$this->redirect('/');
			} else {
				$this->Session->setFlash('<div class="alert alert-error"><img class="flashImg" alt="" src="/img/alert.png"><strong>¡Lo sentimos!</strong> El usuario no pudo ser guardado correctamente.</div>');
			}
		}
		$this->buildList();
	}

	function edit($id = null) {
		if ($_SESSION['Auth']['Role']['name'] == 'Administrador' || $_SESSION['Auth']['User']['id'] == $id) {
			if (!$id && empty($this->data)) {
				$this->Session->setFlash('<div class="alert alert-error"><img class="flashImg" alt="" src="/img/alert.png"><strong>¡Lo sentimos!</strong> Número interno inválido.</div>');
				$this->redirect(array('action' => 'index'));
			}
			if (!empty($this->data)) {
				if ($this->data['User']['password'] == '81b414ae6322a09c1fcfb1fa8146e98ca546bf4e') unset($this->data['User']['password']); //destruye la contraseña si está vacía
				if (empty($this->data['User']['photo']['name'])) unset($this->data['User']['photo']); //destruye la foto si está vacía
				if ($this->User->save($this->data)) {
					$this->Session->setFlash('<div class="alert alert-success"><img class="flashImg" alt="" src="/img/success.png">Usuario guardado correctamente.</div>');
					$this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash('<div class="alert alert-error"><img class="flashImg" alt="" src="/img/alert.png"><strong>¡Lo sentimos!</strong> El usuario no pudo ser guardado correctamente.</div>');
				}
			}
			if (empty($this->data)) {
				$this->data = $this->User->find('first', array('conditions'=>array('User.id'=>$id), 'recursive'=>0));
				unset($this->data['User']['password']); //destruye la contraseña
			}
		} else {
			$this->Session->setFlash('<div class="alert alert-error"><img class="flashImg" alt="" src="/img/alert.png"><strong>¡Lo sentimos!</strong> Ud no tiene permisos para editar otros usuarios.</div>');
			$this->redirect(array('action' => 'edit', $_SESSION['Auth']['User']['id']));
		}	
		$this->buildList();
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash('<div class="alert alert-error"><img class="flashImg" alt="" src="/img/alert.png"><strong>¡Lo sentimos!</strong> Id de usuario inválida.</div>');
			$this->redirect(array('action'=>'index'));
		}
		if ($this->User->delete($id)) {
			$this->Session->setFlash('<div class="alert alert-success"><img class="flashImg" alt="" src="/img/success.png">Usuario borrado correctamente.</div>');
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash('<div class="alert alert-error"><img class="flashImg" alt="" src="/img/alert.png"><strong>¡Lo sentimos!</strong> El usuario no pudo ser borrado correctamente.</div>');
		$this->redirect(array('action' => 'index'));
	}

	function buildList(){
		$roles = $this->User->Role->find('list');
		$magazines = $this->User->Magazine->find('list');
		$this->set(compact('roles','magazines'));
	}

	function _loadSession() {
        $session = $this->Session->read();
        if(!empty($session['Auth']['User'])) {
            $role = $this->User->Role->find('first', array(
                'conditions' => array('Role.id'=>$session['Auth']['User']['role_id']),
                'recursive' => -1,
            ));
            $this->Session->write('Auth.Role', $role['Role']);
            $session = $this->Session->read();
            $this->redirect('/');
        }
    }

	function login() {
    }

    function logout() {        
        $this->Session->destroy();
		$this->Cookie->destroy('CAKEPHP');
		$this->Cookie->delete('CAKEPHP');
        $this->Auth->logout();
        $this->redirect('/');
    }

    function activacion($id = null, $enable) {
		if (!$id) {
			$this->Session->setFlash('<div class="alert alert-error"><img class="flashImg" alt="" src="/img/alert.png"><strong>¡Lo sentimos!</strong> Id de usuario inválida.</div>');
			$this->redirect(array('action'=>'index'));
		}
		if ($enable == 1) {
			if ($this->User->saveField('status', 1)) {
				$this->Session->setFlash('<div class="alert alert-success"><img class="flashImg" alt="" src="/img/success.png">Usuario activado correctamente.</div>');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('<div class="alert alert-error"><img class="flashImg" alt="" src="/img/alert.png"><strong>¡Lo sentimos!</strong> El usuario no pudo ser activado correctamente.</div>');
			}
		} elseif ($enable == 0) {
			if ($this->User->saveField('status', 0)) {
				$this->Session->setFlash('<div class="alert alert-success"><img class="flashImg" alt="" src="/img/success.png">Usuario desactivado correctamente.</div>');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('<div class="alert alert-error"><img class="flashImg" alt="" src="/img/alert.png"><strong>¡Lo sentimos!</strong> El usuario no pudo ser desactivado correctamente.</div>');
			}
		}		
	}

	function subscribe($id = null, $mid) {
		if (!$id) {
			$this->Session->setFlash('<div class="alert alert-error"><img class="flashImg" alt="" src="/img/alert.png"><strong>¡Lo sentimos!</strong> No se pudo realizar la suscripción correctamente.</div>');
			$this->redirect(array('controller' => 'pages', 'action'=>'home'));
		} else {
			if ($this->User->saveField('subscription', $mid)) {

				if ($_SESSION['Auth']['Role']['name'] == 'Administrador') {
					$this->Session->setFlash('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button><img class="flashImg" alt="" src="/img/success.png">¡Suscripción rechazada correctamente!</div>');
					$this->redirect(array('controller' => 'users', 'action' => 'index'));
				} elseif ($mid == 0) {
					$_SESSION['Auth']['User']['subscription'] = 0;
					$this->Session->setFlash('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button><img class="flashImg" alt="" src="/img/success.png">¡Notificado satisfactoriamente!</div>');
					$this->redirect(array('controller' => 'pages', 'action' => 'home'));
				} else {
					$_SESSION['Auth']['User']['subscription'] = $mid;
					$this->Session->setFlash('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button><img class="flashImg" alt="" src="/img/success.png">¡Suscripción realizada correctamente!</div>');
					$this->redirect(array('controller' => 'magazines', 'action' => 'view', $mid));
				}

			} else {
				$this->Session->setFlash('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button><img class="flashImg" alt="" src="/img/alert.png"><strong>¡Lo sentimos!</strong> No se pudo realizar la suscripción correctamente.</div>');
				$this->redirect(array('controller' => 'magazines', 'action' => 'view', $mid));
			}
		}
	}

	function find_username() {
		$this->layout = 'ajax';
		$this->set('usernameCount', $this->User->find('count', array('conditions'=>array('username'=>$this->data['User']['username']))));
	}

}
?>