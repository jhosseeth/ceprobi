<?php
class FileBindBehavior extends ModelBehavior {

	var $mimeTypes = array(
		'image/png' =>	'png',
		'image/jpeg'=>	'jpeg',
		'image/jpg' =>	'jpg',
		'text/plain' => 'txt',
		'application/pdf' => 'pdf',
		'application/msword' => 'doc',
		'' => 'pdf',
		'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx'
	);

	function setup(&$model, $config = array()) {	}

	/**
	 *
	 * Guarda un archivo y devuelve la ruta para el apache.
	 * @param Object $model Referencia del modelo que llama este Behavior.
	 * @param String $modelAlias Alias del modelo como se guardará el archivo.
	 * @param String $modelField Campo que contiene el archivo.
	 */
	function saveFile(&$model, $modelAlias, $modelField) {
		$file = array();
		$modelName = $model->name;
		$fileRoot = $modelAlias . '_' . $model->id . '_' . time() . "." . $this->mimeTypes[$_FILES['data']['type'][$modelName][$modelField]];
		move_uploaded_file($_FILES['data']['tmp_name'][$modelName][$modelField], WWW_ROOT . 'files' . DS . $fileRoot);	
		return '/files/' . $fileRoot;
	}

}
?>