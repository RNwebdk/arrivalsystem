<?php

class Users extends Controller{
  
  public function __construct(){
    if (!isLoggedIn()) {
      redirect('pages/index');
      exit;
    } 

    $this->pupilModel = $this->model('Pupil');
  }

  public function index(){
    $this->view('users/profile');
  }

  public function logout(){
    logout();
  }

  public function activateCheckInAndOut(){
    $_SESSION['checkSystem'] = true;
  }

  public function deactivateCheckInAndOut(){
      $_SESSION['checkSystem'] = false;
  }

  public function activateGreedAnimation(){
    $_SESSION['greedAnimation'] = true;
  }

  public function deactivateGreedAnimation(){
      $_SESSION['greedAnimation'] = false;
  }

  public function getPupilsCheckStatus(){
    $grades = $this->pupilModel->getAllPupilsAndGrades();

    $results = [
      'status' => 'success',
      'grades' =>  $grades
    ];

    header('Content-Type: application/json');
    echo json_encode($results);
  }


}
