<?php
include "includes/header.php";
if(isset($_SESSION['client'])){
  // return this session
}else{
  ?>
<script>window.location.href="login.php"</script>
  <?php
}
?>
<!-- content start -->
<div class="container-fluid p-2 bg-white">
  <h3 class="text-muted text-center text-decoration-underline mb-3">Customer-Profile</h3>
  <div class="container emp-profile shadow-1-strong">
  <div id="edit-result"></div>
        <div class="row alert-info p-3">
            <div class="col-md-4 text-center">
                <div class="profile-img text-center mb-2" >
                  <div class="bg-image" style="max-width: 150px;max-height:150px">
                    <img
                      src="images/avatar.png"
                      class="w-100 border border-white p-2"
                      alt="Louvre Museum"
                      style="max-width: 150px;max-height:150px"
                      id="customer-profile-image"
                    />
                    <div class="mask d-none" style="background-color: rgba(0, 0, 0, 0.089)" id="mask-profile">
                      <div class="d-flex justify-content-center align-items-center h-100">
                        <p class="text-white mb-0" ><label class="text-center p-2 pe-none" style="background-color: rgba(0, 0, 0, 0.349);cursor: pointer;" for="image"><i class="fas fa-plus fs-6"></i> CHANGE</label></p>
                        <input type="file" class="d-none" id="image">
                      </div>
                    </div>
                  </div>
                </div>
            </div>
            <div class="col-md-6 ">
                <div class="profile-head text-center text-lg-start">
                            <h5 id="user-name">
                               <?php
// USER FULL NAME :
$email = $_SESSION['client'];
$get_infos = $db -> prepare("SELECT * FROM users WHERE email='$email'");
$get_infos -> execute();
$user = $get_infos -> fetch();
if($user){
  $user_firstname= $user['firstname'];
  $user_lastname= $user['lastname'];
  echo $user_firstname . " " . $user_lastname;
}
?>
                            </h5>
                            <h6 class="mb-4">
                                User interface
                            </h6>
                   <!-- Tabs navs -->
<ul class="nav nav-tabs nav-fill mb-3" id="ex1" role="tablist">
  <li class="nav-item" role="presentation">
    <a
      class="nav-link active me-3"
      id="ex2-tab-1"
      data-mdb-toggle="tab"
      href="#ex2-tabs-1"
      role="tab"
      aria-controls="ex2-tabs-1"
      aria-selected="true"
      >Informations</a
    >
  </li>
  <li class="nav-item" role="presentation">
    <a
      class="nav-link me-3"
      id="ex2-tab-2"
      data-mdb-toggle="tab"
      href="#ex2-tabs-2"
      role="tab"
      aria-controls="ex2-tabs-2"
      aria-selected="false"
      >Orders</a
    >
  </li>
  <li class="nav-item" role="presentation">
    <a
      class="nav-link"
      id="ex2-tab-3"
      data-mdb-toggle="tab"
      href="#ex2-tabs-3"
      role="tab"
      aria-controls="ex2-tabs-3"
      aria-selected="false"
      >Favorites</a
    >
  </li>
</ul>
<!-- Tabs navs -->
                </div>
            </div>
            <div class="col-md-2 d-flex flex-column mt-5 align-items-center">
                <button class="btn btn-light rounded-pill mb-3" data-mdb-toggle="modal" data-mdb-target="#infos-change">Edite profile</button>
                <button class="btn btn-danger btn-floating" data-mdb-toggle="tooltip" data-mdb-placement="bottom" title="Logout" id="user_disconnect"> <i class="fas fa-sign-out-alt"></i></button>
            </div>
        </div>
        <hr>
        <div class="row shadow-1-strong p-3">
            <div class="col-md-4 shadow-2-strong mb-2" style="background-color: azure;">
                <div class="profile-work">
                    <p class="lead fs-4 text-decoration-underline text-center text-align-center">Get in touch :</p>
<div class="row row-cols-lg-3 text-center text-align-center p-5 ms-lg-3">
        <!-- Facebook -->
        <a class="btn btn-primary text-center  text-white me-3  text-align-center btn-floating" style="color: #3b5998;" href="#!" role="button">
        <i class="fab fa-facebook-f  "></i>
      </a> <br>
      
      <!-- Twitter -->
      <a class="btn btn-info text-center  text-white me-3 btn-floating" style="color: #55acee;" href="#!" role="button">
        <i class="fab fa-twitter  "></i>
      </a> <br>
      
      <!-- Google -->
      <a class="btn btn-danger text-center  text-white me-3 btn-floating" style="color: #dd4b39;" href="#!" role="button">
        <i class="fab fa-google "></i>
      </a> 
</div>

                </div>
            </div>
            <div class="col-md-8 ">
                <div class="tab-content profile-tab" id="myTabContent">
                  
<!-- Tabs content -->
<div class="tab-content" id="ex2-content">
  <div
    class="tab-pane fade show active ms-3"
    id="ex2-tabs-1"
    role="tabpanel"
    aria-labelledby="ex2-tab-1"
  >
  <?php
// USER ALL INFOS :
$email = $_SESSION['client'];
$get_infos = $db -> prepare("SELECT * FROM users WHERE email='$email'");
$get_infos -> execute();
$user = $get_infos -> fetch();
if($user){
  $user_firstname= $user['firstname'];
  $user_lastname= $user['lastname'];
  $user_phone= $user['client_phone'];
  $user_address= $user['client_address'];
  ?>
  <div class="row">
    <div class="col-md-6">
        <label>User Id</label>
    </div>
    <div class="col-md-6">
        <p><?php  echo $email; ?></p>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-md-6">
        <label>Firstname</label>
    </div>
    <div class="col-md-6">
        <p><?php  echo $user_firstname; ?></p>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-md-6">
        <label>Lastname</label>
    </div>
    <div class="col-md-6">
        <p><?php  echo $user_lastname; ?></p>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-md-6">
        <label>Phone</label>
    </div>
    <div class="col-md-6">
        <p><?php  if($user_phone===NULL){echo "Not available";}else{echo $user_phone;} ?></p>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-md-6">
        <label>Address</label>
    </div>
    <div class="col-md-6">
        <p><?php  if($user_address===""){echo "Not available";}else{echo $user_address;} ?></p>
    </div>
</div>

<?php
}
?>
  </div>
  <div
    class="tab-pane fade p-3"
    id="ex2-tabs-2"
    role="tabpanel"
    aria-labelledby="ex2-tab-2"
  >
  
  <div class="d-flex flex-column flex-lg-row flex-md-column justify-content-between pb-3">
    <p class="text-muted mb-3 fs-4 main-heading">Orders list :</p>
    
</div>
<div id="order_area"></div>
<div class="table-responsive" id="orders">
    <table class="table table-hover mb-0">
        <thead>
            <tr>
                <th>Order #</th>
                <th>Date Purchased</th>
                <th>Status</th>
                
            </tr>
        </thead>
        <tbody>
               <!-- Get client current orders -->
               <?php
           $current_email = $_SESSION['client'];
           $Get_orders = $db -> prepare("SELECT * FROM users_order_infos WHERE user_email='$current_email'");
           $Get_orders -> execute();
           while($order = $Get_orders -> fetch()){
            $random_id = rand();
            if($order){
$order_status = $order['order_status'];
$order_date = $order['order_date'];
?>
<tr>
 <td><a class="navi-link" href="#order-details" data-toggle="modal"><?php  echo "#" . $random_id; ?></a></td>
 <td><?php  echo $order_date; ?></td>
 <td>
  <?php  
  if($order_status === "confirmed"){
    ?>
<span class="badge badge-success m-0">Confirmed</span>
    <?php
  }else if($order_status==="removed"){
    ?>
    <span class="badge badge-danger m-0">Removed</span>
        <?php
  }else{
    ?>
    <span class="badge badge-secondary m-0">In progress</span>
        <?php
  }
  ?>
 </td>
</tr>
<?php
         
            }
           }
           if($Get_orders->rowCount()===0){
            ?>
<script>
var table = document.getElementById('orders');
var area = document.getElementById('order_area');
area.innerHTML = `<div class="alert alert-white fw-bold text-center">No sending orders yet</div>`
table.style.display ="none"
</script>
            <?php
           }
           ?>
        </tbody>
    </table>
</div>
  </div>
  <div
    class="tab-pane fade ms-3"
    id="ex2-tabs-3"
    role="tabpanel"
    aria-labelledby="ex2-tab-3"
  >
  <div class="row">
    <div class="col-md-12">
        <div class="main-heading mb-5 text-muted fs-4">My favorite list</div>
        <div id="response"></div>
        <div id="result"></div>
        <div class="table-wishlist" id="table">
         <div class="table-responsive">
          <table cellpadding="0" cellspacing="0" border ="0" width="100%">
            <thead>
              <tr>
                <th width="45%">Product Name</th>
                <th width="15%">Unit Price</th>
                <th width="15%">Stock Status</th>
                <th width="15%">Action</th>
              </tr>
            </thead>
            <tbody>
   <!-- Get favorites -->
   <?php
   $this_email = $_SESSION['client'];
   $favorites_list = $db -> prepare("SELECT * FROM favorites WHERE user_email='$this_email'");
   $favorites_list -> execute();
   while($favorite = $favorites_list -> fetch()){
    if($favorite){
      $fav_id = $favorite['product_id'];
      $fav_product_name = $favorite['product_name'];
      $fav_product_image = $favorite['product_image'];
      $fav_product_price = $favorite['product_price'];
      ?> 
      <tr>
              <td width="45%">
                <div class="display-flex align-center">
                                <div class="img-product">
                                    <img src="images/product-images/<?php echo $fav_product_image; ?>" alt="favorite-image" class="mCS_img_loaded">
                                </div>
                                <div class="name-product">
                                <?php echo $fav_product_name; ?>
                                </div>
                              </div>
                          </td>
              <td width="15%" class="price"><?php echo $fav_product_price; ?> TND</td>
              <td width="15%" class="text-center">
              <?php
// Get status 
$status = $db -> prepare("SELECT * FROM products WHERE product_id='$fav_id'");
$status -> execute();
$result = $status -> fetch();
if($result){
  $product_quantity = $result['product_quantity'];
  if($product_quantity > 2){
    ?>
<span class="in-stock-box bg-success fw-bold">In stock</span>
    <?php
  }else{
    ?>
<span class="in-stock-box bg-danger fw-bold">Out stock</span>
    <?php
  }
}
                      ?>
            </td>
              <td width="20%" class="text-center">
                <input type="hidden" value="<?php echo $fav_id; ?>">
              <button type="button" class="btn btn-light shadow-0" id="details"><i class="fas fa-eye text-primary"></i></button> 
              <button type="button" class="btn btn-danger shadow-0" id="delete_fav"><i class="fas fa-trash-alt text-white"></i></button>
              </td>
            </tr>
 <?php
    }

   }
  if($favorites_list -> rowCount()===0){
    ?>
    <script>
    var table = document.getElementById('table');
    var result = document.getElementById('result');
    table.style.display="none";
    result.innerHTML = `<div class="alert alert-white fw-bold text-center mt-5 ">Your favorite list is empty !</div>`;
    </script>
      <?php
  }
   ?>
            </tbody>
          </table>
         </div>
      </div>
    </div>
</div>
  </div>
</div>
<!-- Tabs content -->
                    <!-- <div class="tab-pane fade " id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Experience</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p>Expert</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Hourly Rate</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p>10$/hr</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Total Projects</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p>230</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>English Level</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p>Expert</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Availability</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p>6 months</p>
                                    </div>
                                </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label>Your Bio</label><br/>
                                <p>Your detail description</p>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
             
</div>
</div>
<!-- infos modal -->
<!-- Button trigger modal -->
<!-- Modal -->
<div class="modal fade " id="infos-change" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-mdb-backdrop="static">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Profil</h5>
        <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        
        <form id="profile-form">
        <?php
// USER MODAL INFO :
$email = $_SESSION['client'];
$get_infos = $db -> prepare("SELECT * FROM users WHERE email='$email'");
$get_infos -> execute();
$user = $get_infos -> fetch();
if($user){
  $user_firstname= $user['firstname'];
  $user_lastname= $user['lastname'];
  $user_phone= $user['client_phone'];
  $user_address= $user['client_address'];
  ?>
      <!-- 2 column grid layout with text inputs for the first and last names -->
      <div class="row mb-4">
            <div class="col">
              <div class="form-outline">
                <input type="text" id="edit-fname" value="<?php echo $user_firstname; ?>" class="form-control" required/>
                <label class="form-label" for="edit-fname">First name</label>
              </div>
            </div>
            <div class="col">
              <div class="form-outline">
                <input type="text" id="edit-lname" value="<?php echo $user_lastname; ?>" class="form-control" required/>
                <label class="form-label" for="edit-lname">Last name</label>
              </div>
            </div>
          </div>
          <div class="form-outline mb-4">
            <input type="text" id="edit-address" value="<?php echo $user_address; ?>" class="form-control" required/>
            <label class="form-label" for="edit-address">Adresse</label>
          </div>
          <!-- Email input -->
          <div class="form-outline mb-4">
            <input type="email" id="edit-email" value="<?php echo $email; ?>" class="form-control disabled pe-none" required/>
            <label class="form-label" for="edit-email">Email address</label>
          </div>
        
          <!-- tel input -->
          <div class="form-outline mb-4">
            <input type="number" id="edit-phone" value="<?php echo $user_phone; ?>" class="form-control" required/>
            <label class="form-label" for="edit-phone">Phone</label>
          </div>
          

<?php
 
}
?>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal" id="close">Close</button>
        <button type="submit" class="btn btn-primary" id="edit-profile">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!-- content end -->
<!-- js -->
<script>
  // customer profil edit

var customer_profile_image = document.getElementById('customer-profile-image')
var mask_profile = document.getElementById('mask-profile')

customer_profile_image.onmouseover = function (){
  mask_profile.classList = "mask"
}
customer_profile_image.onmouseleave = function (){
  mask_profile.classList = "mask d-none"
}

// edit profile code start :
var edit_profile_btn = document.getElementById('edit-profile');
var fname = document.getElementById('edit-fname');
var lname = document.getElementById('edit-lname');
var address = document.getElementById('edit-address');
var email = document.getElementById('edit-email');
var phone = document.getElementById('edit-phone');
var result = document.getElementById('edit-result');
var form = document.getElementById('profile-form');
var modal_close = document.getElementById('close');
edit_profile_btn.addEventListener('click' , function(e){
 if(fname.value === ""){
  return false
 }else if(lname.value === ""){
  return false
 }else if(address.value === ""){
  return false
 }else if(email.value === ""){
  return false
 }else if(phone.value === "" ){
  phone.classList.add('is-invalid')
  return false
 }else{
  e.preventDefault();
  phone.classList.remove('is-invalid')
  var edit_request = new XMLHttpRequest();
  var edit_form = new FormData();
  var infos = [fname.value , lname.value , address.value , email.value , phone.value  ];
  edit_form.append('edit_profile_infos' , infos);
  edit_profile_btn.disabled=true
  edit_profile_btn.innerHTML = "Saving...";
  edit_request.onreadystatechange = function (){
    if(edit_request.readyState === 4 && edit_request.status === 200){
      edit_profile_btn.disabled = false;
      edit_profile_btn.innerHTML="Save changes";
      result.innerHTML = edit_request.responseText;
      modal_close.click();
     $("#ex2-tabs-1").load(" #ex2-tabs-1");
     $("#user-name").load(" #user-name");
    }
  }
  edit_request.open('POST','response.php');
  edit_request.send(edit_form);
 }
})
// log out btn :
var log_out_btn = document.getElementById('user_disconnect');
    log_out_btn.onclick = function (){
      log_out_btn.disabled=true
      var req = new XMLHttpRequest();
      var form = new FormData()
      form.append('log','out')
      req.onreadystatechange = function (){
        if(req.readyState===4 && req.status===200){
          window.location.href="login.php"
        }
      }
     req.open('POST','response.php')
     req.send(form)
    }
    // delete from favorite list code start :
    var delete_fav = document.querySelectorAll('#delete_fav');
    var response = document.getElementById('response');
    delete_fav.forEach(fav => {
      fav.addEventListener('click' , function (){
        var fav_id = fav.parentElement.children[0].value;
        fav_parent = fav.parentElement.parentElement;
        // send request 
        var request = new XMLHttpRequest();
        var form_request = new FormData();
        form_request.append('fav_id',fav_id);
        fav.disabled = true;
        fav.innerHTML = `
        <div class="spinner-grow spinner-grow-sm text-white" role="status">
  <span class="visually-hidden">Loading...</span>
</div>`;
        request.onreadystatechange = function (){
          if(request.readyState === 4 && request.status === 200){
            fav.disabled = false;
fav.innerHTML = `
<i class="fas fa-trash-alt text-white"></i>
`;
response.innerHTML = request.responseText;
fav_parent.remove();
          }
        }
        request.open('POST','response.php');
        request.send(form_request);
      })
    })
    // check product details btns :
var details = document.querySelectorAll('#details');
details.forEach(detail => {
  detail.addEventListener('click' , function (){
    var detail_id = detail.parentElement.children[0];
    detail.style.pointerEvents="none";
    var detail_request = new XMLHttpRequest();
    var details_form = new FormData();
    details_form.append('detail_id',detail_id.value);
    detail_request.onreadystatechange = function (){
      if(detail_request.readyState === 4 && detail_request.status === 200){
        detail.style.pointerEvents="all";
        window.location.href="details.php";
      }
    }
    detail_request.open('POST','response.php');
    detail_request.send(details_form);
  })
})
</script>
<?php
include "includes/footer.php";
?>
