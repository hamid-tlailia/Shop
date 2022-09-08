<?php
include "includes/config.php"
?>
<!DOCTYPE php>
<php lang="en">

  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/mdb.min.css">
    <link rel="stylesheet" href="css/mdb.min.css.map">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <link rel="shortcut icon" href="images/icon.png">
    <link rel="stylesheet" href="css/style.css">
    <title>Store</title>
  </head>

  <body>
    <!-- header start -->
    <nav class="nav nav-head  text-center  m-0">
      <div class="d-flex flex-column  flex-lg-row flex-sm-column border-bottom border-dark flex-md-row justify-content-between justify-items-center p-2 w-100  text-light" style="background-color:#deded5;">
        <a href="home.php" class="page-name mt-2" style="font-family: 'Splash', cursive;"><span class="logo text-secondary">Fashion <span class="text-success">Store</span></span></a>
        <span class=" note note-warning fw-bold me-3 shadow-2-strong text-warning rounded-0 pt-0 pt-lg-3 pt-md-2" style="background-color:#deded5;max-height:60px;">Phone <i class="fas fa-phone-alt text-success fa-1x"></i> : +216 94 143 166 __ Email <i class="fas fa-envelope text-danger"></i> : tlailia757@gmail.com</span>
        <span class="mt-3 text-center" id="login_area">
          <div class="input-group "><a href="sign-up.php"><button class="btn btn-white me-2 mb-2">Sign-up</button></a><a href="login.php"><button class="btn btn-info mb-2 me-3">Login</button></a></div>
        </span>
        <!-- avatar to use where user account exists -->
        <?php
        if (isset($_SESSION['admin'])) {
        ?>
          <span class="mt-2 mb-0">
            <ul class="list-unstyled">
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle d-flex align-items-center" href="admin-space.php" id="navbarDropdownMenuLink" role="button" data-mdb-toggle="dropdown" aria-expanded="false">
                  <img src="images/avatar.png" class="rounded-circle mb-0" height="30" alt="Avatar" loading="lazy" />
                </a>
                <ul class="dropdown-menu dropstart alert-white rounded-0 shadow-3-strong" style="filter: drop-shadow(0 0 0.75rem pink);" aria-labelledby="navbarDropdownMenuLink">
                  <li class=" rounded-0 border-bottom">
                    <a class="dropdown-item" href="admin-space.php">My profile</a>
                  </li>
                  <li class="rounded-0">
                    <a class="dropdown-item" href="#" id="log_out">Logout</a>
                  </li>
                </ul>
              </li>
            </ul>
          </span>
          <script>
            var login_area = document.getElementById('login_area').style.display = "none";
          </script>
        <?php
        } else if (isset($_SESSION['client'])) {
        ?>
          <span class="mt-2 mb-0">
            <ul class="list-unstyled">
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle d-flex align-items-center" href="customer-space.php" id="navbarDropdownMenuLink" role="button" data-mdb-toggle="dropdown" aria-expanded="false">
                  <img src="images/avatar.png" class="rounded-circle mb-0" height="30" alt="Avatar" loading="lazy" />
                </a>
                <ul class="dropdown-menu dropstart alert-white rounded-0 shadow-3-strong" style="filter: drop-shadow(0 0 0.75rem pink);" aria-labelledby="navbarDropdownMenuLink">
                  <li class=" rounded-0 border-bottom">
                    <a class="dropdown-item" href="customer-space.php">My profile</a>
                  </li>
                  <li class=" rounded-0">
                    <a class="dropdown-item" href="#" id="log_out">Logout</a>
                  </li>
                </ul>
              </li>
            </ul>
          </span>
          <script>
            var login_area = document.getElementById('login_area').style.display = "none";
          </script>
        <?php
        }
        ?>
      </div>
    </nav>
    <nav class="navbar shadow-0 navbar-expand-lg  navbar-scroll" id="fixed" style="background-color: #deded5;z-index: 5;">
      <div class="container">
        <a href="home.php"><i class="fa-brands fa-shopify fa-5x rounded-circle text-secondary" style="filter: drop-shadow(0 0 0.75rem white);"></i></a>
        <button class="navbar-toggler ps-0" type="button" data-mdb-toggle="collapse" data-mdb-target="#hiddenNav" aria-controls="hiddenNav" aria-expanded="true" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon d-flex justify-content-start align-items-center">
            <i class="fas fa-bars"></i>
          </span>
        </button>
        <ul class="navbar-nav flex-row d-md-flex d-sm-flex d-lg-none">
          <li class="nav-item">
            <a class="nav-link px-2" href="wishlist.php">
              <i class="fas fa-heart fs-5 mt-2"></i>
            </a>
          </li>
          <li class="nav-item">
            <div class="btn-group dropbottom shadow-0">
              <button class="btn btn-transparent  shadow-0 " type="button" id="dropdownMenu2" data-mdb-toggle="dropdown" aria-expanded="sticky">
                <i class="fas fa-shopping-cart fs-5 mt-2"></i>
                <span id="countt"><span class="badge bg-danger" id="count1"><?php if (isset($_SESSION['cart'])) {
                                                                              echo count($_SESSION['cart']);
                                                                            } else {
                                                                              echo "0";
                                                                            } ?></span></span>
              </button>
              <ul class="dropdown-menu rounded-0 mt-2 cart" style="left: 12vh;max-width:50vh;" aria-labelledby="dropdownMenu2">
                <li class="row p-3 bg-white" id="items2">
                  <h5 class="text-secondary text-center mb-3 border-bottom border-dark p-2">Cart items :</h5>
                  <div class="row items" id="cart">
                    <?php
                    $total = 0;
                    $g_total = 0;
                    if (isset($_SESSION['cart'])) {
                      foreach ($_SESSION['cart'] as $key => $value) {
                        $total = $value['price'] * $value['qty'];
                        $g_total += $total = $value['price'] * $value['qty'];
                        $cart_id = $value['id'];
                        // search product id from session :
                        $product_name = $value['name'];
                        $product_price = $value['price'];
                        $product_quantity = $value['qty'];
                        $product_description = $value['description'];
                        $product_promotion_rate = $value['promotion'];
                        $product_promotion_end = $value['date'];
                        $image_name = $value['image_name'];
                        $image_src = $value['image_src'];

                    ?>
                        <div class="row ms-2 mb-2 text-center align-items-center text-dark bg-light">
                          <div class="col-sm">
                            <div class="bg-image hover-overlay ripple" data-mdb-ripple-color="light">
                              <img src="images/product-images/<?php echo $image_name . $image_src; ?>" class="img-fluid" width="90" height="90" />
                              <a href="#!">
                                <div class="mask" style="background-color: rgba(251, 251, 251, 0.15)"></div>
                              </a>
                            </div>


                          </div>
                          <div class="col-sm">
                            <h5 class="card-title"><?php echo $product_name; ?></h5>
                            <p class="card-text">
                              <?php
                              echo $product_price   . "TND"; ?>

                            </p>
                          </div>
                          <div class="col-sm">X <?php echo $product_quantity; ?></div>
                          <form action="response.php" method="POST">
                            <div class="col-sm">
                              <input type="hidden" value="<?php echo $cart_id;  ?> " name="unset_id">
                              <input type="hidden" value="categories.php" name="redirect">
                              <button type="submit" class="btn btn-light shadow-1-strong text-danger" id="unset" name="dell"><i class="fas fa-trash-alt"></i></button>
                            </div>
                          </form>
                        </div>
                    <?php

                      }
                    }
                    ?>
                  </div>
                  <hr>
                  <div class="row p-3">
                    <span><span class="text-danger"><?php if (isset($_SESSION['cart'])) {
                                                      echo count($_SESSION['cart']);
                                                    } else {
                                                      echo "0";
                                                    } ?></span> item(s) selected</span> <br>
                    <span>Total : <span class="text-danger"><?php global $g_total;
                                                            if ($g_total === "") {
                                                              echo "0";
                                                            } else {
                                                              echo $g_total;
                                                            } ?> DNT</span> </span>
                  </div>
                  <div class="row border ms-1 text-center border-dark">
                    <div class="col-sm border-end border-dark p-2"> <a href="cart.php"><button class="btn btn-white text-danger shadow-0 w-100">Your cart</button></a></div>
                    <div class="col-sm p-2"><a href="checkout.php"><button class="btn btn-white text-dark shadow-0 w-100">Checkout</button></a></div>
                  </div>
                </li>
              </ul>
            </div>
          </li>
        </ul>
        <div class="collapse navbar-collapse" id="hiddenNav">
          <div class="d-flex flex-row shadow-1-strong outline  align-items-center text-center mt-sm-3  ms-lg-auto mt-2 mt-lg-0 " style="border-radius: 20px !important;">
            <div class="dropdown border-end border-dark d-lg-block d-none">
              <button class="btn btn-white shadow-0 dropdown-toggle" type="button" id="dropdownMenu2" data-mdb-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-bars"></i> Catégorie
              </button>
              <ul class="dropdown-menu dropdown-menu-dark fa-ul ms-0">
                <li>
                  <a class="dropdown-item" href="categories.php"><span class="fa-li pe-2"><i class="fas fa-search fs-5"></i></span>All</a>
                </li>
                <li>
                  <a class="dropdown-item" href="#"><span class="fa-li pe-2"><i class="fas fa-male fs-5"></i></span>Clothes for Man</a>
                </li>
                <li>
                  <a class="dropdown-item" href="#"><span class="fa-li pe-2"><i class="fas fa-female fs-5"></i></span>Clothes for
                    Girls</a>
                </li>
                <li>
                  <a class="dropdown-item" href="#"><span class="fa-li pe-2"><i class="fas fa-building fs-5"></i></span>Companies</a>
                </li>
                <li>
                  <a class="dropdown-item" href="#"><span class="fa-li pe-2"><i class="fas fa-key fs-5"></i></span>Keywords</a>
                </li>
                <li>
                  <hr class="dropdown-divider" />
                </li>
                <li>
                  <a class="dropdown-item" href="searsh.php"><span class="fa-li pe-2"><i class="fas fa-search-plus"></i></span>Advanced
                    search<i class="fas fa-chevron-right ps-2 fs-5"></i></a>
                </li>
              </ul>
            </div>
            <input type="search" placeholder="Type Search..." id="search-value">
            <i class="fas fa-search ms-1 me-2" id="search"></i>
          </div>
          <!-- Buttons trigger collapse -->
          <button class="btn btn-white mt-3 shadow-0 d-lg-none d-md-block d-sm-block" type="button" data-mdb-toggle="collapse" data-mdb-target="#categorie" aria-expanded="false" aria-controls="categorie">
            <i class="fas fa-bars"></i> Catégorie
          </button>

          <!-- Collapsed content -->
          <div class="collapse mt-3 d-lg-none" id="categorie">
            <ul class="alert-dark  fa-ul ms-0">
              <li>
                <a class="dropdown-item" href="categories.php"><span class="fa-li pe-2"><i class="fas fa-search fs-5"></i></span>All</a>
              </li>
              <li>
                <a class="dropdown-item" href="#"><span class="fa-li pe-2"><i class="fas fa-male fs-5"></i></span>Clothes for Man</a>
              </li>
              <li>
                <a class="dropdown-item" href="#"><span class="fa-li pe-2"><i class="fas fa-female fs-5"></i></span>Clothes for
                  Girls</a>
              </li>
              <li>
                <a class="dropdown-item" href="#"><span class="fa-li pe-2"><i class="fas fa-building fs-5"></i></span>Companiee</a>
              </li>
              <li>
                <a class="dropdown-item" href="#"><span class="fa-li pe-2"><i class="fas fa-key fs-5"></i></span>Keywords</a>
              </li>
              <li>
                <hr class="dropdown-divider" />
              </li>
              <li>
                <a class="dropdown-item" href="searsh.php"><span class="fa-li pe-2"><i class="fas fa-search-plus"></i></span>Advanced
                  search<i class="fas fa-chevron-right ps-2 fs-5"></i></a>
              </li>
            </ul>
          </div>
          <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
            <li class="nav-item active">
              <a class="nav-link" aria-current="page" href="news.php">News</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="blogs.php">Blogs</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="about.php">About us</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-primary fw-bold text-decoration-underline" aria-current="page" href="contact.php">Contact</a>
            </li>

          </ul>
          <ul class="navbar-nav flex-row d-lg-flex d-none">
            <li class="nav-item">
              <a class="nav-link px-2 btn btn-transparent  shadow-0 " href="wishlist.php">
                <i class="fas fa-heart fs-5 mt-2"></i>
                <span><span class="badge bg-danger"><?php if (isset($_SESSION['wish'])) {
                                                      echo count($_SESSION['wish']);
                                                    } else {
                                                      echo "0";
                                                    } ?></span></span>
              </a>
            </li>
            <li class="nav-item">
              <div class="btn-group dropbottom shadow-0">
                <button class="btn btn-transparent  shadow-0 " type="button" id="dropdownMenu2" data-mdb-toggle="dropdown" aria-expanded="false">
                  <i class="fas fa-shopping-cart fs-5 mt-2"></i>
                  <span id="count"> <span class="badge bg-danger" id="count2"><?php if (isset($_SESSION['cart'])) {
                                                                                echo count($_SESSION['cart']);
                                                                              } else {
                                                                                echo "0";
                                                                              } ?></span></span>
                </button>
                <ul class="dropdown-menu rounded-0 mt-2 cart w-auto" aria-labelledby="dropdownMenu2">
                  <li class="row p-3 bg-white" id="items">
                    <h5 class="text-secondary text-center mb-3 border-bottom border-dark p-2">Cart items :</h5>
                    <div class="row items" id="cart">
                      <?php

                      if (isset($_SESSION['cart'])) {
                        foreach ($_SESSION['cart'] as $key => $value) {
                          $cart_id = $value['id'];
                          // search product id from session :
                          $product_name = $value['name'];
                          $product_price = $value['price'];
                          $product_quantity = $value['qty'];
                          $product_description = $value['description'];
                          $product_promotion_rate = $value['promotion'];
                          $product_promotion_end = $value['date'];
                          $image_name = $value['image_name'];
                          $image_src = $value['image_src'];

                      ?>
                          <div class="row ms-2 mb-2 text-center align-items-center text-dark bg-light">
                            <div class="col-sm">
                              <div class="bg-image hover-overlay ripple" data-mdb-ripple-color="light">
                                <img src="images/product-images/<?php echo $image_name . $image_src; ?>" class="img-fluid" width="90" height="90" />
                                <a href="#!">
                                  <div class="mask" style="background-color: rgba(251, 251, 251, 0.15)"></div>
                                </a>
                              </div>


                            </div>
                            <div class="col-sm">
                              <h5 class="card-title"><?php echo $product_name; ?></h5>
                              <p class="card-text">
                                <?php
                                echo $product_price . " TND";
                                ?>
                              </p>
                            </div>
                            <div class="col-sm">X <?php echo $product_quantity; ?></div>

                            <div class="col-sm">
                              <form action="response.php" method="POST">
                                <input type="hidden" value="<?php echo $cart_id;  ?> " name="unset_id">
                                <input type="hidden" value="categories.php" name="redirect">
                                <button type="submit" class="btn btn-light shadow-1-strong text-danger" name="dell"><i class="fas fa-trash-alt"></i></button>
                              </form>
                            </div>

                          </div>
                      <?php

                        }
                      }
                      ?>
                    </div>
                    <hr>
                    <div class="row p-3">
                      <span><span class="text-danger"><?php if (isset($_SESSION['cart'])) {
                                                        echo count($_SESSION['cart']);
                                                      } else {
                                                        echo "0";
                                                      } ?></span> item(s) selected</span> <br>
                      <span>Total : <span class="text-danger"><?php global $g_total;
                                                              if ($g_total === "") {
                                                                echo "0";
                                                              } else {
                                                                echo $g_total;
                                                              } ?> DNT</span> </span>
                    </div>
                    <div class="row border ms-1 text-center border-dark">
                      <div class="col-sm border-end border-dark p-2"> <a href="cart.php"><button class="btn btn-white text-danger shadow-0 w-100">Your cart</button></a></div>
                      <div class="col-sm p-2"><a href="checkout.php" id="check_btn"><button class="btn btn-white text-dark shadow-0 w-100">Checkout</button></a></div>
                    </div>
                  </li>
                </ul>
              </div>
            </li>
          </ul>
        </div>

      </div>
    </nav>

    <!-- header end -->
    <!-- content start -->
    <div class="container-fluid p-5 bg-white">
      <div class="row">
        <h3 class="text-muted text-center text-decoration-underline">Contact form</h3>
      </div>
      <div class="row p-3 " style="border-radius: 0 0 500px 500px;background-color: azure;">
        <h4 class="fw-bold mb-4" style="color: #92aad0;">Contact Us</h4>
        <p class="mb-4" style="color: #45526e;">To send a valid contact , please fill in these text fiels with your exact informations.</p>
        <div class="col-lg-8 col-md-6 col-sm-12 mt-2 ">
          <div id="contact_result"></div>
          <form id="contact-form">
            <!-- Name input -->
            <div class="form-outline mb-4">
              <input type="text" id="contact-name" class="form-control" required />
              <label class="form-label" for="contact-name">Full name</label>
            </div>

            <!-- Email input -->
            <div class="form-outline mb-4">
              <input type="email" id="contact-email" class="form-control" required />
              <label class="form-label" for="contact-email">Email address</label>
            </div>

            <!-- Message input -->
            <div class="form-outline mb-4">
              <textarea class="form-control" id="contact-message" rows="4" required></textarea>
              <label class="form-label" for="contact-message">Message</label>
            </div>

            <!-- Checkbox -->
            <div class="form-check d-flex justify-content-center mb-4">
              <input class="form-check-input me-2" type="checkbox" value="" id="form4Example4" checked />
              <label class="form-check-label" for="form4Example4">
                Send me a copy of this message
              </label>
            </div>

            <!-- Submit button -->
            <button type="submit" class="btn btn-info  mb-4" id="contact">Contact</button>
          </form>
          <hr>
          <div class="row">
            <img class="img-fluid " src="images/contact.png" alt="contact" width="50px" height="350px">
          </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12">
          <!-- phone -->
          <div class="container">
            <section class="mx-auto " style="max-width: 23rem;">

              <div class="card">
                <div class="card-body">
                  <blockquote class="blockquote blockquote-custom bg-white px-3 pt-4">
                    <div class="blockquote-custom-icon bg-info shadow-1-strong">
                      <i class="fas fa-phone text-white"></i>
                    </div>
                    <p class="mb-0 mt-2 font-italic">
                      +216 94 143 166
                    </p>
                    <footer class="blockquote-footer pt-4 mt-4 border-top">
                      Some extra infos in
                      <cite title="Source Title">Phone</cite>
                    </footer>
                  </blockquote>
                </div>
              </div>

            </section>
          </div>
          <!-- email -->
          <div class="container">
            <section class="mx-auto my-5" style="max-width: 23rem;">

              <div class="card">
                <div class="card-body">
                  <blockquote class="blockquote blockquote-custom bg-white px-3 pt-4">
                    <div class="blockquote-custom-icon bg-info shadow-1-strong">
                      <i class="fas fa-envelope text-white"></i>
                    </div>
                    <p class="mb-0 mt-2 font-italic">
                      tlailia757@gmail.com
                    </p>
                    <footer class="blockquote-footer pt-4 mt-4 border-top">
                      Some extra infos in
                      <cite title="Source Title">E-mail</cite>
                    </footer>
                  </blockquote>
                </div>
              </div>

            </section>
          </div>
          <!-- adresse -->
          <div class="container">
            <section class="mx-auto my-5" style="max-width: 23rem;">

              <div class="card">
                <div class="card-body">
                  <blockquote class="blockquote blockquote-custom bg-white px-3 pt-4">
                    <div class="blockquote-custom-icon bg-info shadow-1-strong">
                      <i class="fas fa-home text-white"></i>
                    </div>
                    <p class="mb-0 mt-2 font-italic">
                      RUE AMMAR SDIRI GHARDIMAOU
                    </p>
                    <footer class="blockquote-footer pt-4 mt-4 border-top">
                      ZIP CODE :
                      <cite title="Source Title">8160</cite>
                    </footer>
                  </blockquote>
                </div>
              </div>

            </section>
          </div>
        </div>
      </div>
    </div>
    <!-- content end -->
    <!-- js -->
    <script>
      var log_out_btn = document.getElementById('log_out');
      log_out_btn.onclick = function() {
        log_out_btn.disabled = true
        var req = new XMLHttpRequest();
        var form = new FormData()
        form.append('log', 'out')
        req.onreadystatechange = function() {
          if (req.readyState === 4 && req.status === 200) {
            window.location.href = "login.php"
          }
        }
        req.open('POST', 'response.php')
        req.send(form)
      }
      // send contact form code :
      var contact = document.getElementById('contact');
      var contact_name = document.getElementById('contact-name');
      var contact_email = document.getElementById('contact-email');
      var contact_message = document.getElementById('contact-message');
      var contact_form = document.getElementById('contact-form');
      var response_area = document.getElementById('contact_result');
      contact.addEventListener('click', function(e) {
        if (contact_name.value === "") {
          return false;
        } else if (contact_email.value === "") {
          return false;
        } else if (contact_message.value === "") {
          return false;
        } else {
          e.preventDefault();
          var contact_request = new XMLHttpRequest();
          var request_form = new FormData();
          var contact_infos = [contact_name.value, contact_email.value, contact_message.value];
          request_form.append('contact-infos', contact_infos);
          contact.disabled = true;
          contact.innerHTML = `<span class="me-3">Sending</span>
  <div class="spinner-border spinner-border-sm" role="status"></div>`;
          contact_request.onreadystatechange = function() {
            if (contact_request.readyState === 4 && contact_request.status === 200) {
              contact.disabled = false;
              response_area.innerHTML = contact_request.responseText;
              contact.innerHTML = "Contact";
              contact_form.reset();
            }
          }
          contact_request.open('POST', 'response.php');
          contact_request.send(request_form);
        }
      })
      // cart empty check :
      setInterval(function() {
        var carts = document.querySelectorAll('#cart');
        carts.forEach(cart => {
          if (cart.children.length === 0) {
            cart.innerHTML = `<div class="alert alert-white text-center p-3 fw-bold">Your cart is empty</div>`;
          }
        })
      }, 100)
      // search function  code start :
      var search_icon = document.getElementById('search');
      var search_input = document.getElementById('search-value');
      search_icon.addEventListener('click', function() {
        if (search_input.value === "") {
          search_input.focus();
          search_input.setAttribute('placeholder', 'Please type a word');
        } else {
          word = search_input.value;
          var request = new XMLHttpRequest();
          var word_form = new FormData();
          word_form.append('search', search_input.value);
          request.onreadystatechange = function() {
            if (request.readyState === 4 && request.status === 200) {
              window.location.href = "searsh.php"
            }
          }
          request.open('POST', 'response.php');
          request.send(word_form);
        }
      })
    </script>
    <?php
    include "includes/footer.php";
    ?>