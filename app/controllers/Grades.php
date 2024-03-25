<?php

class Grades extends Controller{

	public function __construct(){

	    if (!isLoggedIn()) {
	      //redirect to the default index
	      redirect('pages/index');
	      exit;
	    } 


	    $this->gradeModel = $this->model('Grade');
	}

	public function index(){
		$data = [
			'allGrades' => $this->gradeModel->getGrades(),
			'gradeName' => ""
		];

		$this->view("grades/index", $data);
	}

	public function create(){
		$this->addAndEdit("INSERT");
	}

	public function addAndEdit($action = "INSERT"){
		if ($_SERVER['REQUEST_METHOD'] == "POST") {

			// sanitize POST
			$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

			// CSRF protection (if token check return false, it did not match)
	        if (!Token::check("token", $_POST['token'])) {
	          // someone is trying to preform a cross-site request forgery
	          die("Session token has expired, refresh the page");
	        }

	        $gradeExist = false;
	        if ($action === "INSERT") {
				$this->data = [
				  'allGrades' => $this->gradeModel->getGrades(),
		          'gradeName' => trim($_POST['gradeName']),
		        ];

	        	//check if grade name already excist (INSERT)
	        	$gradeExist = $this->gradeModel->gradeAlreadyExist($_POST['gradeName']);
	        }else{
	        		//check if grade name already excist (UPDATE)
	        		$gradeExist = $this->gradeModel->gradeAlreadyExist($_POST['gradeName'], $this->data['gradeUpdateId']);
	        }

	        // Validate name
	        if(empty($this->data['gradeName'])){
	          $this->data['gradeNameError'] = 'Grade name is empty!';
	        }

	        if ($gradeExist) {
	        	if(!empty($this->data['gradeName'])){
	        		$this->data['gradeNameError'] = 'Grade already exist, please choose another name';
	        	}
	        }

	        // Make sure all POST inputs has no errors and is empty
	        if(empty($this->data['gradeNameError'])) {
	        	if ($action === "INSERT") {

	        		if ($this->gradeModel->createGrade($this->data)) {
						flash('create_success', 'Grade Created!');
            			redirect('grades/index');
		        	}else{
		        		die("Something went wrong");
		        	}

	        	}else {

	        		if ($this->gradeModel->updateGrade($this->data)) {
						flash('update_success', 'Grade has been changed!');
            			redirect('grades/index');
		        	}else{
		        		die("Something went wrong");
		        	}

	        	}
	        }else{
				// show the page with the new errors
	        	if ($action === "INSERT") {
          			$this->view('grades/index', $this->data);
	        	}else {
	        		flash('update_failed', $this->data['gradeNameError'], 'alert alert-danger');
            		redirect('grades/edit/' . $this->data['gradeUpdateId']);
	        	}
			}

		}
	}

	public function edit($id = 0){
		$id = filter_var($id, FILTER_VALIDATE_INT);
		if ($id <= 0){
			redirect('grades/index');
		}

		// Get data from ID

		if ($gradeData = $this->gradeModel->getGradeById($id)) {
			$this->data = [
	          'allGrades' => $this->gradeModel->getGrades(),
	          'gradeId' => $gradeData->id,
	          'gradeName' => $gradeData->name,
	          'gradeNameError' => ''
	        ];
			
			
			// Load View
		    $this->view('grades/edit', $this->data);
		}else{
			redirect('grades/index');
		}
	}


	public function update($id = 0){
		if ($_SERVER['REQUEST_METHOD'] == "POST") {
			$id = filter_var($id, FILTER_VALIDATE_INT);
			if ($id <= 0){
				redirect('grades/index');
			}

			if ($gradeData = $this->gradeModel->getGradeById($id)) {

				$this->data = [
				  'gradeUpdateId' => $id,
		          'allGrades' => $this->gradeModel->getGrades(),
		          'gradeId' => $gradeData->id,
		          'gradeName' => trim($_POST['gradeName']),
		          'gradeNameError' => '',
		        ];

				$this->addAndEdit('UPDATE');
			}else{
				redirect('grades/index');
			}
		}else{
			redirect("grades/index");
		}
	}

	public function remove($id = 0){
		$id = filter_var($id, FILTER_VALIDATE_INT);
		if ($id <= 0){
			redirect('grades/index');
		}

		// check if ID exists
		if ($this->gradeModel->getGradeById($id)) {
			//check if grade has pupil, if it does, restict deletion
			$gradeHasPupils = $this->gradeModel->gradeHasPupils($id);

			if ($gradeHasPupils->Total > 0) {
				// Don't allow to delete if grade has pupils

				flash('delete_failed', 'Could not delete grade because it contains students. delete students first or move them to another class.', 'alert alert-danger');
            	redirect('grades/index');
			}else{
				// Grade is empty and can be deleted
				$this->gradeModel->deleteGrade($id);
				flash('delete_success', 'Grade deleted!');
            	redirect('grades/index');
			}


		}else{
			redirect('grades/index');
		}
	}

}