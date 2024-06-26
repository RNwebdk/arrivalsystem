<?php 

/*RULES*/
// required -> if value is empty
// not_int  -> value must be alphabetic character
// int      ->value must be integer

// EXAMPLES
// Form::inputValidation('fullName', 'Full Name', 'not_int|max_len|8|required');
// Form::inputValidation('address', 'Address', 'not:int|required');
// Form::inputValidation('password', 'Password', 'min_len|5|required');
// Form::inputValidation('confirm', 'confirm Password', 'confirm|password|required');
// Form::inputValidation('user_email', 'Email', 'unique|users|required');

class Form{

    public $errors = [];

    public static function inputValidation($field_name, $label, $rules){

        if(!isset($_POST[$field_name])){
            // redirect("accountcontroller/login");
            die("$field_name was not found, exit was executed");
        }


        if($_SERVER['REQUEST_METHOD'] == "POST" || $_SERVER['REQUEST_METHOD'] == "post"){
            $data = trim($_POST[$field_name]);
        } else if($_SERVER['REQUEST_METHOD'] == "GET" || $_SERVER['REQUEST_METHOD'] =="get"){
            $data = trim($_GET[$field_name]);
        }


        $pattern = "/^[a-zA-Z ÆØÅæøå]+$/";
        $int_pattren = "/^[0-9]+$/";
        $rules = explode("|", $rules);
        if(in_array("required", $rules)){
            /*
                 * if value is empty
            */ 
            if(empty($data)){
                 return $this->errors[$field_name] = $this->__($label. " is required");
            }
        }

        /*
             * value must be alphabetic character
        */ 
        if(in_array("not_int", $rules)){
            if(!preg_match($pattren, $data)){
               return $this->errors[$field_name] =  $this->__($label . " must be alphabetic character");
            }
        }

        /*
           * value must be integer
        */ 
        if(in_array("int", $rules)){
            if(!preg_match($int_pattren, $data)){
                                                    //Den er ikke blevet testet (mangler oversættelse)
                return $this->errors[$field_name] = $this->__($label . " must be integer");
            }

        }

        /*
            * Check minimum length
        */ 

        if(in_array("min_len", $rules)){
            /*
                * Get the index of min_len rule
            */ 
            $min_len_index = array_search("min_len", $rules);
            /*
                * Get the index of min_len rule value
            */ 
            $min_len_value = $min_len_index + 1;
            /*
                * Get the value of min_len rule
            */ 
            $min_len_value = $rules[$min_len_value];
            if(strlen($data) < $min_len_value){
                return $this->errors[$field_name] = $label . $this->__(" is less than ") . $min_len_value . $this->__(" characters");

            }

        }

         /*
            * Check maximum length
        */ 

        if(in_array("max_len", $rules)){
            /*
                * Get the index of max_len rule
            */ 
            $max_len_index = array_search("max_len", $rules);
            /*
                * Get the index of max_len rule value
            */ 
            $max_len_value = $max_len_index + 1;
            /*
                * Get the value of max_len rule
            */ 
            $max_len_value = $rules[$max_len_value];
            if(strlen($data) > $max_len_value){
                return $this->errors[$field_name] = $label . $this->__(" is grater than ") . $max_len_value . $this->__(" characters");

            }

        }

        /*
            * Confirm password rule
        */ 

        if(in_array("confirm", $rules)){
            /*
                * Get the index of confirm rule
            */ 
            $confirm_rule_index = array_search("confirm", $rules);
            /*
                * Get the index of password 
            */ 
            $confirm_rule_index = $confirm_rule_index + 1;
            /*
                * Get the password name
            */ 
            $confirm_rule_password = $rules[$confirm_rule_index];
            if($_SERVER['REQUEST_METHOD'] == "POST" || $_SERVER['REQUEST_METHOD'] == "post"){
                /*
                * Get the password value
            */ 
            $password = trim($_POST[$confirm_rule_password]);
        } else if($_SERVER['REQUEST_METHOD'] == "GET" || $_SERVER['REQUEST_METHOD'] =="get"){
             /*
                * Get the password value
            */ 
            $password = trim($_GET[$confirm_rule_password]);
        }
           
           if($data !== $password){
            return $this->errors[$field_name] = $this->__($label . " does not matched");
           }

        }

        /*
           * Check the email availability
        */ 

        if(in_array("unique", $rules)){
            /*
                 * Get the index of unique role
            */ 
            $unique_index = array_search("unique", $rules);
            /*
                * Get the index of table name
            */ 
            $table_index = $unique_index + 1;

            /*
                * Get table name
            */ 
            $table_name = $rules[$table_index];

            /*
                * Include the database file 
            */ 

            require_once "../system/libraries/database.php";

            $db = new Database;
            if($db->Select_Where($table_name, [$field_name => $data])){
                if($db->Count() > 0){
                    return $this->errors[$field_name] = $this->__("This " . $label . " is already registered");
                }
            }


        }
   
    }

    public function run(){
        if(empty($this->errors)){
            return true;
        } else {
            return false;
        }
    }

    /*
          * Set form values
    */ 

   public function set_value($field_name){
        if($_SERVER['REQUEST_METHOD'] == "POST" || $_SERVER['REQUEST_METHOD'] == "post"){
            if(isset($_POST[$field_name])){
                return $_POST[$field_name];
            } else {
                return false;
            }
            
        } else if($_SERVER['REQUEST_METHOD'] == "GET" || $_SERVER['REQUEST_METHOD'] == "get") {
            if(isset($_GET[$field_name])){
               return $_GET[$field_name];
            } else {
                return false;
            }
           
        }

    }

    /*
        * Password hash
    */ 

    public function hash($password){

        if(!empty($password)){

            return password_hash($password, PASSWORD_DEFAULT);
        }


    }

}


 ?>