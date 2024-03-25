<?php
  /* 
   *  CORE CONTROLLER CLASS
   *  Loads Models, Views and Controllers
   */
  class Controller {
    public function index(){
      redirect("auth/index");
    }
    //Load a model
    public function model($model){
      // Require model file
      require_once '../app/models/' . $model . '.php';
      // Instantiate model
      return new $model();
    }

    //Load a view 
    public function view($url, $data = []){
      // Check for view file
      if(file_exists('../app/views/'.$url.'.php')){
        // Require view file
        require_once '../app/views/'.$url.'.php';
      } else {
        // No view exists
        die('View does not exist');
      }
    }

    //Load a Controller
    public function getController($controller){
      // Require model file
      require_once '../app/controllers/' . $controller . '.php';
      // Instantiate model
      return new $controller();
    }
  }