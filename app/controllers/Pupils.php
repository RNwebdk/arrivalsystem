<?php

class Pupils extends Controller{

	public $data = [];

	public function __construct(){
		if (!isLoggedIn()) {
		 	//redirect to the default index
		 	redirect('pages/index');
		 	exit;
		 } 
		$this->pupilModel = $this->model('Pupil');
		$this->gradeModel = $this->model('Grade');
		
	}

	public function index(){
		// Init data
        $this->data = [
          'allPupils' => [],
          'allGrades' => $this->gradeModel->getGrades(),
          'pupilName' => '',
        ];
        
        // Load View
        $this->view('pupils/index', $this->data);
	}

	public function create(){
		$this->addAndEdit("INSERT");
	}

	public function addAndEdit($action = "INSERT"){
		// check if POST
		if ($_SERVER['REQUEST_METHOD'] == "POST") {

			// sanitize POST
			//$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
			$grade =  filter_input(INPUT_POST, 'gradeSelect', FILTER_VALIDATE_INT);
			$pupilName = filter_input(INPUT_POST, 'pupilName', FILTER_SANITIZE_STRING);

			// CSRF protection (if token check return false, it did not match)
      if (!Token::check("token", $_POST['token'])) {
        // someone is trying to preform a cross-site request forgery
        die("Session token has expired, refresh the page");
      }

      if ($action === "INSERT") {
        $this->data = [
          'allPupils' 	=> $this->pupilModel->getpupils(),
          'allGrades' 	=> $this->gradeModel->getGrades(),
          'gradeSelect'	=> trim($grade),
          'pupilName' 	=> trim($pupilName)
        ];
      }else{

        $this->data['allGrades']		= $this->gradeModel->getGrades();
      	$this->data['pupilName'] 		= trim($_POST['pupilName']);
        $this->data['gradeSelect'] 		= trim($_POST['gradeSelect']);
        $this->data['pupilNameError'] 	= '';
      }
			
      // Validate pupilName
      if(empty($this->data['pupilName'])){
        $this->data['pupilNameError'] = 'The field must not be left blank';
      }


      // Validate Grade has a value, and it exist
      if (empty($this->data['gradeSelect']) || !$this->gradeModel->getGradeById($this->data['gradeSelect'])){
        $this->data['gradeError'] = 'Select a grade level for the student';
      }

      // Make sure all POST inputs has no errors and is empty
      if(empty($this->data['pupilNameError']) && empty($this->data['gradeError'])) {
      	
      	if ($action === "INSERT") {

      		if ($this->pupilModel->createPupil($this->data)) {
				flash('create_success', 'Student was created!');
        			redirect('pupils/index');
        	}else{
        		die("Something went wrong");
        	}

      	}else {
      		// Else update
      		if ($this->pupilModel->updatePupil($this->data)) {
				flash('update_success', 'The student was changed!');
        			redirect('pupils/index');
        	}else{
        		die("Something went wrong");
        	}

      	}
			}else{
				// show the page with the new errors
      	$this->view('pupils/index', $this->data);
			}
		}else{
			// If not a post request

			// Init data
	        $this->data = [
	          'allPupils' => [],
	          'allGrades' => $this->gradeModel->getGrades(),
	          'pupilName' => '',
	        ];
	        
	        // Load View
	        $this->view('pupils/index', $this->data);
		}
	}

	public function edit($id = 0){
		$id = filter_var($id, FILTER_VALIDATE_INT);
		if ($id <= 0){
			redirect('pupils/index');
		}

		// Get data from ID

		if ($pupilData = $this->pupilModel->getPupilById($id)) {
			$this->data = [
	          'allPupils' => [],
			  'allGrades' => $this->gradeModel->getGrades(),
			  'gradeSelect'	=> $pupilData->gradeId,
	          'pupilId' => $pupilData->id,
	          'pupilName' => $pupilData->name,
	          'pupilNameError' => ''
	        ];
			
			// Load View
		    $this->view('pupils/edit', $this->data);
		}else{
			redirect('pupils/index');
		}
	}
	
	public function update($id = 0){
		if ($_SERVER['REQUEST_METHOD'] == "POST") {
			$id = filter_var($id, FILTER_VALIDATE_INT);
			if ($id <= 0){
				redirect('pupils/index');
			}
			
			// find the pupil to check if he/she exist
			if ($pupilData = $this->pupilModel->getPupilById($id)) {

				$this->data['pupilId'] = $pupilData->id;

				$this->addAndEdit('UPDATE');

			}else{
				redirect('pupils/index');
			}
		}else{
			redirect("pupils/index");
		}
	}



	public function remove($id = 0){
		$id = filter_var($id, FILTER_VALIDATE_INT);
		if ($id <= 0){
			redirect('pupils/index');
		}

		// check if ID exists
		if ($this->pupilModel->getPupilById($id)) {
			$this->pupilModel->deletePupil($id);

			flash('delete_success', 'The student was deleted');
            redirect('pupils/index');

		}else{
			redirect('pupils/index');
		}
	}

	public function getPupilsWithGrades($gradeId){
		// Validate id from user before running query
		$gradeId = filter_var($gradeId, FILTER_VALIDATE_INT);
		if ($gradeId <= 0){
			redirect('pupils/index');
		}

		if ($pupils = $this->pupilModel->getPupilsByGradeId($gradeId)) {
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode($pupils);
		}else{
			header("HTTP/1.0 404 Not Found");
		}

	}

	public function allpupils($id){
		$id = filter_var($id, FILTER_VALIDATE_INT);
		if ($id <= 0){
			redirect('pupils/index');
		}

		$this->getPupilsWithGrades($id);
	}


}