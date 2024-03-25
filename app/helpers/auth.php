<?php


// check if user is logged in
function isLoggedIn(){
  if (isset($_SESSION['user_id'])) {
    return true;
  }else{
    return false;
  }
}

// Create Session With User Info
function createUserSession($user){
  $_SESSION['user_id'] = $user->id;
  $_SESSION['user_firstname'] = $user->firstname;
  $_SESSION['user_lastname'] = $user->lastname;
  $_SESSION['user_email'] = $user->email; 
  if (!isset($_SESSION['checkSystem'])) {
    $_SESSION['checkSystem'] = false;
  }
  if (!isset($_SESSION['greedAnimation'])) {
    $_SESSION['greedAnimation'] = false;
  }
}

// Logout & Destroy Session
function logout(){
  unset($_SESSION['user_id']);
  unset($_SESSION['user_firstname']);
  unset($_SESSION['user_lastname']);
  unset($_SESSION['user_email']);
  redirect('pages/index');
}
