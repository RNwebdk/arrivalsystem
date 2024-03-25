<?php


class Grade{
	public function __construct(){
      $this->db = new Database;
    }

    // Get all grades
    public function getGrades($dataType = PDO::FETCH_OBJ){
      $this->db->query("SELECT * FROM grades ORDER BY grades.name");

      $results = $this->db->resultset($dataType);

      return $results;
    }

    public function createGrade($data){
    	// Prepare Query
      	$this->db->query('INSERT INTO grades (name) 
      	VALUES (:gradeName)');

      	// Bind Values
    	$this->db->bind(':gradeName', $data['gradeName']);
      
    	//Execute
    	if($this->db->execute()){
    		return true;
    	} else {
    		return false;
    	}
    }

    public function getGradeById($id){
      $this->db->query("SELECT * FROM grades WHERE id = :id");

      $this->db->bind(':id', $id);
      
      if($row = $this->db->single()){
        return $row;
      }else{
        return false;
      }

    }

    public function gradeHasPupils($gradeId){
      $this->db->query("SELECT
                         count(pupils.id) as Total
                         FROM pupils
                         INNER JOIN grades
                         ON pupils.gradeId = grades.id 
                         WHERE grades.id = :gradeId");

      $this->db->bind(":gradeId", $gradeId);

      return $this->db->single();
    }

    public function getPupilsByGrade($gradeId){
      $results = [
          'status' => 'success',
          'products' =>  $products
        ];

        try{
        header('Content-Type: application/json');
        echo json_encode($results);


      } catch (PDOException $e) {
          echo 'Connection failed: ' . $e->getMessage();
        $results = [
          'status' => 'error',
          'reason' => 'Something went wrong'
        ];
      }
    }

    public function updateGrade($data){
       // Prepare Query
      $this->db->query('UPDATE grades SET name = :gradeName WHERE id = :gradeId');
      
      // Bind Values
      $this->db->bind(':gradeId', $data['gradeId']);
      $this->db->bind(':gradeName', $data['gradeName']);
      
      //Execute
      if($this->db->execute()){
        echo $this->db->rowCount();
        return true;
      } else {
        return false;
      }
    }

    //check if grade name is unique in database
    //if no ID provided (insert)
    //if ID is provided (Update)
    public function gradeAlreadyExist($newGradeName, $id = 0){
          $newGradeName = preg_replace('/\s+/', '', strtoupper($newGradeName));
          $assocGrades = $this->getGrades(PDO::FETCH_ASSOC);
          $arrGrades = [];

          if ($id === 0) {
            //Insert  
            foreach ($assocGrades as $grade) {
              $arrGrades[] = preg_replace('/\s+/', '', strtoupper($grade['name']));
            }
            return in_array($newGradeName, $arrGrades);
          }else{ 
            //Update
            foreach ($assocGrades as $index => $grade) {
              if ($grade['id'] == $id) {
                  continue;
              }
              $arrGrades[] = preg_replace('/\s+/', '', strtoupper($grade['name']));
            }
             return in_array($newGradeName, $arrGrades);
          }


    }

    public function deleteGrade($id){
      // Prepare Query
      $this->db->query('DELETE FROM grades WHERE id = :id');

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