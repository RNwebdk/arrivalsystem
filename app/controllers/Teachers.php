<?php

class Teachers extends Controller{

	public $data = [];

	public function __construct(){
    if (!isLoggedIn()) {
      //redirect to the default index
      redirect('pages/index');
      exit;
    } 

    $this->teacherModel = $this->model('Teacher');

	}

	public function index(){
		$this->data = [
			'allTeachers' 		=> $this->teacherModel->getTeachers(),
			'firstName' 			=> "",
			'lastName' 				=> "",
			'email' 					=> "",
			'password' 				=> "",
			'passwordRepeat'	=> "",
		];

		$this->view("teachers/index", $this->data);
	}

	public function create(){
		$this->add("INSERT");
	}

	public function add(){

		if ($_SERVER['REQUEST_METHOD'] == "POST") {

			// sanitize POST
			$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

			// CSRF protection (if token check return false, it did not match)
      if (!Token::check("token", $_POST['token'])) {
        // someone is trying to preform a cross-site request forgery
        die("Session token has expired, refresh the page");
      }
  
	    $this->data = [
				'allTeachers' 	=> $this->teacherModel->getTeachers(),
				'firstName' 		=> trim($_POST['firstName']),
				'lastName' 			=> trim($_POST['lastName']),
				'email' 				=> trim($_POST['email']),
				'password' 			=> trim($_POST['password']),
				'passwordRepeat'=> trim($_POST['passwordRepeat']),
			];

			$this->validateInputs("INSERT");
	    $this->validatePasswordFields();

	    // Make sure all POST inputs has no errors and is empty
	    if( empty($this->data['firstNameError']) &&
	    		empty($this->data['lastNameError']) &&
	    		empty($this->data['emailError']) &&
	    		empty($this->data['passwordError'])
	    	) {

	        	$this->teacherModel->createTeacher($this->data);
						flash('create_success', 'Teacher successfully created!');
	        	redirect('teachers/index');

	      }else{
					// show the page with the new errors
      		if (isset($this->data['passwordError'])) {
	  				$this->data['password'] = '';
	  				$this->data['passwordRepeat'] = '';
      		}
  				$this->view('teachers/index', $this->data);
			}
		}


	}

	public function edit($id = 0){
		$id = filter_var($id, FILTER_VALIDATE_INT);
		if ($id <= 0){
			redirect('teachers/index');
			exit;
		}

		// Get data from ID

		if ($teacherData = $this->teacherModel->getTeacherById($id)) {
			$this->data = [
        'allTeachers' 		=> $this->teacherModel->getTeachers(),
        'teacherId' 			=> $teacherData->id,
        'firstName' 			=> $teacherData->firstname,
        'lastName' 				=> $teacherData->lastname,
        'email' 					=> $teacherData->email,
        'firstNameError' 	=> flasTexthMsg('firstNameError') ?? '',
        'lastNameError' 	=> flasTexthMsg('lastNameError') ?? '',
        'emailError' 			=> flasTexthMsg('emailError') ?? '',
      ];
			
			
			// Load View
		  $this->view('teachers/edit', $this->data);
		}else{
			redirect('teachers/index');
		}


	}

	public function update($id = 0){
		if ($_SERVER['REQUEST_METHOD'] == "POST") {

			$id = filter_var($id, FILTER_VALIDATE_INT);
			if ($id <= 0){
				redirect('teachers/index');
				exit;
			}

			$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

			if ($teacherData = $this->teacherModel->getTeacherById($id)) {

				$this->data = [
					'teacherId' 			=> $id,
        	'allTeachers' 		=> $this->teacherModel->getTeachers(),
        	'teacherId' 			=> $teacherData->id,
        	'firstName' 			=> trim($_POST['firstName']),
        	'lastName' 				=> trim($_POST['lastName']),
        	'email' 					=> trim($_POST['email']),
        	'firstNameError' 	=> '',
        	'lastNameError' 	=> '',
        	'emailError' 			=> '',
        ];

				$this->validateInputs("UPDATE");

				// check for errors
				if(empty($this->data['firstNameError']) &&
	    		 empty($this->data['lastNameError']) &&
	    		 empty($this->data['emailError'])
	    	){
					if ($this->teacherModel->updateTeacher($this->data)) {
						flash('update_success', 'Teacher successfully changed!');
            redirect('teachers/index');
		      }
				}else{
					// Show errors
					$errorMessages = [
						"firstNameError" 	=> $this->data['firstNameError'],
						"lastNameError" 	=> $this->data['lastNameError'],
						"emailError" 			=> $this->data['emailError'],
					];

					foreach($errorMessages as $key => $errormsg){
						if (!empty($errormsg)) {
							flasTexthMsg($key, $errormsg);
						}
					}

          redirect('teachers/edit/' . $this->data['teacherId']);
				}
			}else{
				redirect('teachers/index');
			}
		}else{
			redirect("teachers/index");
		}
	}

	public function validateInputs($action = "INSERT"){

		// Validate firstName
	  if(empty($this->data['firstName'])){
	    $this->data['firstNameError'] = 'Firstname can\'t be empty';
	  }

	  // Validate lastName
	  if(empty($this->data['lastName'])){
	    $this->data['lastNameError'] = 'lastname can\'t be empty';
	  }

    // Validate Email
		if (empty($this->data['email'])) {
        		$this->data['emailError'] = 'Email can\'t be empty';
    	}else{
        	if (!filter_var($this->data['email'], FILTER_VALIDATE_EMAIL)) {
				$this->data['emailError'] = 'invalid email, please enter a valid email address.';
			}

    		//check if email name already excist (UPDATE)
    		if ($action === "INSERT") {
				//INSERT
				$emailExist = $this->teacherModel->emailAlreadyExist($_POST['email']);
			}else{
				// UPDATE
    			$emailExist = $this->teacherModel->emailAlreadyExist($_POST['email'], $this->data['teacherId']);

			}

			if ($emailExist) {
	        	$this->data['emailError'] = 'This email already exists, please choose another';
	        }

    	}
		
	}

	public function validatePasswordFields(){
		// Validate Password
    if(empty($this->data['password']) || 
    	 empty($this->data['passwordRepeat'])
    ){
      $this->data['passwordError'] = 'Both password fields must be filled!';
    }

    //If both password fields is NOT empty
    if (!empty($this->data['password']) && !empty($this->data['passwordRepeat'])) {
    	//if password and password repeat is NOT equal
      if ($this->data['password'] !== $this->data['passwordRepeat']) {
      	$this->data['passwordError'] = "Whoops, please enter the same password in both fields";
      }
    }

	}

	public function remove($id = 0){

		$id = filter_var($id, FILTER_VALIDATE_INT);
		if ($id <= 0){
			redirect('teachers/index');
			exit;
		}

		// check if ID exists
		if ($this->teacherModel->getteacherById($id)) {
			
			//check if teacher is admin, if yes, restict deletion
			if ($this->teacherModel->isAdmin($id)) {

				// Don't allow to delete admins
				flash('delete_failed', 'What are you doing? :D don\'t saw the branch you\'re sitting on. If you are depressed, talk to someone :P I wont allow you to hurt yourself ;)', 'alert alert-danger');
        redirect('teachers/index');

			}else{

				// Teacher is not admin and can be deleted
				$this->teacherModel->deleteTeacher($id);
				flash('delete_success', 'Teacher was deleted!');
        redirect('teachers/index');

			}

		}else{
			redirect('teachers/index');
		}
	}

	public function passwordEdit($id = 0){
		$id = filter_var($id, FILTER_VALIDATE_INT);
		if ($id <= 0){
			redirect('teachers/index');
			exit;
		}


		if ($teacherData = $this->teacherModel->getTeacherById($id)) {
			$this->data = [
	        'allTeachers' 					=> $this->teacherModel->getTeachers(),
	        'teacherId' 						=> $teacherData->id,
	        'firstName'							=> $teacherData->firstname,
	        'lastName'							=> $teacherData->lastname,
	        'currentPassword'				=> '',
        	'password'							=> '',
        	'passwordRepeat'				=> '',
        	'currentPasswordError' 	=> flasTexthMsg('currentPasswordError') ?? '',
        	'passwordError' 				=> flasTexthMsg('passwordError') ?? '',
	        ];
			
		  $this->view('teachers/passwordEdit', $this->data);
		}else{
			redirect('teachers/index');
		}

	}

	public function passwordUpdate($id = 0){
		if ($_SERVER['REQUEST_METHOD'] == "POST") {
			$id = filter_var($id, FILTER_VALIDATE_INT);
			if ($id <= 0){
				redirect('teachers/index');
				exit;
			}

			$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

			if ($teacherData = $this->teacherModel->getTeacherById($id)) {

				$this->data = [
        	'allTeachers' 					=> $this->teacherModel->getTeachers(),
        	'teacherId' 						=> $teacherData->id,
        	'firstName'							=> $teacherData->firstname,
	        'lastName'							=> $teacherData->lastname,
	        'email'									=> $teacherData->email,
        	'currentPassword'				=> trim($_POST['currentPassword']),
        	'password'							=> trim($_POST['password']),
        	'passwordRepeat'				=> trim($_POST['passwordRepeat']),
        	'passwordMatchError' 		=> '',
        	'currentPasswordError' 	=> '',
        ];
				$isCorrectPassword = $this->teacherModel->passwordCorrect($this->data['email'], $this->data['currentPassword']);
				
				if (!$isCorrectPassword) {
					$this->data['currentPasswordError'] = "Wrong password, try again";
				}

				$this->validatePasswordFields();

				// check for errors
				if(empty($this->data['passwordError']) && empty($this->data['currentPasswordError']))
				{
					if ($this->teacherModel->updateTeacherPassword($this->data)) {
						flash('update_success', 'password successfully changed!');
            redirect('teachers/index');
		      }
	    	}else{
	    		// Show errors
					$errorMessages = [
						"passwordError" 				=> $this->data['passwordError'],
						"currentPasswordError" 	=> $this->data['currentPasswordError']
					];


					foreach($errorMessages as $key => $errormsg){
						if (!empty($errormsg)) {
							flasTexthMsg($key, $errormsg);
						}
					}

					redirect('teachers/passwordedit/' . $this->data['teacherId']);

	    	}
			}else{
				redirect('teachers/index');
			}


		}
	}

}