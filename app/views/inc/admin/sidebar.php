<div class="sidebar-heading bg-mainColor">
  <button type="button" id="menu-toggle-sidebar" class="btn">
    <i class="fa fa-bars"></i>
  </button>
</div>
  <div class="list-group list-group-flush">
    <div class="img bg-wrap text-center py-4">
      <div class="user-logo">
        <div class="img" style="background-image: url(<?= URLROOT;  ?>/images/logo.png);"></div>
        <div class="user-text">
          <h3><?= Session::get('user_firstname') . " " . Session::get('user_lastname');  ?></h3>
        </div>
      </div>
    </div>
    <a data-disable-interaction="true" data-step="5" href="<?= URLROOT ?>/users/logout" class="list-group-item list-group-item-action bg-danger" id="logout"><span class="fa fa-sign-out mr-3"></span>Logout</a>
    <a href="<?= URLROOT . "/users/profile" ?>" class="list-group-item list-group-item-action bg-light"> <span class="fa fa-check mr-3"></span>Student Overview</a>
    <a href="<?= URLROOT . "/teachers/index" ?>" class="list-group-item list-group-item-action bg-light"> <span class="fa fa-lock mr-3"></span>
     Teachers</a>
    <a data-disable-interaction="true" data-step="2" href="<?= URLROOT . "/grades/index" ?>" class="list-group-item list-group-item-action bg-light"> <span class="fa fa-graduation-cap mr-3"></span>Grades</a>
    <a data-disable-interaction="true" data-step="3" href="<?= URLROOT . "/pupils/index" ?>" class="list-group-item list-group-item-action bg-light"><span class="fa fa-group mr-3"></span>Students</a>
  </div>
</div>
<script>
  $(document).ready(function(){
    // Menu Toggle Script
    let wrapper = document.getElementById('wrapper');

    $("#menu-toggle").click(function(e) {
      e.preventDefault();
      $("#wrapper").toggleClass("toggled");
    });

    $(".navbar-toggler").click(function(e) {
      e.preventDefault();
      $("#wrapper").toggleClass("toggled");
    });

    $("#menu-toggle-sidebar").click(function(e) {
      e.preventDefault();
      $("#wrapper").toggleClass("toggled");
    });

  })
  

</script>