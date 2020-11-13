<?php
if($usernameCount == 0) {
	echo $html->image('success.png', array('id'=>'usernameValidateImg', 'class'=>'validateImg', 'title'=>'Nombre de usuario disponible'));
} else {
	echo $html->image('error.png', array('id'=>'usernameValidateImg', 'class'=>'validateImg username-fail', 'title'=>'El nombre de usuario no está disponible'));
}
?>
