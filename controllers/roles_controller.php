<?php
class RolesController extends AppController {

	var $name = 'Roles';
	var $paginate = array('order'=>array('Role.id'=>'desc'));

	function index($conditions = null) {
		$this->Role->recursive = 0;
		$this->set('roles', $this->paginate(null, $conditions));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash('Id invalida');
			$this->redirect(array('action' => 'index'));
		}
		$this->set('role', $this->Role->find('first', array('conditions'=>array('Role.id'=>$id), 'recursive'=>0)));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Role->create();
			if ($this->Role->save($this->data)) {
				$this->Session->setFlash('Rol guardado');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('El rol no pudo ser guardado');
			}
		}
		$this->buildList();
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('InvalidMessage',true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Role->save($this->data)) {
				$this->Session->setFlash('Rol guardado');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('El rol no pudo ser guardado');
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Role->find('first', array('conditions'=>array('Role.id'=>$id), 'recursive'=>0));
		}
		$this->buildList();
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash('Id invalida');
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Role->delete($id)) {
			$this->Session->setFlash('Rol eliminado');
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash('El rol no pudo ser eliminado');
		$this->redirect(array('action' => 'index'));
	}

	function buildList(){
	}

}
?>