<?php
class ArticlesController extends AppController {

	var $name = 'Articles';
	var $paginate = array('order'=>array('Article.id'=>'desc'));
	var $authMap = array(
		'Administrador'=>array('*'),
		'Autor'=>array('index', 'index_pending','add','edit', 'download'),		
		'Revisor' => array('index', 'index_pending', 'publicar', 'download'),
		'*' => array('view')
	);

	function index() {
		$this->Article->recursive = 0;
		$conditions = array('Article.status' => 1);
		if ($_SESSION['Auth']['Role']['name'] != 'Administrador') {			
			$conditions = array(
				'Article.status' => 1, 
				'OR'=>array(
					'Article.autor_user_id' => $_SESSION['Auth']['User']['id'], 
					'Article.revisor_user_id' => $_SESSION['Auth']['User']['id']
				)
			);
		}	
		$this->set('articles', $this->paginate(null, $conditions));
	}

	function index_pending() {
		$this->Article->recursive = 0;
		$conditions = array('Article.status' => 0);
		if ($_SESSION['Auth']['Role']['name'] != 'Administrador') {
			$conditions = array(
				'Article.status' => 0, 
				'OR'=>array(
					'Article.autor_user_id' => $_SESSION['Auth']['User']['id'], 
					'Article.revisor_user_id' => $_SESSION['Auth']['User']['id']
				)
			);
		}	
		$this->set('articles', $this->paginate(null, $conditions));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash('<div class="alert alert-error"><img class="flashImg" alt="" src="/img/alert.png"><strong>¡Lo sentimos!</strong> Id de artícilo inválida.</div>');
			$this->redirect(array('action' => 'index'));
		}
		$this->loadModel('Message');
		$article = $this->Article->find('first', array('conditions'=>array('Article.id'=>$id), 'recursive'=>0));
		$visitor_ms = $this->Message->find('first', array('conditions' => array('Message.id' => 5)));
		$visitor_nt = $this->Message->find('first', array('conditions' => array('Message.id' => 6)));
		$this->set(compact('article', 'visitor_ms', 'visitor_nt'));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Article->create();
			if ($this->Article->save($this->data)) {
				$this->Session->setFlash('<div class="alert alert-success"><img class="flashImg" alt="" src="/img/success.png">Artículo guardado correctamente.</div>');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('<div class="alert alert-error"><img class="flashImg" alt="" src="/img/alert.png"><strong>¡Lo sentimos!</strong> El artículo no pudo ser guardado.</div>');
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
			if ($this->Article->save($this->data)) {
				$this->Session->setFlash('<div class="alert alert-success"><img class="flashImg" alt="" src="/img/success.png">Artículo guardado correctamente.</div>');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('<div class="alert alert-error"><img class="flashImg" alt="" src="/img/alert.png"><strong>¡Lo sentimos!</strong> El artículo no pudo ser guardado.</div>');
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Article->find('first', array('conditions'=>array('Article.id'=>$id), 'recursive'=>0));
		}
		$this->buildList();
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash('<div class="alert alert-error"><img class="flashImg" alt="" src="/img/alert.png"><strong>¡Lo sentimos!</strong> Id de artícilo inválida.</div>');
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Article->delete($id)) {
			$this->Session->setFlash('<div class="alert alert-success"><img class="flashImg" alt="" src="/img/success.png">Artículo eliminado correctamente.</div>');
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash('<div class="alert alert-error"><img class="flashImg" alt="" src="/img/alert.png"><strong>¡Lo sentimos!</strong> El artículo no pudo ser eliminado.</div>');
		$this->redirect(array('action' => 'index'));
	}

	function publicar($id = null) {
		if (!$id) {
			$this->Session->setFlash('<div class="alert alert-error"><img class="flashImg" alt="" src="/img/alert.png"><strong>¡Lo sentimos!</strong> Id de artícilo inválida.</div>');
			$this->redirect(array('action'=>'index'));
		}
		$data = array('Article' => array(
			'status' => 1,
			'publication_time' => date('Y-m-d H:i:s')
		));
		if ($this->Article->save($data, array('modified' => false))) {
			$this->Session->setFlash('<div class="alert alert-success"><img class="flashImg" alt="" src="/img/success.png">Artículo autorizado correctamente.</div>');
			$this->redirect(array('action' => 'index'));
		} else {
			$this->Session->setFlash('<div class="alert alert-error"><img class="flashImg" alt="" src="/img/alert.png"><strong>¡Lo sentimos!</strong> El artículo no pudo ser autorizado.</div>');
		}
	}

	function download ($title, $fileArticle) {		
		$file = explode(".", $fileArticle);
		$ext = end($file);
        $this->view = 'Media';
        $params = array(
              'id' => $fileArticle,
              'name' => $title,
              'download' => true,
              'extension' => $ext,
              'path' => 'files' . DS  
       );
       $this->set($params);
    }

	function load_articles() {		
		$recentArticles = $this->Article->find('all', array('order'=>'Article.created DESC', 'conditions' => array('Article.status' => 1)));		
		$this->set(compact('recentArticles'));
	}

	function buildList(){
		$magazines = $this->Article->Magazine->find('list');
		$autorUsers = $this->Article->AutorUser->find('list', array('conditions' => array('AutorUser.role_id' => 2)));
		$revisorUsers = $this->Article->RevisorUser->find('list', array('conditions' => array('RevisorUser.role_id' => 3)));
		$this->set(compact('magazines', 'autorUsers', 'revisorUsers'));
	}

}
?>