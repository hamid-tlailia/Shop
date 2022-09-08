<?php
include "includes/header.php";
?>
<!-- content start -->
<div class="container-flui p-5 bg-white">
  <div class="row"><h3 class="text-muted text-center text-decoration-underline">Shopping Cart</h3></div>
  <div class="mt-3 px-lg-0 shadow-1-strong p-3" style="background-color: azure;border-radius: 0 0 0 500px;">
    <div class="pb-5">
      <div class="container">
        <?php
if(isset($_SESSION['removed'])){
  echo $_SESSION['removed'];
  if($_SESSION['timer']-time() == 0){
    unset($_SESSION['removed']);
  }
}
if(isset($_SESSION['update'])){
  echo $_SESSION['update'];
  if($_SESSION['timer']-time() == 0){
    unset($_SESSION['update']);
  }
}
// max session:
if(isset($_SESSION['max'])){
  echo $_SESSION['max'];
  if($_SESSION['timer']-time() == 0){
    unset($_SESSION['max']);
  }
}
?>
        <div class="row">
          <div class="col-lg-12 p-5 bg-white rounded shadow-sm mb-5">
  
            <!-- Shopping cart table -->
            <div class="table-responsive">
              <div id="empty"></div>
              <table class="table" id="table_parent">
                <thead>
                  <tr>
                    <th scope="col" class="border-0 bg-light">
                      <div class="p-2 px-3 text-uppercase">Product</div>
                    </th>
                    <th scope="col" class="border-0 bg-light">
                      <div class="py-2 text-uppercase">Price</div>
                    </th>
                    <th scope="col" class="border-0 bg-light">
                      <div class="py-2 text-uppercase">Quantity</div>
                    </th>
                    <th scope="col" class="border-0 bg-light"><div class="py-2 text-uppercase">Total</div></th>
                    <th scope="col" class="border-0 bg-light">
                      <div class="py-2 text-uppercase">Remove</div>
                    </th>
                  </tr>
                </thead>
                <tbody id="table">
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
    <tr>
                    <th scope="row" >
                      <div class="p-2">
                        <img src="images/product-images/<?php echo $image_name.$image_src; ?>" alt="product" width="70" class="img-fluid rounded shadow-sm me-2">
                        <div class="ml-3 d-inline-block align-middle">
                          <h5 class="mb-0"> <a href="#" class="text-dark d-inline-block align-middle"><?php  echo $product_name; ?></a></h5><span class="text-muted font-weight-normal font-italic d-block"><?php  echo $product_description; ?></span>
                        </div>
                      </div>
                    </th>
                    <td class=" align-middle"><strong><?php  echo $product_price; ?> TND</strong></td>
                    <td class=" align-middle">
                      <form action="response.php" method="POST">
                      <div class="d-flex flex-row">
                        <input type="hidden" name="id" value="<?php  echo $cart_id; ?>">
                      <button class="btn btn-secondary shadow-0  rounded-0 text-white" id="mince" type="submit" name="mince">-</button>
                      <input type="number" class="form-control pe-none w-auto rounded-0 text-center" value="<?php echo $product_quantity; ?>" max="<?php echo $available_quantity; ?>" data-max="<?php echo $available_quantity; ?>"  class="form-control" id="quantity" name="quantity">
                      <button class="btn btn-secondary shadow-0 rounded-0 text-white" id="plus" type="submit" name="plus">+</button>
                    </div>
                      </form>
                    </td>
                    <td class=" align-middle"><?php  echo $total; ?> TND</td>
                    <td class=" align-middle">
                      <form action="response.php" method="POST">
                      <input type="hidden" value="<?php echo $cart_id;  ?> " name="unset_id">
                      <input type="hidden" value="cart.php" name="redirect">
                      <button class="btn btn-light shadow-0" name="dell"><a href="#" class="text-dark"><i class="far fa-trash-alt text-danger"></i></a></button>
                      </form>
                    </td>
                  </tr>
      <?php
    
 }
  
}
?>
                
                </tbody>
              </table>
            </div>
            <!-- End -->
          </div>
        </div>
        <div class="row"><h3 class="text-muted text-center text-decoration-underline">SUMMARY</h3></div>
        <div class="row  p-4 bg-white rounded shadow-sm">
          <div class="col-lg-6">
            <div class="bg-light rounded-pill px-4 py-3 text-uppercase font-weight-bold">Coupon code</div>
            <div class="p-4">
              <p class="font-italic mb-4">If you have a coupon code, please enter it in the box below</p>
              <div class="input-group mb-4 border rounded-pill p-2">
                <input type="text" placeholder="Apply coupon" aria-describedby="button-addon3" class="form-control border-0">
                <div class="input-group-append border-0">
                  <button id="button-addon3" type="button" class="btn btn-dark px-4 rounded-pill"><i class="fa fa-gift mr-2 me-2"></i>Apply coupon</button>
                </div>
              </div>
            </div>
            <div class="bg-light rounded-pill px-4 py-3 text-uppercase font-weight-bold">Instructions for seller</div>
            <div class="p-4">
              <p class="font-italic mb-4">If you have some information for the seller you can leave them in the box below</p>
              <textarea name="" cols="30" rows="2" class="form-control"></textarea>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="bg-light rounded-pill px-4 py-3 text-uppercase font-weight-bold">Order summary </div>
            <div class="p-4">
              <p class="font-italic mb-4">Shipping and additional costs are calculated based on values you have entered.</p>
              <ul class="list-unstyled mb-4">
                <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Order Subtotal </strong><strong><?php  echo $g_total; ?> TND</strong></li>
                <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Shipping and handling</strong><strong>0.00 TND</strong></li>
                <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Tax</strong><strong>0.00 TND</strong></li>
                <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Total</strong>
                  <h5 class="font-weight-bold"><?php  echo $g_total; ?> TND</h5>
                </li>
              </ul>
              <div class="row">
                <div class="col-sm"><a href="categories.php" class="btn btn-dark rounded-pill py-2 btn-block mb-2"><i class="fas fa-arrow-left"></i> Continue shopping</a></div>
                <div class="col-sm"><a href="checkout.php" id="checkout" class="btn btn-dark rounded-pill py-2 btn-block mb-2">Procceed to checkout <i class="fas fa-arrow-right"></i></a></div>
              </div>
            </div>
          </div>
        </div>
  
      </div>
    </div>
  </div>
</div>
  <!-- content end -->
  <!-- js -->
  <script>
    // cart input button plus code :
    var plus = document.querySelectorAll('#plus');
var minces  = document.querySelectorAll('#mince');
plus.forEach (pluse => {
  pluse.addEventListener('click' , function(){
    var input = pluse.parentElement.children[1];
    input.value+1;
  })
})
// cart input button mince code :
minces.forEach (mince => {
  mince.addEventListener('click' , function(){
    var input2 = mince.parentElement.children[1];
  if(input2.value>2){
    input2.value-1;
  }
  })
})

// cart check empty if is :
  var table = document.getElementById('table');
  var table_parent = document.getElementById('table_parent');
  var empty = document.getElementById('empty');
  var checkout = document.getElementById('checkout');
  setInterval(function (){
    if(table.children.length === 0){
      empty.innerHTML = "Your cart is empty"
      empty.classList = "alert alert-warning text-dark text-center fw-bold rounded-0"
      table_parent.style.display= "none"
      checkout.style.pointerEvents = "none"
    }
  },100)
  // cart empty check :
setInterval (function (){
  var carts = document.querySelectorAll('#cart');
carts.forEach(cart => {
  if(cart.children.length === 0){
    cart.innerHTML =`<div class="alert alert-white text-center p-3 fw-bold">Your cart is empty</div>`;
  }
})
},100)
  </script>
  <?php
include "includes/footer.php";
?>