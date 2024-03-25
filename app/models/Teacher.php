<?php


class Teacher{
	public function __construct(){
      $this->db = new Database;
    }

    // Get all grades
    public function getTeachers($dataType = PDO::FETCH_OBJ){
      $this->db->query("SELECT * FROM users ORDER BY users.id");

      $results = $this->db->resultset($dataType);

      return $results;
    }

    public function createTeacher($data){

      $hashedPassword = password_hash($data['password'], PASSWORD_BCRYPT);
    	// Prepare Query
      	$this->db->query('INSERT INTO users (firstname, lastname, email, password) 
      	VALUES (:firstName, :lastName, :email, :password)');

      // Bind Values
      $this->db->bind(':firstName', $data['firstName']);
      $this->db->bind(':lastName', $data['lastName']);
      $this->db->bind(':email', $data['email']);
    	$this->db->bind(':password', $hashedPassword);
      
    	//Execute
    	if($this->db->execute()){
    		return true;
    	} else {
    		return false;
    	}
    }

    public function getTeacherById($id){
      $this->db->query("SELECT * FROM users WHERE id = :id");

      $this->db->bind(':id', $id);
      
      if($row = $this->db->single()){
        return $row;
      }else{
        return false;
      }

    }

    
    public function passwordCorrect($email, $password){
      $this->db->query("SELECT * FROM users WHERE email = :email");
      $this->db->bind(':email', $email);

      $user = $this->db->single();
      $hashed_password = $user->password;
      if(password_verify($password, $hashed_password)){
        return true;
      } else {
        return false;
      }
    }

    public function isAdmin($teacherId){
      $this->db->query("SELECT users.isAdmin
                         FROM users
                         WHERE users.id = :teacherId");

      $this->db->bind(":teacherId", $teacherId);

      return (bool)$this->db->single()->isAdmin;
    }


    public function updateTeacher($data){
      // Prepare Query
      $this->db->query('UPDATE users 
                        SET users.firstName = :firstName, 
                            users.lastName = :lastName,
                            users.email = :email
                        WHERE users.id = :teacherId');
      
      // Bind Values
      $this->db->bind(':teacherId', $data['teacherId']);
      $this->db->bind(':firstName', $data['firstName']);
      $this->db->bind(':lastName', $data['lastName']);
      $this->db->bind(':email', $data['email']);
      
      //Execute
      if($this->db->execute()){
        return true;
      } else {
        return false;
      }
    }

    public function updateTeacherPassword($data){
      $hashedPassword = password_hash($data['password'], PASSWORD_BCRYPT);

      // Prepare Query
      $this->db->query('UPDATE users 
                        SET users.password = :newPassword
                        WHERE users.id = :teacherId');
      
      // Bind Values
      $this->db->bind(':teacherId', $data['teacherId']);
      $this->db->bind(':newPassword', $hashedPassword);
      
      //Execute
      if($this->db->execute()){
        return true;
      } else {
        return false;
      }
    }

    //check if grade name is unique in database
    //if no ID provided (insert)
    //if ID is provided (Update)
    public function emailAlreadyExist($newEmailAdress, $id = 0){

      $newEmailAdress = preg_replace('/\s+/', '', strtoupper($newEmailAdress));
      $assocTeachers = $this->getTeachers(PDO::FETCH_ASSOC);
      $arrTeachers = [];

      if ($id === 0) {
        //Insert  
        foreach ($assocTeachers as $teacher) {
          $arrTeachers[] = preg_replace('/\s+/', '', strtoupper($teacher['email']));
        }
        return in_array($newEmailAdress, $arrTeachers);
      }else{ 
        //Update
        foreach ($assocTeachers as $index => $teacher) {
          if ($teacher['id'] == $id) {
              continue;
          }
          $arrTeachers[] = preg_replace('/\s+/', '', strtoupper($teacher['email']));
        }
         return in_array($newEmailAdress, $arrTeachers);
      }
    }

    public function deleteTeacher($id){
      // Prepare Query
      $this->db->query('DELETE FROM users WHERE id = :id');

      // Bind Values
      $this->db->bind(':id', $id);
      
      //Execute
      if($this->db->execute()){
        return true;
      } else {
        return false;
      }
    }
}