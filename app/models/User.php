<?php
  class User {
    private $db;

    public function __construct(){
      $this->db = new Database;
    }

    // Add User / Register
    public function addUser($data){
      //Register a user
      $this->db->query("INSERT INTO users (name, email,password) 
      VALUES (:name, :email, :password)");

      // Bind Values
      $this->db->bind(':name', $data['name']);
      $this->db->bind(':email', $data['email']);
      $this->db->bind(':password', $data['password']);


      //Execute
      if($this->db->execute()){
        return $this;
      } else {
        return false;
      }
    }


    // Find User BY Email
    public function findUserByEmail($email){
      $this->db->query("SELECT * FROM users WHERE email = :email");
      $this->db->bind(':email', $email);

      $row = $this->db->single();

      //Check Rows
      if($this->db->rowCount() > 0){
        return true;
      } else {
        return false;
      }
    }

    // Login / Authenticate User
    public function findUser($email, $password){
      // 
      $this->db->query("SELECT * FROM users WHERE email = :email");
      $this->db->bind(':email', $email);

      $user = $this->db->single();
      $hashed_password = $user->password;
      if(password_verify($password, $hashed_password)){
        return $user;
      } else {
        return false;
      }
    }

    // Find User By ID
    public function getUserById($id){
      $this->db->query("SELECT * FROM users WHERE id = :id");
      $this->db->bind(':id', $id);

      $row = $this->db->single();

      return $row;
    }
  }