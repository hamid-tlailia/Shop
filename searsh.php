<?php
include "includes/header.php";
// Redirect URL SESSION:
if(isset($_SESSION['search'])){
  #Return this page
}else{
  ?>
<script>
  window.location.href = "home.php";
</script>
  <?php
}
?>
  <!-- content start -->
<div class="container-fluid p-5 bg-light">
  <div class="row"><h3 class="text-muted text-center text-decoration-underline mb-3 ">Result search</h3></div>
  <div class="container">
    <div class="row p-3 mt-4 shadow-1-strong" style="background-color: azure;border-radius: 0 0 0 0;">
      <h3 class="text-danger text-center shadow-2-strong p-2 mb-3 " style="margin-top: -5vh;background-color: azure;margin-left: start;max-width: max-content;">Search for <span class="text-secondary">"<?php  
      if(isset($_SESSION['search'])){
        echo $_SESSION['search'];
      }
      ?>"</span></h3> <hr>
      <div class="col-lg-8">
      <?php
// search function code start :
try{
  if(isset($_SESSION['search']) && !empty($_SESSION['search'])){
    $word = $_SESSION['search'];
    $get_product_infos = $db->prepare("SELECT * FROM products WHERE product_name LIKE '%$word%' ORDER BY product_publish_date DESC ");
    $get_product_infos->execute();
    $count = $get_product_infos -> rowCount();
    ?>
<h5 class="text-muted">We found <span class="text-danger"><?php  echo $count; ?></span> result(s)</h5> <br>
    <?php
    while ($product = $get_product_infos->fetch()) {
      if ($product) {
        $product_id = $product['product_id'];
        $product_name = $product['product_name'];
        $product_price = $product['product_price'];
        $product_quantity = $product['product_quantity'];
        $product_description = $product['product_description'];
        $product_disponibity = $product['product_disponibity'];
        $product_promotion_rate = $product['product_promotion_rate'];
        $product_promotion_end = $product['product_promotion_end'];
        ?>
<!-- result template -->
<div class="row shadow-1-strong p-2 mb-2">
<div class="col-lg-2">
<?php
                    // get product images :
                    $get_product_images = $db->prepare("SELECT * FROM product_images WHERE product_id ='$product_id' LIMIT 1");
                    $get_product_images->execute();
                    $images = $get_product_images->fetch();
                    if ($images) {
                      $image_id = $images['image_id'];
                      $image_name = $images['image_name'];
                      $image_src = $images['image_src'];
                    ?>
<img src="images/product-images/<?php echo $image_name . $image_src; ?>" class="img-fluid rounded-circle p-3  shadow-2-strong text-center" style="width:150px ;height: 110px;"/>
                    <?php
                    }
                    ?>
</div>
<div class="col-lg-4 border-end border-lg-dark"><h5 class="text-muted text-dark mt-2"><?php  echo $product_name ?></h5>  <p class="lead"><?php  echo $product_description ?> </p></div>
<div class="col-lg-3 pt-4  align-items-center border-end border-lg-dark">Price : <span class="text-danger">
<?php
if ($product_promotion_rate != "0") {
echo $product_price - ($product_price * ($product_promotion_rate / 100));  ?> TND <br> <sub style="text-decoration:line-through"><?php echo $product_price; ?> TND</sub> <?php
 } else {
   echo $product_price . " TND";
 }
   ?>
</span></div>
<div class="col-lg-3 pt-4  align-items-center">
  <div class="d-flex flex-column  flex-lg-row flex-md-row justify-content-evenly justify-items-center">
    <input type="hidden" value="<?php echo $product_id; ?>">
  <a role="button" href="#" class="text-primary shadow-2-strong text-center btn-floating mb-2" data-mdb-toggle="tooltip" data-mdb-placement="bottom" title="View product" id="details"><i class="fas fa-eye"></i></a>
  <a role="button" href="#" class="text-primary shadow-2-strong text-center btn-floating mb-2" data-mdb-toggle="tooltip" data-mdb-placement="bottom" title="add wishlist" id="wishlist-add"><i class="fas fa-heart"></i></a>
</div>
</div>
</div>
<!-- /result template -->

<?php
      }
    }
  }
  global $count;
  if($count === 0){
    ?>
<div class="alert alert-danger rounded-0 text-center fw-bold mt-5 p-2">No result found for this word !</div>
    <?php
  }
  }
  catch(Exception $e){
    die("Error :" .$e->getMessage());
  }
    ?>
      </div>
      <div class="col-lg-4  p-3 shadow-2-strong " style="background-color: azure;margin-top: 5vh;">
<h5 class="text-muted mb-3 ms-4">You maybe like this :</h5>
<div class="d-flex flex-column flex-lg-row flex-md-row justify-content-evenly justify-items-center">
  <div class="bg-image mb-2 rounded">
    <img
      src="images/Blue_Tshirt.png"
      class="img-fluid"
      alt="show"
  style="width:150px ;height: 150px;"
    />
    <div class="mask" style="background-color: rgba(0, 0, 0, 0.377);width: 150px;height: 150px;">
      <div class="d-flex justify-content-center align-items-center h-100">
        <p class="text-white mb-0 me-3"><button class="btn btn-transparent text-danger fs-5 btn-floating " data-mdb-toggle="tooltip" data-mdb-placement="top" title="Add to cart"><i class="fas fa-shopping-cart"></i></button></p>
        <p class="text-white mb-0"><button class="btn btn-transparent text-light fs-5 btn-floating  fw-bold" data-mdb-toggle="tooltip" data-mdb-placement="top" title="Share it"><i class="fas fa-share-alt-square"></i></button></p>
      </div>
    </div>
  </div>
  <div class="bg-image mb-2 rounded" >
    <img
      src="images/Blue_Tshirt.png"
      class="img-fluid"
      alt="show"
  style="width:150px ;height: 150px;"
    />
    <div class="mask" style="background-color: rgba(0, 0, 0, 0.377);width: 150px;height: 150px;">
      <div class="d-flex justify-content-center align-items-center h-100">
        <p class="text-white mb-0 me-3"><button class="btn btn-transparent text-danger fs-5 btn-floating " data-mdb-toggle="tooltip" data-mdb-placement="top" title="Add to cart"><i class="fas fa-shopping-cart"></i></button></p>
        <p class="text-white mb-0"><button class="btn btn-transparent text-light fs-5 btn-floating  fw-bold" data-mdb-toggle="tooltip" data-mdb-placement="top" title="Share it"><i class="fas fa-share-alt-square"></i></button></p>
      </div>
    </div>
  </div>
</div>
<div class="row ps-4">
  <h5 class="text-muted mb-3  mt-3">Blogs & Team :</h5>
  <a class=" text-decoration-underline" href="blogs.php">Blogs</a>
  <a class=" text-decoration-underline" href="about.php">Teams</a>
</div>
<h5 class="text-muted mb-3 ms-4 mt-3">Social Media :</h5>
<div class=" d-flex flex-column flex-lg-row flex-md-row justify-content-center justify-items-center">
  <!-- Facebook -->
<a class="btn btn-primary text-center  text-white me-3 mb-2" style="color: #3b5998;" href="#!" role="button">
<i class="fab fa-facebook-f "></i>
</a>

<!-- Twitter -->
<a class="btn btn-info text-center  text-white me-3 mb-2" style="color: #55acee;" href="#!" role="button">
<i class="fab fa-twitter "></i>
</a>

<!-- Google -->
<a class="btn btn-danger text-center  text-white me-3 mb-2" style="color: #dd4b39;" href="#!" role="button">
<i class="fab fa-google"></i>
</a>

<!-- Instagram -->
<a class="btn btn-primary me-3 mb-2" style="background-color: #ac2bac;" href="#!" role="button">
<i class="fab fa-instagram"></i>
</a>
</div>
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
  <!-- js -->
  <script>
     // add to wishlist btn function start :
  var wishlist_add_btn = document.querySelectorAll('#wishlist-add');
  var name_place = document.getElementById('p_name');
  var image_place = document.getElementById('p_image');
  var id_place = document.getElementById('p_id');
  var wish_modal = document.getElementById('wish_add');
  wishlist_add_btn.forEach(wish_btn => {
    wish_btn.addEventListener('click', function() {
      var p_id = wish_btn.parentElement.children[0];
      id_place.value = p_id.value;
      wish_modal.click();
    })
  })
  // check product details btns :
  var details = document.querySelectorAll('#details');
  details.forEach(detail => {
    detail.addEventListener('click', function() {
      var detail_id = detail.parentElement.children[0];
      detail.style.pointerEvents = "none";
      var detail_request = new XMLHttpRequest();
      var details_form = new FormData();
      details_form.append('detail_id', detail_id.value);
      detail_request.onreadystatechange = function() {
        if (detail_request.readyState === 4 && detail_request.status === 200) {
          detail.style.pointerEvents = "all";
          window.location.href = "details.php";
        }
      }
      detail_request.open('POST', 'response.php');
      detail_request.send(details_form);
    })
  })
  </script>
  <?php
include "includes/footer.php";
?>