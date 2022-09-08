<?php
include "includes/header.php";
?>
  <!-- content start -->
<div class="container-fluid p-5 bg-white">
<div id="add_result">
          <?php 
if(isset($_SESSION['added'])){
  echo $_SESSION['added'];
  if($_SESSION['timer']-time() == 0){
    unset($_SESSION['added']);
  }
}
          ?>
        </div>
  <div class="main-heading mb-5 text-muted text-decoration-underline text-center fs-4">My wishlist</div>
  <div class="row shadow-1-strong p-3">
    <div class="col-lg-4 text-center d-none d-lg-block "><img src="images/wishlist.png" class="img-fluid p-1" alt="wishlist"></div>
    <div class="col-lg-8">
      <div class="row">
        <div class="col-md-12">
            
            <div class="table-wishlist">
              <div id="result"></div>
             <div class="table-responsive" id="table">
              <table  class="table table-hover" width="100%">
                <thead>
                  <tr>
                    <th width="45%">Product Name</th>
                    <th width="15%">Unit Price</th>
                    <th width="15%">Stock Status</th>
                    <th width="10%">Action</th>
                  </tr>
                </thead>
                <tbody>
 <!-- GET session wishlist if exists  -->
 <?php
if(isset($_SESSION['wish']) && !empty($_SESSION['wish'])){
foreach($_SESSION['wish'] as $key => $value){
$id = $value['id'];
$name = $value ['name'];
$price = $value['price'];
$image_src = $value['image_src'];
  ?>
             <tr class="border-bottom">
                    <td width="45%">
                      <div class="display-flex align-center">
                                      <div class="img-product">
                                          <img src="images/product-images/<?php echo $image_src; ?>" alt="wish_image" class="mCS_img_loaded">
                                      </div>
                                      <div class="name-product">
                                      <?php echo $name; ?>
                                      </div>
                                    </div>
                                </td>
                    <td width="15%" class="price"><?php echo $price; ?> TND</td>
                    <td width="15%">
                      <?php
// Get status 
$status = $db -> prepare("SELECT * FROM products WHERE product_id='$id'");
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
                  <form action="response.php" method="POST">
                    <input type="hidden" value="<?php echo $id;  ?>" name="wish_id">
                  <td width="10%" class="text-center align-items-center">
                  <input type="hidden" value="<?php echo $id;  ?>" name="wish_id">
                      <button type="button" class="btn btn-light shadow-0" id="details"><i class="fas fa-eye text-primary"></i></button> 
                      <button type="submit" class="btn btn-danger shadow-0" name="delete_wish"><i class="fas fa-trash-alt text-white"></i></button>
                    </td>
                  </form>
                  </tr>
                  <hr>
  <?php
}
}else{
  ?>
<script>
var table = document.getElementById('table');
var result = document.getElementById('result');
table.style.display="none";
result.innerHTML = `<div class="alert alert-warning fw-bold text-center mt-5 lead">Your wishlist is empty !</div>`
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
</div>
  <!-- content end -->
  <!-- js -->
  <script>
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