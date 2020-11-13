<?php
class MagazinesController extends AppController {

	var $name = 'Magazines';
	var $paginate = array('order'=>array('Magazine.id'=>'desc'));
	var $authMap = array(
		'Administrador'=>array('*'),
		'*' => array('index','view')
	);

	function index($conditions = null) {
		$this->loadModel('Message');
		$this->Magazine->recursive = 1;
		$magazines = $this->paginate(null, $conditions);
		$visitor_ms = $this->Message->find('first', array('conditions' => array('Message.id' => 4)));
		$user_ms = $this->Message->find('first', array('conditions' => array('Message.id' => 7)));
		$this->loadModel('User');
		$admin = $this->User->find('first', array('conditions' => array('User.role_id' => 1), 'recursive' => -1));
		$this->set(compact('magazines', 'visitor_ms', 'admin', 'user_ms'));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash('Id invalida');
			$this->redirect(array('action' => 'index'));
		}
		$this->paginate = array('Article' => array('order' => array('Article.id' => 'desc')));
		$magazine = $this->Magazine->find('first', array('conditions'=>array('Magazine.id'=>$id), 'recursive'=>0));
		$conditions = array('Article.magazine_id'=>$id, 'Article.status' => 1);
		$articles =  $this->paginate('Article', $conditions);
		$this->set(compact('magazine','articles'));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Magazine->create();
			if ($this->Magazine->save($this->data)) {
				$this->Session->setFlash('Revista guardada');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('La revista no pudo ser guardada');
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
			if ($this->Magazine->save($this->data)) {
				$this->Session->setFlash('Revista guardada');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('La revista no pudo ser guardada');
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Magazine->find('first', array('conditions'=>array('Magazine.id'=>$id), 'recursive'=>0));
		}
		$this->buildList();
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash('Id invalida');
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Magazine->delete($id)) {
			$this->Session->setFlash(__('Deleted Item',true).': '.__('Magazine',true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Not Deleted Item',true).': '.__('Magazine',true));
		$this->redirect(array('action' => 'index'));
	}

	function buildList(){
	}

}
?>