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
            <legend>Edit Teacher</legend>


            <form action="<?php echo URLROOT; ?>/teachers/update/<?php echo $data['teacherId'] ?>" method="POST">

              <div class="form-group">
                  <input type="text" placeholder="Firstname" name="firstName" class="form-control form-control-lg <?php echo (!empty($data['firstNameError'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['firstName']; ?>">
                  <span class="invalid-feedback"><?php echo $data['firstNameError']; ?></span>
              </div>

              <div class="form-group">
                  <input type="text" placeholder="Lastname" name="lastName" class="form-control form-control-lg <?php echo (!empty($data['lastNameError'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['lastName']; ?>">
                  <span class="invalid-feedback"><?php echo $data['lastNameError']; ?></span>
              </div>

              <div class="form-group">
                  <input type="text" placeholder="Email" name="email" class="form-control form-control-lg <?php echo (!empty($data['emailError'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['email']; ?>">
                  <span class="invalid-feedback"><?php echo $data['emailError']; ?></span>
              </div>

              <div class="form-group">
              <input type="hidden" name="token" value="<?= Token::generate();  ?>">
               <button type="submit" name="submit" class="btn btn-success mb-2">Edit</button>
              </div>
              <hr>
            <a href="<?php echo URLROOT; ?>/teachers/passwordedit/<?php echo $data['teacherId']; ?>" class="btn bg-mainColor">Change Password</a>


              <?php 
              //Success message
              flash('create_success');
              //Update message
              flash('update_success');
              //Delete message
              flash('delete_success');
              
              // Failed to delete , when grade has pupils
              flash('delete_failed');

              ?>
            </form>
        </fieldset>

        <?php require APPROOT . '/views/inc/admin/teacherList.php'; ?>
        
      </div>
    </div>
    <!-- /#page-content-wrapper -->

  </div>
  <!-- /#wrapper -->

<?php require APPROOT . '/views/inc/admin/footer.php'; ?>