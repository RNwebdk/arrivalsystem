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
            <legend>Create Teacher</legend>


            <form action="<?php echo URLROOT; ?>/teachers/create" method="POST">

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
                  <input type="password" placeholder="Password" name="password" class="form-control form-control-lg <?php echo (!empty($data['passwordError'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['password']; ?>">
                  <span class="invalid-feedback"><?php echo $data['passwordError']; ?></span>
              </div>

              <div class="form-group">
                  <input type="password" placeholder="Repeat Password" name="passwordRepeat" class="form-control form-control-lg <?php echo (!empty($data['passwordRepeatError'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['passwordRepeat']; ?>">
              </div>

              <div class="form-group">
              <input type="hidden" name="token" value="<?= Token::generate();  ?>">
               <button type="submit" name="submit" class="btn btn-success mb-2">Create</button>
              </div>

              <!-- Success message -->
              <?php flash('create_success'); ?>
              <!-- update message -->
              <?php flash('update_success'); ?>
              <!-- Delete message -->
              <?php flash('delete_success') ?>
              <!-- Failed to delete , when grade has pupils -->
              <?php flash('delete_failed') ?>
            </form>
        </fieldset>

        <?php require APPROOT . '/views/inc/admin/teacherList.php'; ?>
        
      </div>
    </div>
    <!-- /#page-content-wrapper -->

  </div>
  <!-- /#wrapper -->

<?php require APPROOT . '/views/inc/admin/footer.php'; ?>