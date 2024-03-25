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
            <legend>Edit Grade</legend>


            <form action="<?php echo URLROOT; ?>/grades/update/<?= $data['gradeId']; ?>" method="POST">

              <div class="form-group">
                  <input type="text" placeholder="Grade name" name="gradeName" class="form-control form-control-lg <?php echo (!empty($data['gradeNameError'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['gradeName']; ?>">
                  <span class="invalid-feedback"><?php echo $data['gradeNameError']; ?></span>
              </div>    

              <div class="form-group">
                <input type="hidden" name="token" value="<?= Token::generate();  ?>">
                <button type="submit" name="submit" class="btn btn-success mb-2">Edit</button>
              </div>

              <!-- update message -->
              <?php flash('update_failed'); ?>    
            </form>
        </fieldset>

        <?php require APPROOT . '/views/inc/admin/gradeList.php'; ?>
        
      </div>
    </div>
    <!-- /#page-content-wrapper -->

  </div>
  <!-- /#wrapper -->

<?php require APPROOT . '/views/inc/admin/footer.php'; ?>