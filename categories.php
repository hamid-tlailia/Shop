<?php
include "includes/header.php";
?>
<!-- content start -->
<div class="container-fluid bg-light">
  <div class="row bg-white p-5 ">
    <div class="row shadow-2-strong text-center pt-3 bg-white ms-1">
      <div class="col-12 col-lg-8 text-start mb-2">
        <div class="d-flex flex-column flex-lg-row flex-md-row">
          <button class="btn text-white me-3 h-25 mb-2" style="background-color: orange;" id="filter"><i class="fas fa-caret-left"></i> Hide Filter</button>
          <select class="form-select me-3 w-auto h-25 mb-2 disabled pe-none" aria-label="Default select example">
            <option selected>Sorted By</option>
            <option value="1">One</option>
            <option value="2">Two</option>
            <option value="3">Three</option>
          </select>
          <div class="d-flex flex-column flex-lg-row flex-md-row me-3 mb-2  justify-content-center justify-items-center text-center p-0">
            <p class="lead me-3 mt-1">Products : <?php $req = $db->prepare("SELECT * FROM products");
                                                  $req->execute();
                                                  $count = $req->rowCount();
                                                  echo $count;
                                                  ?> </p>
            <select class=" border rounded-0 h-75 mb-2 pe-none" aria-label="Default select example" style="outline: none;">
              <option selected><?php $req = $db->prepare("SELECT * FROM products");
                                $req->execute();
                                $count = $req->rowCount();
                                echo $count;
                                ?></option>
              <option value="1">20</option>
              <option value="2">30</option>
              <option value="3">40</option>
            </select>
          </div>
        </div>
      </div>
      <div class="col-12 col-lg-4 text-end mb-2">
        <ul class="pagination m-auto">
          <li class="page-item">
            <a class="page-link me-2" href="#" aria-label="Previous">
              <span aria-hidden="true">&laquo;</span>
            </a>
          </li>
          <li class="page-item"><a class="page-link bg-warning text-white me-2 roundedwarning" href="#">1</a></li>
          <li class="page-item"><a class="page-link bg-warning text-white me-2 roundedwarning" href="#">...</a></li>
          <li class="page-item">
            <a class="page-link" href="#" aria-label="Next">
              <span aria-hidden="true">&raquo;</span>
            </a>
          </li>
        </ul>
      </div>
    </div>
    <div class="col-12 col-lg-3 p-3 border mt-3 bg-white rounded filter-area">
      <div class="d-flex flex-column flex-lg-row flex-md-row w-100 justify-content-center mb-2 p-3">
        <button class="btn shadow-0 text-white mb-2 mb-lg-0 mb-md-0 rounded-0 w-50" style="background-color: rgba(128, 128, 128, 0.205);" id="reset">Reset</button>
        <button class="btn btn-success shadow-0 rounded-0 w-50">Apply</button>
      </div>
      <div class="container">
        <!-- new // old -->
        <!-- Default checkbox -->
        <div class="form-check">
          <input class="form-check-input" type="checkbox" value="new" id="recently" />
          <label class="form-check-label" for="g">New</label>
        </div>

        <!-- Checked checkbox -->
        <div class="form-check">
          <input class="form-check-input" type="checkbox" value="old" id="recently" />
          <label class="form-check-label" for="g">Old</label>
        </div>
        <!-- /new // old -->
      </div>
      <hr>
      <div class="container">
        <div class="accordion" id="accordion1" style="border: none;outline:none">
          <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
              <button class="accordion-button" type="button" data-mdb-toggle="collapse" data-mdb-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                Categories
              </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-mdb-parent="#accordion2">
              <div class="accordion-body ">
                <!-- Default checkbox -->
                <div class="form-check">
                  <input class="form-check-input pe-none" type="checkbox" value="" id="catall" checked />
                  <label class="form-check-label" for="c">All</label>
                </div>
                <!-- Default checkbox -->
                <div class="form-check">
                  <input class="form-check-input pe-none" type="checkbox" value="" id="cat1" />
                  <label class="form-check-label" for="c">Boys</label>
                </div>

                <!-- Checked checkbox -->
                <div class="form-check">
                  <input class="form-check-input pe-none" type="checkbox" value="" id="cat2" />
                  <label class="form-check-label" for="c">Girls</label>
                </div>
                <!-- Default checkbox -->
                <div class="form-check">
                  <input class="form-check-input pe-none" type="checkbox" value="" id="cat3" />
                  <label class="form-check-label" for="c">Kids</label>
                </div>

                <!-- Checked checkbox -->
                <div class="form-check">
                  <input class="form-check-input pe-none" type="checkbox" value="" id="cat4" />
                  <label class="form-check-label" for="c">Other</label>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <hr>
      <div class="container">
        <div class="accordion" id="accordion2">
          <div class="accordion-item">
            <h2 class="accordion-header" id="headingTwo">
              <button class="accordion-button" type="button" data-mdb-toggle="collapse" data-mdb-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                Price
              </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse show" aria-labelledby="headingTwo" data-mdb-parent="#accordion2">
              <div class="accordion-body">
                <div class="d-flex flex-row justify-content-center justify-items-center text-center align-items-center w-100">
                  <span class=" p-2 text-center me-2"><?php
                                                      // get min price :
                                                      $min_price = $db->prepare("SELECT *
                  FROM products
                  WHERE product_price =  ( SELECT MIN(product_price) FROM products )");
                                                      $min_price->execute();
                                                      $min = $min_price->fetch();
                                                      echo $min['product_price'];

                                                      ?> TND</span>
                  <div class="range">
                    <!-- input -->
                    <input type="range" class="form-range mt-2 w-100" id="price_filter" min="<?php
                                                                                              // get min price :
                                                                                              $min_price = $db->prepare("SELECT *
                  FROM products
                  WHERE product_price =  ( SELECT MIN(product_price) FROM products )");
                                                                                              $min_price->execute();
                                                                                              $min = $min_price->fetch();
                                                                                              echo $min['product_price'];

                                                                                              ?>" max="<?php
                                                                // get min price :
                                                                $min_price = $db->prepare("SELECT *
                  FROM products
                  WHERE product_price =  ( SELECT MAX(product_price) FROM products )");
                                                                $min_price->execute();
                                                                $min = $min_price->fetch();
                                                                echo $min['product_price'];

                                                                ?>" />
                    <!-- /input -->
                  </div>
                  <span class=" p-2 text-center ms-2"><?php
                                                      // get max price :
                                                      $min_price = $db->prepare("SELECT *
                  FROM products
                  WHERE product_price =  ( SELECT MAX(product_price) FROM products )");
                                                      $min_price->execute();
                                                      $min = $min_price->fetch();
                                                      echo $min['product_price'];

                                                      ?> TND</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <hr>
      <div class="container">
        <div class="accordion" id="accordion3">
          <div class="accordion-item">
            <h2 class="accordion-header" id="headingThree">
              <button class="accordion-button collapsed" type="button" data-mdb-toggle="collapse" data-mdb-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                Size
              </button>
            </h2>
            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-mdb-parent="#accordion3">
              <div class="accordion-body">
                <div class="form-check">
                  <input class="form-check-input pe-none" type="checkbox" value="" id="sall" checked />
                  <label class="form-check-label pe-none" for="s">ALL</label>
                </div>
                <!-- Checked checkbox -->
                <div class="form-check">
                  <input class="form-check-input pe-none" type="checkbox" value="" id="s1" />
                  <label class="form-check-label" for="s">XM</label>
                </div>
                <!-- Default checkbox -->
                <div class="form-check">
                  <input class="form-check-input pe-none" type="checkbox" value="" id="s2" />
                  <label class="form-check-label" for="s">XL</label>
                </div>

                <!-- Checked checkbox -->
                <div class="form-check">
                  <input class="form-check-input pe-none" type="checkbox" value="" id="s3" />
                  <label class="form-check-label" for="s">XXL</label>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12 col-lg-9 p-3 " id="product-area">
      <div class="row  shadow-1-strong mt-3 ms-lg-3">
        <div id="add_result">
          <?php
          if (isset($_SESSION['added'])) {
            echo $_SESSION['added'];
            if ($_SESSION['timer'] - time() == 0) {
              unset($_SESSION['added']);
            }
          }
          if (isset($_SESSION['removed'])) {
            echo $_SESSION['removed'];
            if ($_SESSION['timer'] - time() == 0) {
              unset($_SESSION['removed']);
            }
          }
          ?>
        </div>
        <?php
        // Get all products :
        try {
          $get_product_infos = $db->prepare("SELECT * FROM products ORDER BY product_publish_date DESC ");
          $get_product_infos->execute();
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
              <div class="col-lg-4 col-md-6 col-sm-12">
                <input type="hidden" value="" id="product_id">
                <section class="mx-auto my-5" style="max-width: 23rem;">
                  <div class="card" style="height: 500px;">
                    <div class="col-12 text-end"><?php
                                                  if ($product_promotion_rate != "0") {
                                                  ?> <span class="badge bg-danger text-white rounded">-<?php echo $product_promotion_rate ?>%</span> <?php
                                                                                                                                                    } else {
                                                                                                                                                      ?> <span class="badge bg-danger text-white rounded" style="opacity: 0;">0%</span> <?php
                                                                                                                                                                                                                                      }
                                                                                                                                                                                                                                        ?>
                    </div>
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
                      <div class="bg-image hover-overlay ripple text-center" data-mdb-ripple-color="light">
                        <img src="images/product-images/<?php echo $image_name . $image_src; ?>" class="img-fluid" style="height: 180px;" />
                        <a href="#!">
                          <div class="mask" style="background-color: rgba(251, 251, 251, 0.15);"></div>
                        </a>
                      </div>
                    <?php
                    }
                    ?>
                    <div class="card-body">
                      <h5 class="card-title font-weight-bold"><a><?php echo $product_name; ?></a></h5>
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
                                                                      if ($product_quantity >= 2) {
                                                                      ?> <span class="badge bg-success rounded-0 text-white fw-bold">IN STOCK</span> <?php
                                                                                                                                                    } else {
                                                                                                                                                      ?> <span class="badge bg-danger rounded-0 text-white fw-bold">OUT STOCK</span> <?php
                                                                                                                                                                                                                                    }
                                                                                                                                                                                                                                      ?></p>
                        </li>
                      </ul>
                      <p class="mb-2">
                        <?php
                        if ($product_promotion_rate != "0") {
                          echo $product_price - ($product_price * ($product_promotion_rate / 100));  ?> TND <sub style="text-decoration:line-through"><?php echo $product_price; ?> TND</sub> <?php
                                                                                                                                                                                            } else {
                                                                                                                                                                                              echo $product_price . " TND";
                                                                                                                                                                                            }
                                                                                                                                                                                              ?>
                      </p>
                      <p class="card-text">
                        <?php echo $product_description; ?>
                      </p>

                    </div>
                    <div class="card-footer">
                      <div class="row ">

                        <form action="response.php" method="POST">
                          <div class="d-flex justify-content-between">
                            <input type="hidden" value="<?php echo  $product_name; ?>" id="p_name">
                            <input type="hidden" value="<?php echo  $product_id; ?>" name="cart_id">
                            <input type="hidden" value="categories.php" name="page">
                            <button class="btn btn-white shadow-0 text-danger" id="add_cart" name="add_cart" type="submit"><i class="fab fa-opencart"></i> Add to Cart</button>
                            <div>
                              <input type="hidden" value="<?php echo  $product_id; ?>">
                              <i class="fas fa-eye text-muted p-md-1 my-1 me-2" data-mdb-toggle="tooltip" data-mdb-placement="bottom" title="View product" id="details" style="cursor: pointer;"></i>
                              <i class="fas fa-heart text-muted p-md-1 my-1 me-0" data-mdb-toggle="tooltip" data-mdb-placement="bottom" title="I like it" id="wishlist-add"></i>
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
          if ($get_product_infos->rowCount() === 0) {
            ?>
            <div class="alert alert-white text-dark p-2 rounded-0 fw-bold text-center">No product found yet</div>
        <?php
          }
        } catch (Exception $e) {
          die("error : " . $e->getMessage());
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
  .filter-area {
    height: 50%;
    transition: .5s;
  }

  .filter-area.active {
    height: 0;
    padding: 0;
    overflow: hidden;
    opacity: 0;
    display: none;
    transition: .5s;
  }
</style>
<!-- js -->
<script>
  var filter = document.getElementById('filter')
  var filter_area = document.querySelector('.filter-area')
  var product_area = document.getElementById('product-area')

  filter.onclick = function() {
    filter_area.classList.toggle('active')
  }
  setInterval(function() {

    if (filter_area.classList.contains('active')) {
      product_area.classList = "col-12"
    } else {
      product_area.classList = "col-12 col-md-12 col-lg-9"
    }
  }, 100)

  // product availability :
  setInterval(function() {
    var availabilities = document.querySelectorAll('#availability');

    availabilities.forEach(avail => {
      if (avail.children[0].innerHTML == "OUT STOCK") {
        var btn = avail.parentElement.parentElement.parentElement.parentElement.children[3].children[0].children[0].children[0].children[3];
        btn.classList = "btn btn-light shadow-0 disabled pe-none"
      }
    })
  }, 100)

  // add to cart btn function :
  //  var add_btns = document.querySelectorAll('#add_cart');
  //  var add_result = document.getElementById('add_result');
  //  add_btns.forEach(add_btn => {
  //   add_btn.addEventListener('click' , function (){
  //     var product_id = this.parentElement.children[1];
  //     var add_product_to_cart_request = new XMLHttpRequest();
  //     var product_cart_id = new FormData();
  //     this.disabled = true ;
  //     product_cart_id.append('cart_id',product_id.value);
  //     add_product_to_cart_request.onreadystatechange = function (){
  //       if(add_product_to_cart_request.readyState === 4 && add_product_to_cart_request.status === 200){
  //         add_btn.disabled = false;
  //         add_result.innerHTML = add_product_to_cart_request.responseText;

  //         // reload cart :
  // 
  //       }
  //     }
  //     add_product_to_cart_request.open('POST','response.php');
  //     add_product_to_cart_request.send(product_cart_id);
  //   })
  //  })
  // remove == item == from == shopping_cart == code == start :
  // var unsets = document.querySelectorAll('#unset');
  // 	unsets.forEach(unset_item => {
  // unset_item.addEventListener('click' , function (){
  // 	unset_id = unset_item.parentElement.children[0]
  //   alert(unset_id.value)
  // // send == unset == id
  // var unset_request  = new XMLHttpRequest()
  // var unset_form = new FormData()
  // unset_form.append('unset_id', unset_id.value)
  // unset_item.disabled = true
  // unset_request.onreadystatechange = function (){
  // 	if(unset_request.readyState === 4 && unset_request.status === 200 ){
  //     // request
  //              // reload cart :
  //     
  // 	}
  // }
  // unset_request.open('POST','response.php')
  // unset_request.send(unset_form)
  // })
  // 	})

  // cart empty check :
  setInterval(function() {
    var carts = document.querySelectorAll('#cart');
    carts.forEach(cart => {
      if (cart.children.length === 0) {
        cart.innerHTML = `<div class="alert alert-white text-center p-3 fw-bold">Your cart is empty</div>`;
      }
    })
  }, 100)
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
  // filter products code start :
  var recentlies = document.querySelectorAll('#recently');
  recentlies.forEach(recent => {
    recent.addEventListener('click', function() {
      if (recent.checked === true) {
        var filter_request = new XMLHttpRequest();
        var filter_form = new FormData();
        filter_form.append('filter_products', recent.value);
        recent.disabled = true;
        filter_request.onreadystatechange = function() {
          if (filter_request.readyState === 4 && filter_request.status === 200) {
            product_area.innerHTML = filter_request.responseText;
            recent.disabled = false;
          }
        }
        filter_request.open('POST', 'response.php');
        filter_request.send(filter_form);
      }
    })
  })
  // reset filter :
  var reset = document.getElementById('reset');
  reset.onclick = function() {
    window.location.reload();
  }
  // filter by price code start :
  var price_filter = document.getElementById('price_filter');
  price_filter.onchange = function() {
    var min = price_filter.getAttribute('min');
    var max = price_filter.value;
    // send request :
const price_infos = [min,max];
var price_request = new XMLHttpRequest();
var price_form = new FormData();
price_form.append('filter_price',price_infos);
price_filter.disabled = true;
price_request.onreadystatechange = function (){
  if(price_request.readyState === 4 && price_request.status === 200){
    product_area.innerHTML = price_request.responseText;
    price_filter.disabled = false;
  }
}
price_request.open('POST','response.php');
price_request.send(price_form);
  }
</script>
<?php
include "includes/footer.php";
?>