
<?php require APPROOT . '/views/inc/admin/header.php'; ?>
  <div class="d-flex toggled" id="wrapper">

    <!-- Sidebar -->
    <div class="bg-light border-right" id="sidebar-wrapper">
      <?php require APPROOT . "/views/inc/admin/sidebar.php"; ?>
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper">

      <?php require APPROOT . '/views/inc/admin/topnav.php'; ?>

      <div class="container-fluid">

        <fieldset class="form-caps">
            <legend>Edit Student</legend>
            <form action="<?php echo URLROOT; ?>/pupils/update/<?= $data['pupilId'] ?>" method="POST">
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                      <select name="gradeSelect" class="form-control <?php echo (!empty($data['gradeError'])) ? 'is-invalid' : ''; ?>">
                        <?php if (!isset($data['gradeSelect'])): ?>
                          <option value="" selected disabled hidden>Choose Grade</option>
                          <?php foreach ($data['allGrades'] as $grade): ?>
                             <?= "<option value=\"$grade->id\">$grade->name</option>" ?>
                          <?php endforeach ?>
                        <?php else: ?>
                          <?php foreach ($data['allGrades'] as $grade): ?>
                            <?php if ($grade->id === $data['gradeSelect']): ?>
                              <?= "<option selected=\"selected\" value=\"$grade->id\">$grade->name</option>" ?>
                            <?php else: ?>
                              <?= "<option value=\"$grade->id\">$grade->name</option>" ?>
                            <?php endif ?>
                          <?php endforeach ?>
                        <?php endif ?>
                      </select>
                      <span class="invalid-feedback"><?php echo $data['gradeError']; ?></span>
                  </div>    
                </div>
              </div> 

              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                      <input type="text" id="pupilName" name="pupilName" class="form-control <?php echo (!empty($data['pupilNameError'])) ? 'is-invalid' : ''; ?>" placeholder="Fulde navn" value="<?= $data['pupilName'] ?>">
                          <span class="invalid-feedback"><?php echo $data['pupilNameError']; ?></span>
                  </div>    
                </div>
              </div> 
                
              <input type="hidden" name="token" value="<?= Token::generate(); ?>">
               <button type="submit" name="submit" class="btn btn-success mb-2">Edit Student</button>
            </form>
        </fieldset>
        <hr id="separator">
        <fieldset class="form-caps">
          <legend>Filter by grade</legend>
          <select id="filterPupilSelect" class="form-control">
            <option value="" selected disabled hidden>Choose Grade</option>
            <?php foreach ($data['allGrades'] as $grade): ?>
              <?php if ($grade->id === $data['gradeSelect']): ?>
                <?= "<option selected=\"selected\" value=\"$grade->id\">$grade->name</option>" ?>
              <?php else: ?>
                  <?= "<option value=\"$grade->id\">$grade->name</option>" ?>
              <?php endif ?>
            <?php endforeach ?>
          </select>
        </fieldset>
        <?php require APPROOT . '/views/inc/admin/pupilList.php'; ?>
        <p class="noPupil">This Grade has no students</p>
      </div>
    </div>
    <!-- /#page-content-wrapper -->

  </div>
  <!-- /#wrapper -->
<script>
  let gradeSelect = document.getElementById("filterPupilSelect");


  function getData(gradeId){
    return new Promise((resolve, reject) => {
      console.log('<?= URLROOT; ?>/pupils/allpupils/' + gradeId);
      this.XMLhttp.open('GET ', '<?= URLROOT; ?>/pupils/allpupils/' + gradeId, true);
      this.XMLhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded; charset=utf-8'");
      this.XMLhttp.onreadystatechange = () =>{
          if (this.XMLhttp.readyState === 4 && this.XMLhttp.status === 200) {
          let response = JSON.parse(this.XMLhttp.response);
          if (response.status === 'success') {
            resolve(response);
          }else{
            resolve(response.errorMessage)
          }
        }

      }
      this.XMLhttp.send();
    });
  }

  async function fetchData(url) {
    let response = await fetch(url);

    if (response.status === 200) {
        let data = await response.json();
        // handle data
      return data;
    }

    if (response.status === 404) {
        throw Error(response.statusText);
    }
  }
  
  //get pupils onload
  let gradeId = <?= $data['gradeSelect']; ?>;
  getPupilsFromGrade(gradeId);

  //Dropdown on change, get pupils by grade
  gradeSelect.addEventListener("change", function(){
    
      let gradeId = this.value;
      getPupilsFromGrade(gradeId);

  });

  function getPupilsFromGrade(gradeId){
    let urlString = "<?= URLROOT; ?>/pupils/allpupils/" + gradeId;

    let tableBody = document.getElementById('pupilsTable');
    tableBody.innerHTML = ""
    fetchData(urlString)
    .then(data => {
      document.querySelector('.noPupil').style.display = "none";
        data.forEach(pupil => {
          tableBody.innerHTML += rowTemplate(pupil);
        });
        //console.log(data);
    }).catch(e => {
        document.querySelector('.noPupil').style.display = "block";
        //console.log(e);
    });

    function rowTemplate(pupil){
      return `
      <tr>
        <td>${pupil.pupilsName}</td>
        <td>${pupil.gradeName}</td>
        <td>
          <a href="<?= URLROOT; ?>/pupils/edit/${pupil.pupilsId}"><i class="fa fa-edit unityCheckIcon"></i></a>
          <a href="<?= URLROOT; ?>/pupils/remove/${pupil.pupilsId}"><i class="fa fa-times unityCheckIcon">
        </td>
      </tr>
      `
    }
  }
</script>
<?php require APPROOT . '/views/inc/admin/footer.php'; ?>