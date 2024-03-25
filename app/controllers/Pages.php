<?php
  class Pages extends Controller{

    public function __construct(){
      if(isLoggedIn()){
        redirect("users/index");
        exit;
      }
     $this->userModel = $this->model('User');
    }

    // Load Homepage
    public function index(){
      // Check if logged in
      
      // Check if POST
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $this->attemptLogin();
      } else {
        // If NOT a POST

        // Init data
        $data = [
          'email' => '',
          'password' => '',
          'email_err' => '',
          'password_err' => '',
        ];

        // if checksystem is active, get grades
        if (isset($_SESSION['checkSystem']) && $_SESSION['checkSystem']) {
          $data['allGrades'] = $this->model('Grade')->getGrades();
        }

        // Load View
        $this->view('pages/multi', $data);
      }
    }

    public function login(){
        // Init data
        $data = [
          'email' => '',
          'password' => '',
          'email_err' => '',
          'password_err' => '',
        ];
      if (isset($_SESSION['checkSystem']) && $_SESSION['checkSystem']) {

        $this->view("pages/login", $data);
      }else{
        $this->view("pages/multi", $data);
      }
    }

    public function attemptLogin(){
      // Sanitize POST
      $_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      // CSRF protection (if token check return false, it did not match)
      if (!Token::check("token", $_POST['token'])) {
        // someone is trying to preform a cross-site request forgery
        die("Session token has expired, refresh the page");
      }
      
      $data = [       
        'email' => trim($_POST['email']),
        'password' => trim($_POST['password']),        
        'email_err' => '',
        'password_err' => '',       
      ];

      // Check for email
      if(empty($data['email'])){
        $data['email_err'] = 'Enter an e-mail address';
      }

      // Check for user
      if($this->userModel->findUserByEmail($data['email'])){
        // User Found
      } else {
        // No User
        $data['email_err'] = 'Email does not exist in the system';
      }

      // Make sure errors are empty
      if(empty($data['email_err']) && empty($data['password_err'])){

        // Check and set logged in user
        $loggedInUser = $this->userModel->findUser($data['email'], $data['password']);

        if($loggedInUser){
          // User Authenticated!
          createUserSession($loggedInUser);
          redirect('users/index');
       
        } else {
          $data['password_err'] = 'incorrect login information, try again';
          $data['password'] = '';
          // Load View, incorrect password
          $this->redirectToLogin($data);
        }
      } else {
        // Load View, there was errors
        // if checkin is activated, redirect to the login page there
        $this->redirectToLogin($data);
      } 
    }

    public function redirectToLogin($data){
      if (isset($_SESSION['checkSystem']) && $_SESSION['checkSystem']) {
          $this->view('pages/login', $data);
        }else{
          $this->view('pages/multi', $data);
        }
    }


    public function pupils($gradeId = 0){
      if (isset($_SESSION['checkSystem']) && $_SESSION['checkSystem']) {

        // Validate id from grade before running query
        $gradeId = filter_var($gradeId, FILTER_VALIDATE_INT);
        if ($gradeId <= 0){
          header("HTTP/1.0 404 Not Found");
        }

        if ($pupils = $this->model("Pupil")->getPupilsByGradeId($gradeId)) {
          header('Content-Type: application/json; charset=utf-8');
          $results = [
            'status' => 'success',
            'pupils' =>  $pupils
          ];
          echo json_encode($results);
        }else{
         $results = [
            'status' => 'success',
            'pupils' =>  []
          ];
          echo json_encode($results);
        }
      }else{
        header("HTTP/1.0 404 Not Found");
      }

    }
    
    public function checkIn($id = 0, $checkStatus = 0){
      if (isset($_SESSION['checkSystem']) && $_SESSION['checkSystem']) {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        $checkStatus = filter_var($checkStatus, FILTER_VALIDATE_BOOLEAN);

        if ($id <= 0 || $checkStatus < 0){
          header("HTTP/1.0 404 Not Found");
          exit;
        }


        if ($pupil = $this->model("Pupil")->getPupilById($id)) {

          $checkStatus = $checkStatus ? 1 : 0;
          $currentStatus = (int)$pupil->checked;
          // check if the student already has the posted status from another device
          // only if not, change the status, else ignore and simulate a toggle
          // (on pupilupdate, it will get the newest data and be uptodate)
            
          if ($checkStatus != $currentStatus) {
            $newStatus = !$pupil->checked;
            $this->model("Pupil")->toggleCheckStatus($id, $newStatus);
          }

          $results = [
            'status' => 'success',
            'pupil' =>  $pupil
          ];

          header('Content-Type: application/json');
          echo json_encode($results);

        }else{
          $results = [
            'status' => 'success',
            'pupils' =>  []
          ];
          echo json_encode($results);
        }
      }else{
        header("HTTP/1.0 404 Not Found");
      }
    }


  }