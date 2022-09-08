<?php
include "includes/header.php";
?>
  <!-- content start -->
<div class="container-fluid p-5 bg-white">
  <h3 class="text-muted text-decoration-underline text-center">Login form </h3>
  <div class="row p-3 shadow-1-strong">
<div class="col-lg-6 col-md-6 col-sm-12 d-none  d-lg-block">
  <img src="images/login.png" class="img-fluid" alt="login">
</div>
<div class="col-lg-6 col-md-12 col-sm-12 p-5" style="background-color: azure;">
<p id="result"></p>
  <h4 class="fw-bold mb-4" style="color: #92aad0;">Log in to your account</h4>
  <p class="mb-4" style="color: #45526e;">To log in, please fill in these text fiels with your e-mail address and password.</p>
  <form id="login-form">
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
  
    <!-- 2 column grid layout for inline styling -->
    <div class="row mb-4">
      <div class="col d-flex justify-content-center">
        <!-- Checkbox -->
        <div class="form-check">
          <input class="form-check-input" type="checkbox" value="" id="form2Example34" checked />
          <label class="form-check-label" for="form2Example34"> Remember me </label>
        </div>
      </div>
  
      <div class="col">
        <!-- Simple link -->
        <a href="reset-password.php">Forgot password?</a>
      </div>
    </div>
  
    <!-- Submit button -->
    <a href="admin-space.php"><button type="submit" class="btn btn-info btn-block mb-4" id="login">Login</button></a>
  
    <!-- Register buttons -->
    <div class="text-center">
      <p>Not a member? <a href="sign-up.php">Register</a></p>
    </div>
  </form>
</div>
  </div>
</div>
  <!-- content end -->
  <!-- js -->
  <script>
    // send login infos to server for verification :
      var login_btn = document.getElementById('login');
      var email = document.getElementById('email');
      var password = document.getElementById('password');
      var myForm = document.getElementById('login-form');
      var result = document.getElementById('result');
      login_btn.addEventListener('click' , login);
      function login (e){
        if(email.value === ""){
          return false
        }else if(password.value === ""){
          return false
        }else {
          e.preventDefault();
          login_btn.disabled = true;
          var login_request = new XMLHttpRequest();
          var login_form = new FormData();
          const login_infos = [email.value , password.value];
          login_form.append('login_infos',login_infos);
          login_request.onreadystatechange = function (){
            if(login_request.readyState === 4 && login_request.status === 200 ){
              result.innerHTML = login_request.responseText;
              login_btn.disabled = false;
              myForm.reset();
              // redirect :
              setInterval(function(){
                if(result.innerHTML === "admin"){
                  window.location.href="admin-space.php"
                }else if(result.innerHTML === "client"){
                  window.location.href="customer-space.php"
                }
              },100)
            }
          }
          login_request.open('POST','response.php');
          login_request.send(login_form);
        }
      }
  </script>
  <?php
include "includes/footer.php";
?>