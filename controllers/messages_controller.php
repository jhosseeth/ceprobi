<?php
class MessagesController extends AppController {

	var $name = 'Messages';
	var $paginate = array('order'=>array('Message.id'=>'desc'));
	var $authMap = array(
		'Administrador'=>array('index', 'edit')
	);

	function index() {
		$messages = $this->Message->find('all', array('order'=>'Message.id ASC'));
		$this->set(compact('messages'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('InvalidMessage',true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Message->save($this->data)) {
				$this->Session->setFlash('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button><img class="flashImg" alt="" src="/img/success.png">¡Mensaje guardado correctamente!</div>');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button><img class="flashImg" alt="" src="/img/alert.png"><strong>¡Lo sentimos!</strong> El mensaje no pudo ser guardado correctamente.</div>');
				$this->redirect(array('action' => 'index'));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Message->find('first', array('conditions'=>array('Message.id'=>$id), 'recursive'=>0));
		}
	}
}
?>