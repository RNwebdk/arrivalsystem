<?php if (!isset($_SESSION['checkSystem']) || !$_SESSION['checkSystem']): ?>
<nav class="navbar navbar-expand-lg navbar-dark bg-mainColor mb-3">
  <div class="container">
    <a class="navbar-brand" href="#"><?php echo SITENAME; ?></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" href="<?php echo URLROOT; ?>/pages/index">Login</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<?php endif ?>