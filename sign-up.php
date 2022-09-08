<?php
include "includes/header.php";
?>
<!-- content start -->
<div class="container-fluid p-5 bg-white">
  <h3 class="text-muted text-decoration-underline text-center">Registration form </h3>
<div class="row p-3 shadow-1-strong">
  <div class="col-lg-6 col-md-6 col-sm-12 d-none  d-lg-block">
    <img src="images/login.png" class="img-fluid" alt="login">
  </div>
  <div class="col-lg-6 col-md-12 col-sm-12 p-5 " style="background-color: azure;">
  <p id="result"></p>
    <h4 class="fw-bold mb-4" style="color: #92aad0;">Create a new account</h4>
  <p class="mb-4" style="color: #45526e;">To create a new account , please fill in these text fiels with a valid informations (name,lastname...).</p>
    <form action="" method="POST" id="sign-form">
      <!-- 2 column grid layout with text inputs for the first and last names -->
      <div class="row mb-4">
        <div class="col-lg-6 mb-4 mb-lg-0">
          <div class="form-outline">
            <input type="text" id="fname" class="form-control" required/>
            <label class="form-label" for="fname">First name</label>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="form-outline">
            <input type="text" id="lname" class="form-control" required/>
            <label class="form-label" for="lname">Last name</label>
          </div>
        </div>
      </div>
    
      <!-- Email input -->
      <div class="form-outline mb-4">
        <input type="email" id="email" class="form-control" required/>
        <label class="form-label" for="email">Email address</label>
      </div>
    
      <!-- Password input -->
      <div class="form-outline mb-4">
        <input type="password" id="password" class="form-control" required/>
        <label class="form-label" for="password">Password</label>
      </div>
    
      <!-- Checkbox -->
      <div class="form-check d-flex justify-content-center mb-4">
        <input class="form-check-input me-2" type="checkbox" value="" id="newslater" checked />
        <label class="form-check-label" for="newslater">
          Subscribe to our newsletter
        </label>
      </div>
    
      <!-- Submit button -->
      <button type="submit" class="btn btn-info btn-block mb-4" id="register">Register</button>
    </form>
  </div>
</div>
</div>
  <!-- content end -->
  <!-- js -->
  <script>
    // send register data with ajax to response.php :
    var register_btn = document.getElementById('register');
    var fname = document.getElementById('fname');
    var lname = document.getElementById('lname');
    var email = document.getElementById('email');
    var password = document.getElementById('password');
    var result = document.getElementById('result');
    var myForm = document.getElementById('sign-form')
    var newslater = document.getElementById('newslater')
    register_btn.addEventListener('click' , register);
        function register (e){
        if(fname.value === ""){
        return false
        }else if(lname.value === ""){
    return false
        }else if(email.value === ""){
    return false
        }else if(password.value === ""){
          return false
        }
        else{
          e.preventDefault()
          var register_request = new XMLHttpRequest();
          var infos_form = new FormData();
          register_btn.disabled = true
          if(newslater.checked === true){
            var infos = [fname.value , lname.value , email.value , password.value , "checked"];
          infos_form.append('infos',infos);
          }else{
            var infos = [fname.value , lname.value , email.value , password.value , "canceled"];
          infos_form.append('infos',infos);
          }
          register_request.onreadystatechange = function (){
            if(register_request.readyState === 4 && register_request.status === 200 ){
        result.innerHTML = register_request.responseText;
        register_btn.disabled = false
        myForm.reset()
            }
          }
          register_request.open('POST','response.php')
          register_request.send(infos_form)
        }
        }
  </script>
  <?php
include "includes/footer.php";
?>