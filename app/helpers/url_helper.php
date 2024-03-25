<?php
  function link_css( $css_path ){
    if (!empty($css_path)) {
      return '<link rel="stylesheet" href="'. URLROOT .'/' . "css/" . $css_path .'">';
    }
  }

  // normal script link = $module = false
  // type="module" script link = $module = true 
  function link_js( $js_path, $module = false){
    if (!empty($js_path) && !$module) {
      return '<script src="'. URLROOT .'/' . "js/" . $js_path .'"></script>';
    }

    if (!empty($js_path) && $module) {
      return '<script type="module" src="'. URLROOT .'/' . "js/" . $js_path .'"></script>';
    }
  }

  // Simple page redirect
  function redirect($page = ""){
    header('location: '.URLROOT.'/'.$page);
  }

  function anchor($href, $value, $options = []){
    if (array_key_exists("class", $options)) {
      $class = $options['class'];
    }else{
      $class = null;
    }

    if (array_key_exists("id", $options)) {
      $id = $options['id'];
    }else{
      $id = null;
    }

     if ($href !== "#") {
          $url = URLROOT . "/" . $href; 
      }

      return '<a href="'. ($url ?? $href) .'" class="'. $class .'" id="'. $id .'">'. $value .'</a>';

  }