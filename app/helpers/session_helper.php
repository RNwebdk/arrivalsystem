<?php
session_start();

// Flash div message helper
function flash($name = '', $message = '', $class = 'alert alert-success'){
  if(!empty($name)){
    //No message, create it
    if(!empty($message) && empty($_SESSION[$name])){
      if(!empty( $_SESSION[$name])){
          unset( $_SESSION[$name]);
      }
      if(!empty( $_SESSION[$name.'_class'])){
          unset( $_SESSION[$name.'_class']);
      }
      $_SESSION[$name] = $message;
      $_SESSION[$name.'_class'] = $class;
    }
    //Message exists, display it
    elseif(!empty($_SESSION[$name]) && empty($message)){
      $class = !empty($_SESSION[$name.'_class']) ? $_SESSION[$name.'_class'] : 'success';
      echo '<div class="'.$class.'" id="msg-flash">'.$_SESSION[$name].'</div>';
      unset($_SESSION[$name]);
      unset($_SESSION[$name.'_class']);
    }
  }
}

// Flash Text message
function flasTexthMsg($name = '', $message = ''){
  if(!empty($name)){
    //If message is set and there's no other session created with that name, create it
    if(!empty($message) && empty($_SESSION[$name])){
      if(!empty( $_SESSION[$name])){
          unset( $_SESSION[$name]);
      }
      $_SESSION[$name] = $message;
    }
    //if session name is set without a message get the message and remove it from the session
    elseif(!empty($_SESSION[$name]) && empty($message)){
      $sessionName = $_SESSION[$name];
      unset($_SESSION[$name]);
      return $sessionName;
    }
  }
}