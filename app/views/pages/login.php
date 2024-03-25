
<?php require APPROOT . '/views/pages/inc/checkheader.php'; ?>

<nav>
  <div class="nav nav-tabs" id="navigationBox">
    <button class="nav-link" id="pupils-tab" type="button">
        <i class="fas fa-user"></i> Students
    </button>
    <button class="nav-link active" id="teachers-tab"><i class="fas fa-user-graduate"></i> Teachers
    </button>
  </div>
</nav>


<div class="container">
    <!-- wrapper -->
    <div class="jumbotron container" id="buttons">


      <div class="tab-content" id="nav-tabContent">
        

         <!-- teachers / login -->
        <div id="teachers">
          <div class="row">
              <div class="col-md-6 mx-auto">
                <div class="card card-body bg-light mt-5">
                  <h2>Login</h2>
                  <p>Arrival system V.1.0</p>
                  <form action="<?php echo URLROOT; ?>/pages/index" method="post">
                    <div class="form-group">
                      <label>Email:<sup>*</sup></label>
                      <input type="text" name="email" class="form-control form-control-lg <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['email']; ?>">
                      <span class="invalid-feedback"><?php echo $data['email_err']; ?></span>
                  </div>    
                  <div class="form-group">
                      <label>Password:<sup>*</sup></label>
                      <input type="password" name="password" class="form-control form-control-lg <?php echo (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['password']; ?>">
                      <span class="invalid-feedback"><?php echo $data['password_err']; ?></span>
                  </div>
                  <div class="form-row">
                    <div class="col-md-12">
                      <div class="d-grid gap-2">
                        <input type="submit" class="btn bg-mainColor text-white mt-3" value="Login">
                      </div>
                    </div>
                    <input type="hidden" name="token" value="<?= Token::generate();  ?>">
                  </div>
                  </form>
                </div>
              </div>
          </div>
        </div> <!-- teachers end -->


    </div> <!-- wrapper end -->

  </div> <!-- container -->


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-kQtW33rZJAHjgefvhyyzcGF3C5TFyBQBA13V1RKPf4uH+bwyzQxZ6CmMZHmNBEfJ" crossorigin="anonymous"></script>
<script>
//Remember which tab was activated last time
let navigationBox = document.getElementById("navigationBox")
/*let pupilsTabBtn = document.getElementById("pupils-tab");
let pupilsTabContent = document.getElementById("pupils");
let teachersTabBtn = document.getElementById("teachers-tab");
let teachersTabContent = document.getElementById("teachers");*/


// set default if there's no default
/*if (currentTab === null || currentTab === "left") {
  localStorage.setItem('tab', 'left');
  pupilsTabBtn.classList.add("active", "show");
  pupilsTabContent.classList.add("active", "show");
}else{
  localStorage.setItem('tab', 'right');
  teachersTabBtn.classList.add("active", "show");
  teachersTabContent.classList.add("active", "show");
}*/

navigationBox.addEventListener('click', function(e){
  if (e.target.id === "pupils-tab") {
    window.location = "<?= URLROOT;  ?>/pages/index";
  }else{
    window.location = "<?= URLROOT;  ?>/pages/login";
  }
})
</script>
<?php require APPROOT . '/views/pages/inc/checkfooter.php'; ?>