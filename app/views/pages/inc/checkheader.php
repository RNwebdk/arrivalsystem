<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF" crossorigin="anonymous">
<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
  <?= link_css("style.css"); ?>

  <title><?php echo SITENAME; ?></title>
</head>
<body>
  <style>
    /*navigation*/
.nav-link {
    width: 50%;
    font-size: 2em;
}
.nav.nav-tabs button {
    color:  black;
}
.nav-link.active{
    background-color: #10354A !important;
    color:  white !important;
}


.container{
  margin-top: 5%;
}

.imagebox{
    min-height: 270px;
}

.mainTextColor{
  color:  #10354A;
}

.name{
    font-size: 20px;
}

img.img-thumbnail {
    /*min-height: 50%;*/
}

.add-btn{
  width: 100%;
  height: 100px;
}

.add-btn .fa-plus, 
.fa-times-circle,
.fa-check-circle{
  font-size: 3em;
}

.circleWhite{
    width: 50px;
    height: 50px;
    background-color: white;
    display: inline-block;
    border-radius: 25px;
}

button > * {
  pointer-events: none;
}

.login-main{
    margin-top: 150px;
    z-index: 1;
}



/*POPUP*/
.popup-container{
  background-color: rgba(16,53,74,1);
  position: fixed;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  display: flex;
  display: none;
  align-items: center;
  justify-content: center;
  z-index: 99999999;
}

.popup{
  /*background: #2980b9;*/
  /*border-radius: 5px;*/
  /*box-shadow: 0 15px 10px 3px rgba(0,0,0,0.1);*/
  padding: 20px;
  text-align: center;
  color: #FFFFFF;
}


/*check animation*/
/*.success-animation { margin:150px auto;}*/

.checkmark {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    display: block;
    stroke-width: 2;
    stroke: #4bb71b;
    stroke-miterlimit: 10;
    box-shadow: inset 0px 0px 0px #4bb71b;
    animation: fill .4s ease-in-out .4s forwards, scale .3s ease-in-out .9s both;
    position:relative;
    top: 5px;
    right: 5px;
   margin: 0 auto;
}
.checkmark__circle {
    stroke-dasharray: 166;
    stroke-dashoffset: 166;
    stroke-width: 2;
    stroke-miterlimit: 10;
    stroke: #4bb71b;
    fill: #fff;
    animation: stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
 
}

#response{
  color: #4bb71b;
  text-align: center;
  font-size: 3em;
  /*text-transform: uppercase;*/
}

.checkmark__check {
    transform-origin: 50% 50%;
    stroke-dasharray: 48;
    stroke-dashoffset: 48;
    animation: stroke 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.8s forwards;
}

@keyframes stroke {
    100% {
        stroke-dashoffset: 0;
    }
}

@keyframes scale {
    0%, 100% {
        transform: none;
    }

    50% {
        transform: scale3d(1.1, 1.1, 1);
    }
}

@keyframes fill {
    100% {
        box-shadow: inset 0px 0px 0px 30px #4bb71b;
    }
}

</style>
  