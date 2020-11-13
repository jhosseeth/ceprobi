<style type="text/css">
#login {
	background-color: #F8F8F8;
	box-shadow: 0 0 40px #3A3A3A;
	border-radius: 8px;
	margin: 10% 35%;
	width: 280px;
	padding: 35px 25px 25px;
}
form { margin-left: 30px;}
.submit { margin-left: 70px;}
.container-fluid{
	background-color:#6A6A6A;
	box-shadow: none;
}
#authMessage { 
	margin-left: 40px;
	margin-bottom: 10px;
}
.navbar { box-shadow: 0 0 20px #3A3A3A;}
</style>
<div id="login">
<?php echo $session->flash('auth');?>
<?php echo $form->create('User', array('controller'=>'users', 'action' => 'login'));?>
<?php echo $form->input('username', array('div'=>'input text controls', 'placeholder'=>'Usuario', 'label'=>false));?>
<?php echo $form->input('password', array('div'=>'input text controls', 'placeholder'=>'Contraseña', 'label'=>false));?>
<?php echo $form->end(array('class'=>'btn btn-primary', 'label'=>'Entrar'));?>
<?php $admin = $this->Html->link('Administrador', array('controller' => 'users', 'action' => 'view', 6));?>
<legend></legend>
<p>Si no puede ingresar, pongase en contacto con el <strong>Administrador</strong>, o puede llenar un formulario de registro si no lo ha hecho.</p>
<?php echo $this->Html->link('Registrarse', array('controller' => 'users', 'action' => 'add'), array('class' => ''));?>
</div>