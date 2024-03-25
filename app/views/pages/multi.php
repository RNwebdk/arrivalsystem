<?php if (isset($_SESSION['checkSystem']) && $_SESSION['checkSystem']): ?>


<?php require APPROOT . '/views/pages/inc/checkheader.php'; ?>


<nav>
  <div class="nav nav-tabs" id="navigationBox">
    <button class="nav-link active" id="pupils-tab" type="button">
        <i class="fas fa-user"></i> Students
    </button>
    <button class="nav-link" id="teachers-tab"><i class="fas fa-user-graduate"></i> Teachers
    </button>
  </div>
</nav>


<div class="container">
    <!-- wrapper -->
    <div class="jumbotron container" id="buttons">


      <div class="tab-content" id="nav-tabContent">
        

        <!-- elever -->
        <div id="pupils">

          <div class="row w-100 justify-content-center mt-5">
            <div class="col-md-6 d-grid gap-12">
              <form action="<?php echo URLROOT; ?>/pupils/check/1" method="POST">
                <div class="col-md-12">
                  <div class="form-group">
                    <select name="gradeSelect" id="filterPupilSelect" class="form-select form-select-lg mb-3">
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

                  </div>
                </div>
              </form>
            </div>
          </div>

          <h2 class="text-center" id="gradeTitle">Choose a grade from the dropdown</h2>

          <div class="row w-100 justify-content-center mt-5" id="pupilOutput">
            <!-- PUPILS GOES HERE -->
          </div> <!-- end of pupils -->

      </div>


    </div> <!-- wrapper end -->

  </div> <!-- container -->



    <!-- Modal -->
    <div class="popup-container" id="popup-container">
      <div class="popup" id="popup">
        <div class="success-animation">
          <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52"><circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none" /><path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8" /></svg>
        </div>
        <div>
          <p id="response" class="text-center">Response Message</p>
        </div>
      </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-kQtW33rZJAHjgefvhyyzcGF3C5TFyBQBA13V1RKPf4uH+bwyzQxZ6CmMZHmNBEfJ" crossorigin="anonymous"></script>

<script>
  // Check in, check out
document.addEventListener('DOMContentLoaded', function () {
var sound = new Audio('<?= URLROOT; ?>/sound/ding2.ogg');
sound.volume = 0.5;
  // the handler class
  class handler{
    constructor(){
      this.XMLhttp = new XMLHttpRequest();

    }

    insertData(pupilId, pupilStatus){
      return new Promise((resolve, reject) => {
        this.XMLhttp.open('POST', '<?= URLROOT; ?>/pages/checkIn/'+ pupilId + "/" + pupilStatus, true);
          this.XMLhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
          this.XMLhttp.onreadystatechange = () => {
          if (this.XMLhttp.readyState === 4 && this.XMLhttp.status === 200){
            let response = JSON.parse(this.XMLhttp.response);
            if (response.status === 'success') {
              resolve(response); // when successful
            }else{
              alert(response.errorMessage);
            }       
          
          }
        }
        this.XMLhttp.send();
      });
    }

    getData(urlString){
      return new Promise((resolve, reject) => {
        this.XMLhttp.open('POST', urlString, true);
        this.XMLhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded; charset=utf-8'");
        this.XMLhttp.onreadystatechange = () =>{
            if (this.XMLhttp.readyState === 4 && this.XMLhttp.status === 200) {
            let response = JSON.parse(this.XMLhttp.response);
            if (response.status === 'success') {
              resolve(response);
            }else{
              resolve(response.errorMessage);
            }
          }

        }
        this.XMLhttp.send();
      });
    }

    animate(response){
      let animationActivated = "<?= $_SESSION['greedAnimation'] ? 'activated' : 'deactivated'; ?>";
      if (animationActivated == "activated") {
          document.querySelector('.popup-container').style.display = 'flex';
        document.querySelector('.popup').classList.add('animate__animated', 'animate__fadeIn');
        setTimeout(function(){
          sound.play();
        }, 1000)
         setTimeout(function(){
          document.querySelector('.popup').classList.remove('animate__animated', 'animate__fadeIn');
          document.querySelector('.popup').classList.add('animate__animated', 'animate__fadeOut');
          setTimeout(function(){
            document.querySelector('.popup-container').style.display = 'none';
            document.querySelector('.popup').classList.remove('animate__animated', 'animate__fadeOut');
          }, 1000)
         }, 2000);
         if (parseInt(response.pupil.checked)) {
          document.getElementById('response').innerHTML = "Goodbye, " + response.pupil.name + " See you tomorrow👋";
         }else{
          document.getElementById('response').innerHTML = "Good Morning, " + response.pupil.name + " 😊☕";
         }
      }
      
    }
    
  }



  // listen for a check-in / check-out with the handler
  var dataHandler = new handler();
  document.getElementById('pupilOutput').addEventListener("click", function(e){
    if (e.srcElement.nodeName === "BUTTON") {
      
      dataHandler.insertData(e.srcElement.dataset.pupilId, e.srcElement.dataset.pupilStatus)
      .then((data) => {
        
        //Greed animation
        dataHandler.animate(data);

        //set scroll position
        setScroll();

        updatePupilList(); // refresh all pupils on screen

        //get scroll position
        restoreScrollPos();
      })
      .catch(error => {
        console.log(error);
        alert("Fejl #356: The connection to the server failed. Check your internet connection and reload the page");
      })
    }
  }); // Click addEventListener

  function setScroll() {
      // console.log("setScroll was executed");
      let scroll = window.scrollY;
      let scrollString = scroll.toString();
      localStorage.setItem("scrollPosition", scrollString);
  }


  function restoreScrollPos() {
      let localSorangePosition = localStorage.getItem("scrollPosition");
      let posYString = localSorangePosition ? localSorangePosition : 0;
      let posY = parseInt(posYString);
      window.scrollTo({ top:posY, left:0, behavior: "instant", visibility: "hidden"});
      return false;
  }


  /*Grade dropdown filter */
  let gradeSelect = document.getElementById("filterPupilSelect");
  let gradeTitle = document.getElementById("gradeTitle");
  let pupilOutput = document.getElementById("pupilOutput");
  gradeSelect.addEventListener("change", (e) => {
      updatePupilList();
  });


  function updatePupilList(){

    let selectGrade = document.getElementById('filterPupilSelect');
    let gradeId = selectGrade.value;
    let selectIndex = selectGrade.selectedIndex;
    gradeTitle.innerHTML = selectGrade.options[selectIndex].text;
    let urlString = "<?= URLROOT; ?>/pages/pupils/" + gradeId;
    dataHandler.getData(urlString)
    .then((data) => {
      pupilOutput.innerHTML = ""
      pupilOutput.innerHTML += '<div class="row w-100 justify-content-center mt-5">';
        data.pupils.forEach((pupil, index) => {
          if (index % 4 == 0 && index != 0) {
            pupilOutput.innerHTML += '</div>';
            pupilOutput.innerHTML += '<div class="row w-100 justify-content-center mt-5">';
          }
          pupilOutput.innerHTML += pupilTemplate(pupil);
        });
        pupilOutput.innerHTML += '</div>';
      }).catch(error => {
        console.log(error);
        alert("Fejl #355: The connection to the server failed. Check your internet connection and reload the page");
    }); // dataHandler.getdata

    function pupilTemplate(pupil){
      return `
        <div class="col-md-3 d-grid gap-2">
          <div class="card border-success mx-sm-1 imagebox">
            <img src="<?php echo URLROOT; ?>/images/male.jpg" class="img-thumbnail" alt="pupil">
            <h3 class="mainTextColor text-center name">${pupil.pupilsName}</h3>
          </div>
          <button data-pupil-id="${pupil.pupilsId}" data-pupil-status="${parseInt(pupil.checked) === 0 ? 1 : 0}" class="btn btn-success add-btn mb-5" type="button">
          ${parseInt(pupil.checked) ? "<i class=\"fa fa-check-circle\"></i>" : "<span class=\"circleWhite\"></span>"}
          </button>
        </div>
      `;
    } //pupilTemplate

  } //updatePupilList



  // Top navigation for pupil and login pages
  let navigationBox = document.getElementById("navigationBox")

  navigationBox.addEventListener('click', function(e){
    if (e.target.id === "pupils-tab") {
      window.location = "<?= URLROOT;  ?>/pages/index";
    }else{
      window.location = "<?= URLROOT;  ?>/pages/login";
    }
  });



}); // onload
</script>


<?php require APPROOT . '/views/pages/inc/checkfooter.php'; ?>






<?php else: ?>
<?php require APPROOT . '/views/pages/inc/header.php'; ?>
  <div class="container">
    <div class="row">
        <div class="col-md-6 col-lg-4 mx-auto">
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
              <div class="col">
                <input type="submit" class="btn bg-mainColor btn-block" value="Login">
              </div>
              <input type="hidden" name="token" value="<?= Token::generate();  ?>">
            </div>
            </form>
          </div>
        </div>
    </div>
  </div>

<?php require APPROOT . '/views/pages/inc/footer.php'; ?>


<?php endif ?>
