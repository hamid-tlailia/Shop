<?php
include "includes/header.php";
?>
<!-- content start -->
<div class="container-fluid p-5 bg-white">
  <h3 class="text-muted text-center text-decoration-underline mb-3">Product details</h3>
  <div class="container">
  <?php 
if(isset($_SESSION['added'])){
  echo $_SESSION['added'];
  if($_SESSION['timer']-time() == 0){
    unset($_SESSION['added']);
  }
}
if(isset($_SESSION['removed'])){
  echo $_SESSION['removed'];
  if($_SESSION['timer']-time() == 0){
    unset($_SESSION['removed']);
  }
}
          ?>
    <div class="row d-flex justify-content-center">
        <div class="col-md-12 p-5 shadow-2-strong">
<!-- set event with btn details click -->
<?php
if(isset($_SESSION['details'])){
$detail_id = $_SESSION['details'];
// Get product infos :
$product_infos = $db -> prepare("SELECT * FROM products WHERE product_id='$detail_id'");
$product_infos -> execute();
$product = $product_infos -> fetch();
if($product){
    $product_id = $product['product_id'];
    $product_name = $product['product_name'];
    $product_price = $product['product_price'];
    $product_quantity = $product['product_quantity'];
    $product_description = $product['product_description'];
    $product_disponibity = $product['product_disponibity'];
    $product_promotion_rate = $product['product_promotion_rate'];
    $product_promotion_end = $product['product_promotion_end'];
    ?>
            <div class="card shadow-0">
                <div class="row alert-info">
                    <div class="col-md-6 col-12 col-lg-6  bg-white" style="border-radius:0 300px 300px 0 ;">
                        <div class="images p-3 text-center">
                            <div class="text-center p-4"> 
                                <!-- Get single image Show -->
                                <?php
                          $single_image = $db -> prepare("SELECT * FROM product_images WHERE product_id='$detail_id' LIMIT 1");
                          $single_image -> execute();
                          $single = $single_image -> fetch();
                          if($single){
$single_name = $single['image_name'];
$single_src = $single['image_src'];
                            ?>
<img id="main-image" class="mb-4 img-fluid" src="images/product-images/<?php echo $single_name.$single_src; ?>" width="250" height="250" />
                            <?php
                          }
                                ?>
                        </div>
                            <div class="thumbnail text-center "> 
                                <!-- Get all images -->
                                <?php
                          $single_image = $db -> prepare("SELECT * FROM product_images WHERE product_id='$detail_id'");
                          $single_image -> execute();
                         while( $single = $single_image -> fetch()){
                            if($single){
                                $single_name = $single['image_name'];
                                $single_src = $single['image_src'];
                                                            ?>
<img  class=" me-3 shadow-1-strong" width="120" height="120"  onclick="change_image(this)" src="images/product-images/<?php echo $single_name.$single_src; ?>" >
<?php
                                                          }
                         }
                                ?>  
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-12 col-lg-6">
                        <div class="product p-2">
                            <div class="d-flex justify-content-between mb-4 align-items-center">
                                <div class="d-flex align-items-center"> <a href="categories.php"><i class="fa fa-long-arrow-left me-3"></i> <span class="ml-1"> Back</span></a> </div> <i class="fa fa-shopping-cart text-muted"></i>
                            </div>
                           
                                <h5 class="text-uppercase mb-2"><?php  echo $product_name; ?></h5>
                                <div class="price d-flex flex-row align-items-center"> <?php
                            if($product_promotion_rate>0){
                                ?>
                          <span class="act-price me-2"><?php echo $product_price-($product_price*($product_promotion_rate/100)); ?></span>
                                <?php
                            }else{
                                ?>
                                <span class="act-price me-2"><?php echo $product_price; ?> TND</span>
                                      <?php  
                            }
                                ?>
                                    <div class="ml-2"> 
                                        <?php
                                        if($product_promotion_rate>0){
                                            ?>
                                            <small class="dis-price"><?php  echo $product_price;?> TND</small>

<?php
                                        }
                                        ?>
                                        <?php if($product_promotion_rate>0){
                                        ?>  <span><?php echo $product_promotion_rate; ?> % OFF</span> <?php
                                    } ?> </div>
                                </div>
                            </div>
                            <p class="about p-3 pb-3 rounded-pill text-warning fw-bold shadow-2-strong "><?php  echo $product_description;?></p>
                            <div class="sizes mt-3">
                                <h6 class="text-uppercase mb-3">Disponibility :</h6> 
              <div id="disponible">
              <?php
if($product_quantity>=2){
    ?> <span class="badge bg-success rounded-0 text-white fw-bold">IN STOCK</span>  <?php
   }else{
     ?> <span class="badge bg-danger rounded-0 text-white fw-bold">OUT STOCK</span>  <?php
   }
                          ?>
              </div>
              <hr>
                            </div>
                         <form action="response.php" method="POST">
                         <div class="mt-5 ms-1 align-items-center d-flex flex-row justify-content-center justify-items-center"> 
                         <input type="hidden" value="<?php echo  $product_name;?>" id="p_name">
                          <input type="hidden" value="<?php echo  $product_id;?>" name="cart_id">
                          <input type="hidden" value="details.php" name="page">
            <button class="btn btn-danger btn-block  w-75 text-uppercase mt-1 mr-2 px-4 me-3" id="add_cart" name="add_cart" type="submit">Add to cart</button> 
             <i class="fa fa-heart text-dark shadow-2-strong p-2 rounded-1 me-3" style="cursor: pointer;" id="wishlist-add" data-mdb-toggle="tooltip" data-mdb-placement="bottom" title="I like it"></i> 
                            </div>
                         </form>
                        </div>
                    </div>
                </div>
            </div>
<?php
}
}else{
?>
<div class="alert alert-danger text-center fw-bold">This page can't be reached without request ... <a href="home.php">Go back Home</a></div>
<?php
}
?>
        </div>
    </div>
</div>
</div>
<!-- content end -->
<!-- wishlist favorite modal choice -->
  <!-- Button trigger modal -->
  <button type="button" class="btn btn-primary d-none" data-mdb-toggle="modal" data-mdb-target="#wishlist" id="wish_add">
  Launch demo modal
</button>
<!-- Modal -->
<div class="modal top fade" id="wishlist" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-mdb-backdrop="true" data-mdb-keyboard="true">
  <div class="modal-dialog modal-sm ">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add request</h5>
        <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
      </div>
     <form action="response.php" method="POST">
     <div class="modal-body">
      <input type="hidden" id="p_id" name="p_id">
        <h5 class="text-secondary text-center lead">Where you want add this?</h5>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-outline-secondary" name="favorite">Favorites</button>
        <button type="submit" class="btn btn-primary" name="wishlist">Wishlist</button>
      </div>
     </form>
    </div>
  </div>
</div>
<!-- css -->
<style>
  .card{border:none}
  
  .brand{font-size: 13px}
.act-price{color:red;font-weight: 700}
.dis-price{text-decoration: line-through}
.about{font-size: 14px}
.color{margin-bottom:10px}
label.radio{cursor: pointer}
label.radio input{position: relative;top: 0;left: 0;visibility: hidden;pointer-events: none}
label.radio span{padding: 2px 9px;border: 2px solid #ff0000;display: inline-block;
color: #ff0000;border-radius: 3px;text-transform: uppercase}
label.radio input:checked + span{border-color: #ff0000;background-color: #ff0000;color: #fff}
.btn-danger{background-color: #ff0000 !important;border-color: #ff0000 !important; }
.btn-danger:hover{background-color: #da0606 !important;border-color: #da0606 !important}
.btn-danger:focus{box-shadow: none}
.cart i{margin-right: 10px}
</style>
<!-- js -->
<script>
  function change_image(image){

var container = document.getElementById("main-image");

container.src = image.src;
}

// cart empty check :
setInterval (function (){
  var carts = document.querySelectorAll('#cart');
carts.forEach(cart => {
  if(cart.children.length === 0){
    cart.innerHTML =`<div class="alert alert-white text-center p-3 fw-bold">Your cart is empty</div>`;
  }
})
},100)
  // product availability :
  setInterval(function (){
      var availabilities = document.querySelectorAll('#disponible'); 
availabilities.forEach(avail => {
if(avail.children[0].innerHTML == "OUT STOCK"){
  var btn = avail.parentElement.parentElement.children[3].children[0].children[3];
 btn.classList="btn btn-light shadow-0 disabled pe-none btn-block me-2"
}
})
     },100)
     // add to wishlist btn function start :
var wishlist_add_btn = document.querySelectorAll('#wishlist-add');
var name_place = document.getElementById('p_name');
var image_place = document.getElementById('p_image');
var id_place = document.getElementById('p_id');
var wish_modal = document.getElementById('wish_add');
wishlist_add_btn.forEach(wish_btn => {
  wish_btn.addEventListener('click' , function (){
    var p_id = wish_btn.parentElement.children[1];
    id_place.value = p_id.value;
    wish_modal.click();
  })
})

</script>
<?php
include "includes/footer.php";
?>