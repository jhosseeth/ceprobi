<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.cake.libs.controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       cake
 * @subpackage    cake.cake.libs.controller
 */
class PagesController extends AppController {

/**
 * Nombre del Controlador
 *
 * @var string
 * @access public
 */
	var $name = 'Pages';

/**
 * Helper Cargado
 *
 * @var array
 * @access public
 */
	var $helpers = array('Html');

/**
 * Modelos que usará el Controlador
 *
 * @var array
 * @access public
 */
	var $uses = array('Article', 'User', 'Magazine');

/**
 * Parametros de Paginación
 *
 * @var array
 * @access public
 */
	var $paginate = array('order'=>array('Article.id'=>'desc'));

/**
 * Vista Display(Inicio)
 *
 * @param Decide página para mostrar
 * @access public
 */
	function display() {
		$path = func_get_args();

		$count = count($path);
		if (!$count) {
			$this->redirect('/');
		}
		$page = $subpage = $title_for_layout = null;

		if (!empty($path[0])) {
			$page = $path[0];
		}
		if (!empty($path[1])) {
			$subpage = $path[1];
		}
		if (!empty($path[$count - 1])) {
			$title_for_layout = Inflector::humanize($path[$count - 1]);
		}
		if ($_SESSION['Auth']['Role']['name'] == 'Administrador') {
			$pendingArticles =  $this->Article->find('all', array('order'=>'Article.id DESC', 'conditions' => array('Article.status' => 0)));
			$pendingUsers =  $this->User->find('list', array('order'=>'User.id DESC', 'conditions' => array('User.status' => 0)));
			$pendingUsersSus =  $this->User->find('list', array('order'=>'User.id DESC', 'conditions' => array('User.subscription >' => 0)));
		} elseif ($_SESSION['Auth']['Role']['name'] == 'Autor' || $_SESSION['Auth']['Role']['name'] == 'Revisor') {
			$pendingArticles = $this->Article->find('all', array('order'=>'Article.id DESC', 'conditions' => array('Article.status' => 0, 'OR'=>array('Article.autor_user_id' => $_SESSION['Auth']['User']['id'], 'Article.revisor_user_id' => $_SESSION['Auth']['User']['id']))));
		}
		$this->loadModel('Message');
		$title_ms = $this->Message->find('first', array('conditions' => array('Message.id' => 1)));
		$general_ms = $this->Message->find('first', array('conditions' => array('Message.id' => 2)));
		$visitor_ms = $this->Message->find('first', array('conditions' => array('Message.id' => 3)));
		$conditions = array('Article.status' => 1);
		$articles =  $this->paginate('Article', $conditions);
		$magazines = $this->User->Magazine->find('list');
		$admin = $this->User->find('first', array('conditions' => array('User.role_id' => 1), 'recursive' => -1));
		$this->set(compact('page', 'subpage', 'title_for_layout', 'articles', 'pendingArticles', 'pendingUsers', 'pendingUsersSus', 'title_ms', 'general_ms', 'visitor_ms', 'admin', 'magazines'));
		$this->render(implode('/', $path));
	}
}
