<?php
include "includes/header.php";
?>
<!-- content start -->
<div class="container-fluid p-5 bg-white">
  <div class="row"><h3 class="text-muted text-center text-decoration-underline mb-3">Checkout form</h3></div>
  <div class="row p-3 shadow-1-strong" style="background-color: azure;border-radius: 0 0 500px 0;">
    <div class="col-lg-8">
    
      <form id="checkout-form">
        <!-- 2 column grid layout with text inputs for the first and last names -->
        <div class="row mb-4">
          <h4 class="fw-bold mb-4" style="color: #92aad0;">Fast Shipping</h4>
          <p class="mb-4" style="color: #45526e;">To send a valid order , please fill in these text fiels with your correct informations.</p>
          <div class="col-lg-6">
            <div class="form-outline">
              <input type="text"  class="form-control mb-2" id="fname" required/>
              <label class="form-label" for="fname">First name</label>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="form-outline">
              <input type="text" class="form-control mb-2" id="lname" required/>
              <label class="form-label" for="lname">Last name</label>
            </div>
          </div>
        </div>
       
     <div class="row">
      <div class="col-lg-6">
           <!-- Text input -->
           <div class="form-outline mb-4">
          <input type="text"  class="form-control" id="addresse" required/>
          <label class="form-label" for="addresse">Address</label>
        </div>
      </div>
      <div class="col-lg-6">
           <!-- Text input -->
           <div class="form-outline mb-4">
          <input type="number"  class="form-control" id="zip" required/>
          <label class="form-label" for="zip">Zip code</label>
        </div>
      </div>
     </div>
      
        <!-- Email input -->
        <div class="form-outline mb-4">
          <input type="email"  class="form-control" id="email" required/>
          <label class="form-label" for="email">Email</label>
        </div>
      
        <!-- Number input -->
        <div class="form-outline mb-4">
          <input type="number"  class="form-control" id="phone" required/>
          <label class="form-label" for="phone">Phone</label>
        </div>
      
        <!-- Message input -->
        <div class="form-outline mb-4">
          <textarea class="form-control" rows="4" id="infos"></textarea>
          <label class="form-label" for="infos">Additional information</label>
        </div>
     
    </div>
    <?php 
               $total=0;
               $g_total=0;
if(isset($_SESSION['cart'])){
 foreach ($_SESSION['cart'] as $key => $value){
  $total = $value['price']*$value['qty'];
  $g_total+= $total = $value['price'] * $value['qty'];
  $cart_id = $value['id'];
    // search product id from session :
      $product_name = $value['name'];
      $product_price = $value['price'];
      $product_quantity = $value['qty'];
      $product_description = $value['description'];
      $product_promotion_rate = $value['promotion'];
      $product_promotion_end = $value['date'];
      $image_name =$value['image_name'];
      $image_src = $value ['image_src'];
  $get_quantity = $db -> prepare("SELECT * FROM products WHERE product_id = '$cart_id'");
  $get_quantity -> execute();
  $result_quantity = $get_quantity -> fetch();
if($result_quantity){$available_quantity  = $result_quantity['product_quantity'];}
?>
<input type="hidden" value="<?php echo $product_name;  ?>" id="p-name">
<?php
}

}
      ?>
    <div class="col-lg-4 pt-4">
      <p class="lead alert-danger" id="payement"></p>
      <div class="bg-light rounded-pill px-4 py-3 text-uppercase fw-bold text-danger">Order summary </div>
      <div class="p-4">
        <p class="font-italic mb-4">Shipping and additional costs are calculated based on values you have entered.</p>
        <ul class="list-unstyled mb-4">
          <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Order Subtotal </strong><strong><?php echo $g_total; ?> TND</strong></li>
          <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Shipping and handling</strong><strong>0.00 TND</strong></li>
          <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Tax</strong><strong>0.00 TND</strong></li>
          <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Total</strong>
            <h5 class="font-weight-bold"><span id="total"><?php echo $g_total; ?></span> TND</h5>
          </li>
        </ul>
         <!-- Checkbox -->
         <div class="form-check d-flex justify-content-center mb-4">
          <input class="form-check-input me-2" type="checkbox"  id="obligation" checked />
          <label class="form-check-label" for="obligation"> Order with obligation of payment </label>
        </div>
        <div class="row">
          <div class="col-sm"><button class="btn btn-dark rounded-pill py-2 btn-block mb-2" type="submit"  id="btn-checkout"><i class="fas fa-shipping-fast"></i> Order</button></div>
        </div>
      </div>
    </div>
    </form>
  </div>
</div>
<!-- response modal -->
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary d-none" data-mdb-toggle="modal" data-mdb-target="#mail" id="mail-modal">
  
</button>

<!-- Modal -->
<div class="modal top fade" id="mail" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-mdb-backdrop="static" data-mdb-keyboard="true">
  <div class="modal-dialog   modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body p-3" id="result"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">
          OK
        </button>
      </div>
    </div>
  </div>
</div>
  <!-- content end -->
  <!-- js -->
  <script>
    // btn - checkout code start
var btn_checkout = document.getElementById("btn-checkout")
var input_checkbox = document.getElementById('obligation')
var payement = document.getElementById('payement')
setInterval(function(){
  if(input_checkbox.checked === true){
    btn_checkout.style.pointerEvents="all"
    payement.innerHTML=""
    payement.style.padding="0"
      }else{
        btn_checkout.style.pointerEvents="none"
        payement.innerHTML=`<i class="fas fa-exclamation-triangle"></i> You must agree to pay when receive order`
        payement.style.padding="5px"
      }
},100)
var fname = document.getElementById('fname');
var lname = document.getElementById('lname');
var addresse = document.getElementById('addresse');
var email = document.getElementById('email');
var phone = document.getElementById('phone');
var infos = document.getElementById('infos');
var zip = document.getElementById('zip');
var checkout_form = document.getElementById('checkout-form');
var product_name = document.querySelectorAll('#p-name');
var result = document.getElementById('result');
var total = document.getElementById('total');
var mail_modal_btn = document.getElementById('mail-modal');
btn_checkout.addEventListener('click' , function (e){
if(fname.value === "" ) {
  return false;
}else if(lname.value === ""){
return false;
}else if(addresse.value === ""){
return false;
}else if(email.value === ""){
return false;
}else if(phone.value ===""){
  return false;
}else if(zip.value === ""){
  return false;
}
else{
e.preventDefault();
btn_checkout.disabled = true ;
btn_checkout.innerHTML=`
  <span class="me-3">Sending</span>
  <div class="spinner-border spinner-border-sm" role="status"></div>`
var checkout_request = new XMLHttpRequest();
var form = new FormData();
var form_infos = [fname.value , lname.value , addresse.value , email.value , phone.value , infos.value , total.innerText , zip.value];
form.append('checkout_infos' , form_infos);
checkout_request.onreadystatechange = function (){
  if(checkout_request.readyState === 4 && checkout_request.status === 200){
btn_checkout.disabled = false;
result.innerHTML = checkout_request.responseText;
btn_checkout.innerHTML=`<i class="fas fa-shipping-fast"></i> Order`
mail_modal_btn.click();
checkout_form.reset();

  }
}
checkout_request.open('POST','response.php');
  checkout_request.send(form);
}
})
  </script>
<?php
include "includes/footer.php";
?>