<?php


class Pupil{
	public function __construct(){
      $this->db = new Database;
    }

    // Get all pupils
    public function getPupils(){
      $this->db->query("SELECT * FROM pupils");

      $results = $this->db->resultset();

      return $results;
    }

    public function getAllPupilsAndGrades(){
      $this->db->query("SELECT pupils.name AS pupilsName, 
                        grades.name AS pupilsGrade, 
                        pupils.checked FROM grades 
                        LEFT JOIN pupils 
                        on grades.id = pupils.gradeId 
                        ORDER BY pupilsGrade ASC,
                        pupils.name ASC");

      $pupils = $this->db->resultset();

      $sortedPupils = [];
      foreach ($pupils as $pupil) {
        if ($pupil->pupilsName) {
          $sortedPupils[$pupil->pupilsGrade]['grade'] = $pupil->pupilsGrade;
          $sortedPupils[$pupil->pupilsGrade]["pupils"][] = [
                                                  "name" => $pupil->pupilsName,
                                                  "checked" => intval($pupil->checked)
                                                  ];
        }else{
          $sortedPupils[$pupil->pupilsGrade]['grade'] = $pupil->pupilsGrade;
          $sortedPupils[$pupil->pupilsGrade]["pupils"] = [];
        }
      }


      $results = array_values($sortedPupils);

      return $results;
    }

    public function createPupil($data){
    	// Prepare Query
      	$this->db->query('INSERT INTO pupils (name, gradeId) 
      	VALUES (:pupilName, :gradeId)');

      	// Bind Values
      $this->db->bind(':pupilName', $data['pupilName']);
    	$this->db->bind(':gradeId', $data['gradeSelect']);
      
    	//Execute
    	if($this->db->execute()){
    		return true;
    	} else {
    		return false;
    	}
    }


    public function getPupilById($id){
      $this->db->query("SELECT * FROM pupils WHERE id = :id");

      $this->db->bind(':id', $id);
      
      if($row = $this->db->single()){
        return $row;
      }else{
        return false;
      }

    }

    public function getPupilByGradeId($id){
      $this->db->query("SELECT * FROM pupils WHERE gradeId = :id");

      $this->db->bind(':id', $id);
      
      if($row = $this->db->single()){
        return $row;
      }else{
        return false;
      }

    }


    public function updatePupil($data){
       // Prepare Query
      $this->db->query('UPDATE pupils 
                        SET name = :pupilName, gradeId = :pupilGrade WHERE id = :pupilId');
      
      // Bind Values
      $this->db->bind(':pupilId', $data['pupilId']);
      $this->db->bind(':pupilName', $data['pupilName']);
      $this->db->bind(':pupilGrade', $data['gradeSelect']);
      
      //Execute
      if($this->db->execute()){
        echo $this->db->rowCount();
        return true;
      } else {
        return false;
      }
    }

    public function deletePupil($id){
      // Prepare Query
      $this->db->query('DELETE FROM pupils WHERE id = :id');

      // Bind Values
      $this->db->bind(':id', $id);
      
      //Execute
      if($this->db->execute()){
        return true;
      } else {
        return false;
      }
    }

    public function getPupilsByGradeId($gradeId){
      // Prepare Query
      $this->db->query('SELECT grades.id as gradeId,
                               grades.name as gradeName,
                               pupils.id as pupilsId,
                               pupils.name as pupilsName,
                               pupils.checked
                               FROM pupils
                               INNER JOIN grades
                               ON pupils.gradeId = grades.id 
                               WHERE gradeId = :id
                               ORDER BY gradeId ASC,
                               pupilsName ASC'
                      );
      // Bind Values
      $this->db->bind(':id', $gradeId);

      $rows = $this->db->resultset();

      //Execute
      if($this->db->execute()){
        return $rows;
      } else {
        return false;
      }
    }

    public function toggleCheckStatus($id, $newStatus){
       // Prepare Query
      $this->db->query('UPDATE pupils 
                        SET checked = :newStatus WHERE id = :pupilId');
      
      // Bind Values
      $this->db->bind(':pupilId', $id);
      $this->db->bind(':newStatus', $newStatus);
      
      //Execute
      if($this->db->execute()){
        return true;
      } else {
        return false;
      }
    }


}