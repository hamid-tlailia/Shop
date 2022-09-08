<?php
include "includes/header.php";
?>

<div class="container-fluid ">
<h3 class="text-muted text-decoration-underline text-center mt-3">Reset Password </h3>
    <section class="intro">
        <div class="bg-image h-75 shadow-1-strong mb-3">
            <div class="mask d-flex align-items-center h-100" >
                <div class="container">
                    <div class="row d-flex justify-content-center align-items-center">
                        <div class="col-12 col-lg-9 col-xl-8">
                            <div class="card" style="border-radius: 1rem;">
                                <div class="row g-0">
                                    <div class="col-md-4 d-none d-md-block">
                                        <img src="https://mdbootstrap.com/img/Photos/Others/sidenav2.jpg" alt="login form" class="img-fluid" style="border-top-left-radius: 1rem; border-bottom-left-radius: 1rem;max-height:450px" />
                                    </div>
                                    <div class="col-md-8 d-flex align-items-center">
                                        <div class="card-body ">

                                            <form id="reset-form">
                                                <h4 class="fw-bold mb-4" style="color: #92aad0;">Steps to reset your password</h4>
                                                <p class="mb-4" style="color: #45526e;">To correctly reset password, please fill in these text fiel with your e-mail address.</p>
                                                <div class="form-outline mb-4">
                                                    <input type="email" id="email" class="form-control" required/>
                                                    <label class="form-label" for="email">Email address</label>
                                                </div>
                                                <div class="d-flex justify-content-end pt-1">
                                                    <button class="btn btn-primary btn-rounded" type="submit" id="reset-password-btn" style="background-color: #92aad0;">Confirme</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- confirm phone modal -->
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary d-none " data-mdb-toggle="modal" id="modal-btn" data-mdb-target="#modalPass">click</button>
<!-- Modal -->
<div class="modal top fade" id="modalPass" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-mdb-backdrop="true" data-mdb-keyboard="true">
  <div class="modal-dialog   modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Verification</h5>
        <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="result">
 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal" id="cancel">
          Cancel
        </button>
        <button type="button" class="btn btn-primary" id="confirme">Continue</button>
      </div>
    </div>
  </div>
</div>
<!-- result modal -->
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary d-none" data-mdb-toggle="modal" id="final_btn" data-mdb-target="#final"></button>

<!-- Modal -->
<div class="modal top fade" id="final" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-mdb-backdrop="true" data-mdb-keyboard="true">
  <div class="modal-dialog   modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Updating</h5>
        <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="final_result">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal" id="close">
          Cancel
        </button>
      </div>
    </div>
  </div>
</div>
<!-- Success Modal -->
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary d-none" data-mdb-toggle="modal" data-mdb-target="#success" id="success-btn">
</button>

<!-- Modal -->
<div class="modal top fade" id="success" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-mdb-backdrop="true" data-mdb-keyboard="true">
  <div class="modal-dialog   modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Finalising</h5>
        <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="success-modal">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">
          OK
        </button>
      </div>
    </div>
  </div>
</div>
<!-- css -->
<style>
    @media (min-width: 550px) and (max-width: 750px) {

        html,
        body,
        .intro {
            height: 550px;
        }
    }

    @media (min-width: 800px) and (max-width: 850px) {

        html,
        body,
        .intro {
            height: 550px;
        }
    }

    a.link {
        font-size: .875rem;
        color: #6582B0;
    }

    a.link:hover,
    a.link:active {
        color: #426193;
    }
</style>
<!-- js -->
<script>
    // cart empty check :
    setInterval(function() {
        var carts = document.querySelectorAll('#cart');
        carts.forEach(cart => {
            if (cart.children.length === 0) {
                cart.innerHTML = `<div class="alert alert-white text-center p-3 fw-bold">Your cart is empty</div>`;
            }
        })
    }, 100)
    // Verify Email code start :
    var reset_password_btn = document.getElementById('reset-password-btn');
    var btn_modal = document.getElementById('modal-btn');
    var reset_form = document.getElementById('reset-form');
    var email = document.getElementById('email');
    var result = document.getElementById('result');
    reset_password_btn.addEventListener('click' , function (e){
    if(email.value === ""){
        return false;
    }else{
        e.preventDefault();
        var req = new XMLHttpRequest();
        var form = new FormData();
        form.append('reset-email',email.value);
        reset_password_btn.disabled = true;
        req.onreadystatechange = function (){
            if(req.readyState === 4 && req.status === 200){
                reset_password_btn.disabled = false;
                result.innerHTML = req.responseText;
                reset_form.reset();
                btn_modal.click(); 
                // confirme phone number :
                var phone = document.getElementById('phone');
                var confirme_btn = document.getElementById('confirme');
                var identity = document.getElementById('admin');
                var final_result_area = document.getElementById('final_result');
                var final_result_area_btn = document.getElementById('final_btn');
                var cancel = document.getElementById('cancel');
                // verif infos :
                confirme_btn.onclick = function (){
                    var verify_password_request = new XMLHttpRequest();
                    var verify_password_form = new FormData();
                    confirme_btn.disabled = true;
                   const verify_password_infos = [phone.value , identity.value];
                   verify_password_form.append('old_password',verify_password_infos);
                   verify_password_request.onreadystatechange = function (){
if(verify_password_request.readyState === 4 && verify_password_request.status === 200){
    confirme_btn.disabled = false;
    final_result_area.innerHTML = verify_password_request.responseText;
    final_result_area_btn.click();
    cancel.click();
     // update password
var update = document.getElementById('change-password');
var change_id = document.getElementById('ident_id');
var change_email = document.getElementById('ident_email');
var new_password = document.getElementById('new-password');
var success_btn = document.getElementById('success-btn');
var success_modal = document.getElementById('success-modal');
var close = document.getElementById('close');
update.addEventListener('click' , function (e){
if(new_password.value === ""){
    return false;
}else{
    e.preventDefault();
    var update_pass_req = new XMLHttpRequest();
                    var update_pass_form = new FormData();
                    update.disabled = true;
                   const update_pass_infos = [change_id.value , change_email.value , new_password.value];
                   update_pass_form.append('updates',update_pass_infos);
                   update_pass_req.onreadystatechange = function (){
if(update_pass_req.readyState === 4 && update_pass_req.status === 200){
    update.disabled = false;
    success_modal.innerHTML = update_pass_req.responseText;
    success_btn.click();
    close.click();
}
  }
}
// send update request :
update_pass_req.open('POST','response.php');
update_pass_req.send(update_pass_form);
})
}
                   }
                   // send old password request form :
verify_password_request.open('POST','response.php');
verify_password_request.send(verify_password_form);
                }
                // End
            }
        } 
        // send reset request :
req.open('POST','response.php');
req.send(form);
    }
    })
</script>
<?php
include "includes/footer.php";
?>