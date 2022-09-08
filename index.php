<?php
include "includes/header.php";
?>
  <!-- content start -->

<div class="container-fluid p-3 shadow-1-strong ">
<div class="row mt-2 m-0 ">
  <div class="col-lg-3 col-md-4 col-sm-12 shadow-2-strong bg-white mt-3">
    <h4 class="text-danger text-decoration-underline  shadow-2-strong p-2 text-center bg-light rounded-pill" style="margin-top:-3vh ;border-radius: 0;">Most recent pricing :</h4>
<!-- Get all products in promotion -->
<?php
// Get promotions :
$promo = $db -> prepare("SELECT * FROM products WHERE product_promotion_rate > 0 ORDER BY product_publish_date DESC LIMIT 2");
$promo -> execute();
while($in_promo = $promo -> fetch()){
  if($in_promo){
    $product_id = $in_promo['product_id'];
    $product_name = $in_promo['product_name'];
    $product_price = $in_promo['product_price'];
    $product_quantity = $in_promo['product_quantity'];
    $product_description = $in_promo['product_description'];
    $product_disponibity = $in_promo['product_disponibity'];
    $product_promotion_rate = $in_promo['product_promotion_rate'];
    $product_promotion_end = $in_promo['product_promotion_end'];
    ?>
    <div class="container"> 
      <section class="mx-auto my-5" style="max-width: 23rem;">
        <div class="card" style="height: 400px;">
          <div class="card-body d-flex flex-row">
            <i class="fas fa-mug-hot fa-3x text-warning me-3"></i>
            <div>
              <h5 class="card-title font-weight-bold mb-2">Special offer <span class="badge bg-danger text-white">-<?php  echo $product_promotion_rate ?>%</span></h5>
              <p class="card-text"><i class="far fa-clock pe-2"></i><?php echo $product_promotion_end ?></p>
            </div>
          </div>
          <div class="bg-image hover-overlay ripple rounded-0 text-center" data-mdb-ripple-color="light">
            <!-- Get product promo image -->
            <?php
$promo_image = $db -> prepare("SELECT * FROM product_images WHERE product_id = '$product_id' LIMIT 1");
$promo_image -> execute();
$image = $promo_image -> fetch();
if($image){
  $image_id = $image['image_id'];
  $image_name = $image['image_name'];
  $image_src = $image['image_src'];
  ?>
<img class="img-fluid" src="images/product-images/<?php echo $image_name.$image_src; ?>"
alt="Card image cap" style="max-height: 190px;"/>
  <?php
}
            ?>
            <a href="#!">
              <div class="mask" style="background-color: rgba(251, 251, 251, 0.15);"></div>
            </a>
          </div>
          <div class="card-body">
            <p class="card-text collapse" id="<?php  echo "collapse".$product_id; ?>">
            <?php
  if($product_promotion_rate!="0"){
       ?>  
       <span class="text-danger mb-2" style="text-decoration:line-through ;"><?php  echo $product_price;  ?> TND</span> 
      <span class="text-white badge bg-success shadow-1-strong mb-3 w-100">  <?php    echo $product_price-($product_price*($product_promotion_rate/100));  ?> TND</span> 
      <?php 
  }else{
      ?>
      <span class="text-white badge bg-success shadow-1-strong mb-3 w-100">  <?php echo $product_price; ?> TND</span> 
      <?php
  }
  ?>
  <br>            
            <?php echo $product_description; ?>
            </p>
            <div class="d-flex justify-content-between">
              <a class="btn btn-link link-danger p-md-1 my-1" data-mdb-toggle="collapse" href="#<?php  echo "collapse".$product_id; ?>"
                role="button" aria-expanded="false" aria-controls="<?php  echo $product_id; ?>">More detail</a>
              <div>
              <input type="hidden" value="<?php echo  $product_id;?>" >
                <i class="fas fa-eye text-muted p-md-1 my-1 me-2" id="details" data-mdb-toggle="tooltip"
                  data-mdb-placement="bottom" title="View this product" style="cursor: pointer;"></i>
                <i class="fas fa-heart text-muted p-md-1 my-1 me-0" id="wishlist-add" data-mdb-toggle="tooltip" data-mdb-placement="bottom"
                  title="I like it" style="cursor: pointer;"></i>
              </div>
            </div>
          </div>
        </div>
        
      </section>
    </div>
    <?php
  }
}
global $promo ;
if($promo -> rowCount() === 0){
  ?>
<div class="card p-3 mb-3 mt-3">
  <div class="card-body">
    <h5 class="card-title text-danger">Special offers </h5>
    <p class="card-text">This area will be show all products that they are in promotion , you will get notifie=cations where it be ready</p>
  </div>
  <h5 class="card-title placeholder-glow">
      <span class="placeholder col-6"></span>
    </h5>
    <p class="card-text placeholder-glow">
      <span class="placeholder col-7"></span>
      <span class="placeholder col-4"></span>
      <span class="placeholder col-4"></span>
      <span class="placeholder col-6"></span>
      <span class="placeholder col-8"></span>
    </p>
    <a href="#" tabindex="-1" class="btn btn-primary disabled placeholder col-6"></a>
</div>
<div class="card p-3">
  <div class="card-body">
    <h5 class="card-title text-danger">Special offers </h5>
    <p class="card-text">This area will be show all products that they are in promotion , you will get notifie=cations where it be ready</p>
  </div>
  <h5 class="card-title placeholder-glow">
      <span class="placeholder col-6"></span>
    </h5>
    <p class="card-text placeholder-glow">
      <span class="placeholder col-7"></span>
      <span class="placeholder col-4"></span>
      <span class="placeholder col-4"></span>
      <span class="placeholder col-6"></span>
      <span class="placeholder col-8"></span>
    </p>
    <a href="#" tabindex="-1" class="btn btn-primary disabled placeholder col-6"></a>
</div>
  <?php
}
?>
  </div>
  <div class="col-lg-9 col-md-8 col-sm-12 p-2 ">
    <div class="container h-25">
      <!-- Carousel wrapper -->
    <div id="carouselBasicExample" class="carousel slide carousel-fade w-100 d-none d-md-block d-lg-block" style="height: 130%;" data-mdb-ride="carousel">
      <!-- Indicators -->
      <div class="carousel-indicators">
        <button
          type="button"
          data-mdb-target="#carouselBasicExample"
          data-mdb-slide-to="0"
          class="active"
          aria-current="true"
          aria-label="Slide 1"
        ></button>
        <button
          type="button"
          data-mdb-target="#carouselBasicExample"
          data-mdb-slide-to="1"
          aria-label="Slide 2"
        ></button>
        <button
          type="button"
          data-mdb-target="#carouselBasicExample"
          data-mdb-slide-to="2"
          aria-label="Slide 3"
        ></button>
      </div>
    
      <!-- Inner -->
      <div class="carousel-inner">
        <!-- Single item -->
        <div class="carousel-item active">
          <img src="images/carousel_item_1.png" class="d-block img-fluid"  alt="Sunset Over the City" style="width:100%"/>
          <div class="carousel-caption d-none d-md-block">
            <h5 class="text-light">T-shirts</h5>
          </div>
        </div>
    
        <!-- Single item -->
        <div class="carousel-item">
          <img src="images/carousel_item_2.png" class="d-block " alt="Canyon at Nigh" style="width:100%"/>
          <div class="carousel-caption d-none d-md-block">
            <h5 class="text-light">Casquettes</h5>
          </div>
        </div>
    
        <!-- Single item -->
        <div class="carousel-item">
          <img src="images/carousel_item_3.png" class="d-block" alt="Cliff Above a Stormy Sea" style="width:100%"/>
          <div class="carousel-caption d-none d-md-block">
            <h5 class="text-light">Jeans</h5>
          </div>
        </div>
      </div>
      <!-- Inner -->
    
      <!-- Controls -->
      <button class="carousel-control-prev" type="button" data-mdb-target="#carouselBasicExample" data-mdb-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-mdb-target="#carouselBasicExample" data-mdb-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
    <!-- Carousel wrapper -->
    <hr>
    <div class="container mt-0">
      <h3 class="text-secondary text-decoration-underline">Recent products :</h3>
      <div class="row">
   <!-- Recent products -->
   <?php
// Get all products :
try{
  $get_product_infos = $db -> prepare("SELECT * FROM products ORDER BY product_publish_date DESC LIMIT 3");
  $get_product_infos -> execute();
  while($product = $get_product_infos -> fetch()){
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
                <div class="col-lg-4 col-md-6 col-sm-12">
                  <input type="hidden" value="" id="product_id">
                  <section class="mx-auto my-5" style="max-width: 23rem;" >
                    <div class="card"  style="height: 500px;">
                    <div class="col-12 text-end">
                      <span class="badge bg-danger">NEW</span>
                    </div>
                    <?php
  // get product images :
  $get_product_images = $db -> prepare("SELECT * FROM product_images WHERE product_id ='$product_id' LIMIT 1");
  $get_product_images -> execute();
  $images = $get_product_images -> fetch();
  if($images){
  $image_id = $images['image_id'];
  $image_name = $images['image_name'];
  $image_src = $images['image_src'];
    ?>
    <div class="bg-image hover-overlay ripple text-center" data-mdb-ripple-color="light">
                        <img src="images/product-images/<?php echo $image_name.$image_src; ?>" class="img-fluid" style="height: 180px;"/>
                        <a href="#!">
                          <div class="mask" style="background-color: rgba(251, 251, 251, 0.15);"></div>
                        </a>
                      </div>
    <?php
  }
                    ?>
                      <div class="card-body" >
                        <h5 class="card-title font-weight-bold"><a><?php  echo $product_name; ?></a></h5>
                        <ul class="list-unstyled list-inline mb-0">
                          <li class="list-inline-item me-0">
                            <i class="fas fa-star text-warning fa-xs"> </i>
                          </li>
                          <li class="list-inline-item me-0">
                            <i class="fas fa-star text-warning fa-xs"></i>
                          </li>
                          <li class="list-inline-item me-0">
                            <i class="fas fa-star text-warning fa-xs"></i>
                          </li>
                          <li class="list-inline-item me-0">
                            <i class="fas fa-star text-warning fa-xs"></i>
                          </li>
                          <li class="list-inline-item">
                            <i class="fas fa-star-half-alt text-warning fa-xs"></i>
                          </li>
                          <li class="list-inline-item">
                            <p class="text-muted" id="availability">4.5 <?php   
                            if($product_quantity>=2){
                             ?> <span class="badge bg-success rounded-0 text-white fw-bold">IN STOCK</span>  <?php
                            }else{
                              ?> <span class="badge bg-danger rounded-0 text-white fw-bold">OUT STOCK</span>  <?php
                            }
                            ?></p>
                          </li>
                        </ul>
                        <p class="mb-2">
                          <?php
  if($product_promotion_rate!="0"){
      echo $product_price-($product_price*($product_promotion_rate/100));  ?>  TND <sub style="text-decoration:line-through"><?php  echo $product_price; ?> TND</sub> <?php
  }else{
      echo $product_price . " TND"; 
  }
  ?>
                        </p>
                        <p class="card-text">
                        <?php  echo $product_description; ?>
                        </p>
                      
                      </div>
                      <div class="card-footer">
                        <div class="row ">
                         
                <form action="response.php" method="POST">
                <div class="d-flex justify-content-between">
                          <input type="hidden" value="<?php echo  $product_name;?>" id="p_name">
                          <input type="hidden" value="<?php echo  $product_id;?>" name="cart_id">
                          <input type="hidden" value="categories.php" name="page">
                  <button class="btn btn-white shadow-0 text-danger" id="add_cart" name="add_cart" type="submit"><i class="fab fa-opencart"></i> Add to Cart</button>
                  <div>
                          <input type="hidden" value="<?php echo  $product_id;?>" >
                    <i class="fas fa-eye text-muted p-md-1 my-1 me-2" data-mdb-toggle="tooltip"
                      data-mdb-placement="bottom" title="View product" id="details" style="cursor: pointer;"></i>
                    <i class="fas fa-heart text-muted p-md-1 my-1 me-0" data-mdb-toggle="tooltip" data-mdb-placement="bottom"
                      title="I like it" id="wishlist-add"></i>
                  </div>
                </div>
                </form>
                        </div>
                      </div>
                    </div>
                  </section>
                </div>
  
  <?php
  
    }
  }
  if($get_product_infos->rowCount() === 0){
    ?>
  <div class="alert alert-white text-dark p-2 rounded-0 fw-bold text-center">No product found yet</div>
  <?php
  }
  }
  catch (Exception $e){
    die("error : " .$e->getMessage());
  }
  ?>


      </div>
    </div>
    </div>
  </div>
  <hr>
  <!-- brands -->
  <div class="row p-5">
    <h3 class="text-secondary mb-5 text-decoration-underline">Our Brands :</h3> 
<div class="d-flex flex-column flex-lg-row flex-md-row justify-content-around justify-items-center mt-5 ">
  <div class="brand shadow-1-strong  p-3 mb-5"><img src="images/flashmode.png" alt="brand" width="230" height="160" class="img-fluid shadow-1-strong brands"><p class="text-primary mt-3 w-100 mb-sm-5 mb-lg-0">
  Agence de casting mannequins, modèles & hôtesses d'accueil et Magazine Mode & Lifestyle
  </p></div>
  <div class="brand shadow-1-strong  p-3 mb-5"><img src="images/zara.png" alt="brand" width="230" height="160" class="img-fluid shadow-1-strong brands"><p class="text-primary mt-3 w-100 mb-sm-5 mb-lg-0">
  Chaîne espagnole de mode proposant des vêtements, chaussures et accessoires tendance de la marque.
</p></div>
  <div class="brand shadow-1-strong  p-3 mb-5"><img src="images/Lacoste.png" alt="brand" width="230" height="160" class="img-fluid shadow-1-strong brands"><p class="text-primary mt-3 w-100 mb-sm-5 mb-lg-0">
  Lacoste est une entreprise française, spécialisée dans la confection de prêt-à-porter masculin et féminin </p></div>

</div>
  </div>
  <hr>
  <!-- Newslater -->
  <div class="row ">
    <h3 class="text-muted text-decoration-underline text-center">NEWSLETTER</h3>
<!-- Section: Form -->
<section class="bg-light shadow-2-strong p-5">
  <form id="sub-form">
    <!--Grid row-->
    <div class="row d-flex justify-content-center">
      <div id="sub-result"></div>
      <!--Grid column-->
      <div class="col-auto">
        <p class="pt-2">
          <strong>Sign up for our newsletter</strong>
        </p>
      </div>
      <!--Grid column-->

      <!--Grid column-->
      <div class="col-md-5 col-12">
        <!-- Email input -->
        <div class="form-outline form-dark mb-4">
          <input type="email" id="sub-email" class="form-control" required/>
          <label class="form-label" for="sub-email">Email address</label>
        </div>
      </div>
      <!--Grid column-->

      <!--Grid column-->
      <div class="col-auto">
        <!-- Submit button -->
        <button type="submit" class="btn btn-danger  mb-4" id="news-sub">
          Subscribe
        </button>
      </div>
      <!--Grid column-->
    </div>
    <!--Grid row-->
  </form>
</section>
<!-- Section: Form -->
  </div>
</div>
</div>
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
  <!-- content end -->
  <!-- js -->
  <script>
    // add to wishlist btn function start :
var wishlist_add_btn = document.querySelectorAll('#wishlist-add');
var name_place = document.getElementById('p_name');
var image_place = document.getElementById('p_image');
var id_place = document.getElementById('p_id');
var wish_modal = document.getElementById('wish_add');
wishlist_add_btn.forEach(wish_btn => {
  wish_btn.addEventListener('click' , function (){
    var p_id = wish_btn.parentElement.children[0];
    id_place.value = p_id.value;
    wish_modal.click();
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
     // product availability :
     setInterval(function (){
      var availabilities = document.querySelectorAll('#availability');
      
availabilities.forEach(avail => {
if(avail.children[0].innerHTML == "OUT STOCK"){
 var btn = avail.parentElement.parentElement.parentElement.parentElement.children[3].children[0].children[0].children[0].children[3];
btn.classList="btn btn-light shadow-0 disabled pe-none"
}
})
     },100)
     // subscribe newslater code start with ajax :
     var news = document.getElementById('news-sub');
    var sub_email = document.getElementById('sub-email');
    var sub_form = document.getElementById('sub-form');
    var result = document.getElementById('sub-result');
    news.addEventListener('click' , function (e){
if(sub_email.value === ""){
  return false;
}else{
  e.preventDefault();
 var request = new XMLHttpRequest();
 var form = new FormData();
 form.append('sub_email',sub_email.value);
 news.disabled = true;
 request.onreadystatechange = function (){
  if(request.readyState === 4 && request.status === 200){
    news.disabled = false;
    result.innerHTML = request.responseText;
    sub_form.reset();
  }
 }
 request.open('POST','response.php');
 request.send(form);
}
    })
  </script>
<?php
include "includes/footer.php";
?>
