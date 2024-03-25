<?php require APPROOT . '/views/inc/admin/header.php'; ?>
  <div class="d-flex toggled"  data-step="1" id="wrapper">

    <!-- Sidebar -->
    <div class="bg-light border-right" id="sidebar-wrapper">
      <?php require APPROOT . "/views/inc/admin/sidebar.php"; ?>
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper">

      <?php require APPROOT . '/views/inc/admin/topnav.php'; ?>

      <div class="container-fluid">
        <fieldset class="form-caps">
            <legend>Settings</legend>
            <form action="" method="POST">
<!--                 <div class="row">
                    <div class="form-group col-md-2">
                        <div class="input-group-prepend">
                          <input type="text" disabled="disabled" class="form-control" placeholder="Navn" value="<?= $_SESSION['user_firstname'] . " " . $_SESSION['user_lastname']; ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-3">
                        <div class="input-group-prepend">
                          <input type="text" disabled="disabled" class="form-control" placeholder="Email" value="<?= $_SESSION['user_email']; ?>">
                        </div>
                    </div>
                </div> -->
                <div class="row">
                  <div class="form-group col-md-12">
                    <div class="input-group-prepend">
                      <input data-disable-interaction="true" data-intro="4. Til sidst, trykkes på knappen her for at aktivere tjek-in/tjek-ud for eleverne. Det er muligt at bruge programmet på flere enheder. Dette kan opnås ved at logge ind og aktivere knappen her, på alle de enheder det skal bruges på." data-step="4" type="checkbox" id="activateCheck" class="switchButton" aria-label="Checkbox for following text input">
                      <span class="checkboxText">Activate Checkin system on this device</span>
                    </div>
                  </div>
                  <!-- <div class="form-group col-md-3">
                    <div class="input-group-pepend">
                      <div id="activateCheckErrorMssage">Beklager, du skal oprette elever før du kan aktiver denne funktion</div>
                    </div>
                  </div> -->
                </div>

                <div class="row">
                  <div class="form-group col-md-12">
                    <div class="input-group-prepend">
                      <input data-disable-interaction="true" type="checkbox" id="activateGreedingAnimation" class="switchButton" aria-label="Checkbox for following text input">
                      <span class="checkboxText">Activate Goodmorning/Goodbye animation</span>
                    </div>
                  </div>
                </div>
            </form>          
        </fieldset>
        
        <!-- Who is checked-in -->
        <div class="container">
          <div class="row" id="statusOutput">
            <!-- Data goes here -->
          </div>
        </div>


      </div>
    </div>
    <!-- /#page-content-wrapper -->

  </div>
  <!-- /#wrapper -->
  <?= link_js("intro.min.js"); ?>
  <script>
    // IntroJS stuff
    // introJs("body").start();
  </script>


  <script>
    window.addEventListener('load', function(){

    // the handler class
    class handler{
      constructor(){
        this.XMLhttp = new XMLHttpRequest();

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
                resolve(response.errorMessage)
              }
            }

          }
          this.XMLhttp.send();
        });
      }

    }




  function setScroll() {
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


  let statusOutput = document.getElementById('statusOutput');

  // get pupil status attendance
  function updatePupilStatus(){

    let urlString = "<?= URLROOT; ?>/users/getPupilsCheckStatus";
    var dataHandler = new handler();
    dataHandler.getData(urlString)
    .then((data) => {
      //set scroll position
      setScroll();

      // grade and pupil loop in loop
      statusOutput.innerHTML = "";
        data.grades.forEach((grade, index) => {
          statusOutput.innerHTML += gradeTemplate(grade);
        });

      //get scroll position
      restoreScrollPos();
      }).catch(error => {
        console.log(error);
        alert("Fejl #350: The connection to the server failed. Check your internet connection and reload the page")
    }); // dataHandler.getdata


    function gradeTemplate(data){
      return `
       <div class="col-lg-6 col-sm-12">
        <div class="card-box bg-mainColor">
          <div class="inner">
           <h3>${data.grade}</h3>
          </div>
          <div class="icon">
              <i class="fa fa-users" aria-hidden="true"></i>
          </div>
           <div class="pupil">
            <div class="row">
              ${pupilTemplate(data)}
            </div>
          </div>  
        </div>
      </div>
      `;
    } //gradeTemplate


    function pupilTemplate(data){

        let output = '';
        data["pupils"].forEach(pupil => {
          output += `<div class="col-lg-6">${nameAndStatusTemplate(pupil)}</div>`;
        });   

        return output;
    }

    function nameAndStatusTemplate(pupil){
      let str = pupil.name;
      if (str.length > 18) {
        str = str.substr(0, 18) + '...';
      }
        let status = pupil.checked ? "checkedIn" : "checkedOut";
        return `<h6>${str}<span class="${status}"> </span></h6>`;

    }

  } //updatePupilStatus


  updatePupilStatus();
  setInterval(() => {
    console.log("Running");
    updatePupilStatus();
  }, 5000);
});
</script>

  <script>

    // Activating check-in / check-out
    let activateCheck = document.getElementById('activateCheck');

    let isActive = <?php echo json_encode($_SESSION['checkSystem']); ?>;

    if (isActive){
      activateCheck.checked = true;
    }else{
      activateCheck.checked = false;
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
          alert("Fejl #356: The connection to the server failed. Check your internet connection and reload the page")
          alert(response.statusText);
      }
    }


    // Activate attendance system switch
    activateCheck.addEventListener('change', (event) => {
      if (event.currentTarget.checked) {
        let urlString = "<?= URLROOT; ?>/users/activateCheckInAndOut";
        fetchData(urlString)
        .then(() => {
          console.log("Should be ON now");
        }).catch(e => {
            console.log(e);
            // alert("Fejl #353: The connection to the server failed. Check your internet connection and reload the page")
        });    
      } else {

        let urlString = "<?= URLROOT; ?>/users/deactivateCheckInAndOut";
        fetchData(urlString)
        .then(() => {
          console.log("Should be OFF now");
        }).catch(e => {
            console.log(e);
            // alert("Fejl #352: The connection to the server failed. Check your internet connection and reload the page")
        });
      }
    });



    // Activating Geeding animation
    let greedAnimationSwitchButton = document.getElementById('activateGreedingAnimation');

    let isGreedAnimationActive = <?php echo json_encode($_SESSION['greedAnimation']); ?>;

    if (isGreedAnimationActive){
      greedAnimationSwitchButton.checked = true;
    }else{
      greedAnimationSwitchButton.checked = false;
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
          alert("Fejl #356: The connection to the server failed. Check your internet connection and reload the page")
          alert(response.statusText);
      }
    }



    // Activate attendance system switch
    greedAnimationSwitchButton.addEventListener('change', (event) => {
      if (event.currentTarget.checked) {
        let urlString = "<?= URLROOT; ?>/users/activateGreedAnimation";
        fetchData(urlString)
        .then(() => {
          console.log("Should be ON now");
        }).catch(e => {
            console.log(e);
            // alert("Fejl #353: The connection to the server failed. Check your internet connection and reload the page")
        });    
      } else {

        let urlString = "<?= URLROOT; ?>/users/deactivateGreedAnimation";
        fetchData(urlString)
        .then(() => {
          console.log("Should be OFF now");
        }).catch(e => {
            console.log(e);
            // alert("Fejl #352: The connection to the server failed. Check your internet connection and reload the page")
        });
      }
    });
  </script> 
<?php require APPROOT . '/views/inc/admin/footer.php'; ?>