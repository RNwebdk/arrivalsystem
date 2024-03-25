<?php 	
function form_input($fields){
	if (array_key_exists("name", $fields)) {
		$name = $fields['name'];
	}else{
		$name = null;
	}

	if (array_key_exists("id", $fields)) {
		$id = $fields['id'];
	}else{
		$id = null;
	}

	if (array_key_exists("class", $fields)) {
		$class = $fields['class'];
	}else{
		$class = null;
	}

	if (array_key_exists("placeholder", $fields)) {
		$placeholder = $fields['placeholder'];
	}else{
		$placeholder = null;
	}

	if (array_key_exists("value", $fields)) {
		$value = $fields['value'];
	}else{
		$value = null;
	}

	if (array_key_exists("type", $fields)) {
		if ($fields['type'] == "text") {
			$type = "text";
		} else if($fields['type'] == "email"){
			$type = "email";
		} else if($fields['type'] == "password"){
			$type = "password";
		} else if($fields['type'] == "file"){
			$type = "file";
		} else if($fields['type'] == "submit"){
			$type = "submit";
		} 
	}

	return '<input type="'. $type .'" name="'. $name .'" id="'. $id .'" class="'. $class .'" placeholder="'. $placeholder .'" value="'. $value .'"><br>';
}

/**
 * BUTTON helper
 */

function form_button($fields){

	if (array_key_exists("name", $fields)) {
		$name = $fields['name'];
	}else{
		$name = null;
	}

	if (array_key_exists("class", $fields)) {
		$class = $fields['class'];
	}else{
		$class = null;
	}

	if (array_key_exists("id", $fields)) {
		$id = $fields['id'];
	}else{
		$id = null;
	}

	if (array_key_exists("value", $fields)) {
		$value = $fields['value'];
	}else{
		$value = null;
	}

	return '<button type="button" class="'. $class .'" id="'. $id .'" name="'. $name .'">'. $value .'</button>';

}

function form_open($action, $method, $options = [], $multipart = false){

	if ($multipart) {
		$multi = 'enctype="multipart/form-data"';
	}else{
		$multi = '';
	}


	if (array_key_exists("id", $options)) {
		$id = $options['id'];
	}else{
		$id = null;
	}

	if (array_key_exists("class", $options)) {
		$class = $options['class'];
	}else{
		$class = null;
	}

	$url = BASEURL . "/" . $action;

	return '<form method="'. $method .'" action="'. $url .'" class="' . $class .'" id="'. $id .'" '. $multi .'>';
}

function form_close(){
	return '</form>';
}

?>