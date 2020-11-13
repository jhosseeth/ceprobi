<?php
class AppController extends Controller {

	var $url = array();
	var $helpers = array('Htmlg','Html','Session','Form');
	var $components = array(
            'Auth'=>array(
                    'loginAction' => array('controller'=>'users', 'action'=>'login', 'plugin'=>false, 'admin'=>false,),
                    'logoutRedirect' => array('controller'=>'pages', 'action'=>'display', 'plugin'=>false, 'admin'=>false,),
                    'loginRedirect' => array('controller'=>'pages', 'action'=>'display', 'plugin'=>false, 'admin'=>false,),
                    'authorize'=>'actions',
                    'actionPath' => 'controllers/',
                    'authError' => 'Ud no está autorizado a acceder',
                    'loginError' => 'Usuario o Contraseña Invalido.'
			),
			'Session', 'Cookie', 'RequestHandler', 'Acl'
        );
    
    var $authMap = array();

    public function beforeFilter() {
    	$this->Auth->autoRedirect = false;
        parent::beforeFilter();
        $this->_authorizeActions($this->action);        
    }

	function beforeRender() {
		$this->set('url',$this->url);
	}

	function _authorizeActions($action) {

        $availableActions = array(
                'list_',
                'find_',
                'ajax_',
                'build',
                'graph',
                'check',
                'login',
                'logout',
                'display',
        );
        // evalua si hay sesion
        if(!isset($_SESSION)) {
                $session = $this->Session->read();
        }
        // evalua si la accion pasada esta dentro de las acciones disponibles,
        // si existe rol y existe '*' dentro del authMap o una accion dentro del authMap, 
        // o si existe '*' y la accion esta dentro del array pasado para los visitantes
        // o sino redirecciona al home e informa de no tener acceso
        if(in_array(substr($action, 0, 5), $availableActions) || in_array($action, $availableActions)) {
            $this->Auth->allow(array($action));
        } elseif (isset($this->authMap[$_SESSION['Auth']['Role']['name']]) && (
                        in_array('*', $this->authMap[$_SESSION['Auth']['Role']['name']]) ||
                        in_array($action, $this->authMap[$_SESSION['Auth']['Role']['name']])
                )
        ) {
            $this->Auth->allow(array($action));
        } elseif(isset($this->authMap['*']) && in_array($action,$this->authMap['*'])) {
        	$this->Auth->allow(array($action));
        } else {
        	$this->Session->setFlash('<div class="alert alert-error"><img class="flashImg" alt="" src="/img/alert.png"><strong>¡Lo sentimos!</strong> Necesita permisos para acceder al sitio.</div>');
        	$this->redirect('/');        	
        }
    }

}
?>