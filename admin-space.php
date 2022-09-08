<?php
include "includes/header.php";
if (isset($_SESSION['admin'])) {
  // return this session
} else {
?>
  <script>
    window.location.href = "login.php"
  </script>
<?php
}
?>
<!-- content start -->
<div class="container-fluid p-2 bg-white pb-5" id="loaded">
  <h3 class="text-white text-center text-decoration-underline mb-3">Admin-Space</h3>
  <div class="container bg-light shadow-1-strong mt-5">
    <div class="row p-5 shadow-1-strong alert-info">
      <div class="col-lg-2 col-md-3 col-sm-3">
        <img src="images/avatar.png" class="img-fluid rounded-circle p-3 shadow-2-strong bg-white " alt="avatar" style="margin-left: -9.5vh;width: 100px;height: 100px;margin-top: -11vh;">
        <span class="p-2 bg-success badge shadow-3-strong rounded-circle" style="margin-left: -4.5vh;border:1px solid whiteSmoke">
          <span class="visually-hidden">New alerts</span>
        </span>
      </div>
      <div class="col-lg-9">
        <div class="row">
          <div class="col-12 col-lg-9">
            <div class="note note-white shadow-2-strong text-center rounded-0">
              <h4 class="text-warning" style="font-family: 'Times New Roman', Times, serif;">Welcome Admin <span class="badge bg-danger text-white ms-2 me-2 " style="font-family: Georgia, 'Times New Roman', Times, serif;">
              <?php
              // GET ADMIN NAME :
if(isset($_SESSION['admin'])){
  $admin_mail = $_SESSION['admin'];
$current_name = $db -> prepare("SELECT * FROM admins WHERE email='$admin_mail'");
$current_name -> execute();
$admin_name = $current_name -> fetch();
if($admin_name){
  $this_name = $admin_name['firstname'];
  echo $this_name;
}
}
              ?>
              </span> in your Dashboard</h4>
            </div>
          </div>
          <div class="col-lg-3">
            <div class="d-flex flex-column flex-lg-row flex-md-row pt-2 ms-lg-5 me-3 justify-content-center justify-items-center">
              <div class="dropdown">
                <i class="far fa-comment-alt me-3 mb-2 fs-5 text-secondary shadow-3-strong p-2 rounded-pill text-center" style="cursor: pointer;" data-mdb-placement="bottom" title="Messages" data-mdb-toggle="dropdown" aria-expanded="false"></i>
                <span class="position-absolute mt-2 top-0 start-100 translate-middle badge rounded-pill bg-danger" style="margin-left: -2vh;" id="count_message">
                  <span class="visually-hidden">unread messages</span>
                </span>
                <ul class="dropdown-menu p-3" style="width: 320px;height:50vh;overflow-y:auto;" id="messg">
                  <h5 class="text-success text-center">Messages</h5>
                  <!-- Get contact messages -->
                  <?php
                  // select messages from table contact :
                  $Get_contact = $db->prepare("SELECT * FROM contact ORDER BY contact_date DESC");
                  $Get_contact->execute();
                  while ($contact = $Get_contact->fetch()) {
                    if ($contact) {
                      $contact_full_name = $contact['contact_full_name'];
                      $contact_email = $contact['contact_email'];
                      $contact_message = $contact['contact_message'];
                      $contact_date = $contact['contact_date'];
                  ?>
                      <li class="row text-start rounded-3 mb-2 align-items-center  shadow-1-strong bg-light p-3">
                        <div class="row mb-2">
                          <div class="col-6 text-start">From : <span class="text-danger"><?php echo $contact_full_name; ?></span></div>
                          <div class="col-6 text-end"><?php echo $contact_date; ?></div>
                        </div>
                        <hr>
                        <div class="col-lg-2 text-start"><i class="fas fa-comment text-warning bg-white rounded-circle fs-4 p-2"></i></div>
                        <div class="col-lg-8 text-start"><?php echo $contact_message; ?></div>
                        <div class="col-lg-2"><a href="mailto:<?php echo $contact_email; ?>">Replay</a></div>
                      </li>
                  <?php
                    }
                  }

                  ?>
                </ul>
              </div>
              <div class="dropdown">
                <i class="far fa-bell me-3 mb-2 fs-5 text-warning shadow-3-strong p-2  rounded-pill text-center" style="cursor: pointer;" title="Notifications" id="notifications" data-mdb-toggle="dropdown" aria-expanded="false"></i>
                <span class="position-absolute mt-2 top-0 start-100 translate-middle badge rounded-pill bg-danger" style="margin-left: -2vh;" id="count_notif">
                  0
                  <span class="visually-hidden">unread messages</span>
                </span>
                <ul class="dropdown-menu p-3" style="width: 320px;height:50vh;overflow-y:auto;" id="notifs">
                  <h5 class="text-success text-center">Notifications</h5>
                  <?php
                  // get account notifications :
                  $get_notifs = $db->prepare("SELECT * FROM notifications ORDER BY  order_date DESC");
                  $get_notifs->execute();
                  while ($notifs = $get_notifs->fetch()) {
                    $notif_type = $notifs['notif_type'];
                    $notif_firstname = $notifs['user_firstname'];
                    $notif_lastname = $notifs['user_lastname'];
                    $notif_date = $notifs['order_date'];
                    if ($notif_type === "account") {
                  ?>
                      <li class="row text-start rounded-3 mb-2 align-items-center  shadow-1-strong bg-light p-3">
                        <div class="col-lg-2"><i class="fas fa-bell text-warning bg-white rounded-circle fs-4 p-2"></i></div>
                        <div class="col-lg-8">A new registration account for : <span class="text-danger"><?php echo $notif_firstname; ?></span> <br><span class="text-primary"><?php echo $notif_date; ?></span></div>
                        <div class="col-lg-2"><a href="#!" id="view">View</a></div>
                      </li>
                    <?php
                    } else {
                    ?>
                      <li class="row text-start rounded-3 mb-2 align-items-center  shadow-1-strong bg-light p-3">
                        <div class="col-lg-2"><i class="fas fa-bell text-warning bg-white rounded-circle fs-4 p-2"></i></div>
                        <div class="col-lg-8">A new Order submitted by : <span class="text-danger"><?php echo $notif_firstname; ?></span> <br><span class="text-primary"><?php echo $notif_date; ?></span></div>
                        <div class="col-lg-2"><a href="#!" id="order">View</a></div>
                      </li>
                  <?php
                    }
                  }
                  ?>
                </ul>
              </div>
              <div class="dropdown">
                <i class="fas fa-sign-out-alt me-3 mb-2 fs-5 text-danger shadow-3-strong p-2 rounded-pill text-center" style="cursor: pointer;" data-mdb-toggle="tooltip" data-mdb-placement="bottom" title="Logout" id="admin_disconnect"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- notifs -->
    </div>
    <div class="row">
      <div class="col-lg-3 border-end border-dark">
        <div class="row">
          <div class="col-12 p-3 ">
            <!-- Tab navs -->
            <div class="nav flex-column nav-tabs text-start" id="v-tabs-tab" role="tablist" aria-orientation="vertical">
              <a class="nav-link active" id="v-tabs-home-tab" data-mdb-toggle="tab" href="#v-tabs-home" role="tab" aria-controls="v-tabs-home" aria-selected="true"><i class="fas fa-home"></i> Home</a>
              <a class="nav-link" id="v-tabs-profile-tab" data-mdb-toggle="tab" href="#v-tabs-profile" role="tab" aria-controls="v-tabs-profile" aria-selected="false"><i class="fas fa-plus-circle"></i> Add product</a>
              <a class="nav-link" id="v-tabs-messages-tab" data-mdb-toggle="tab" href="#v-tabs-messages" role="tab" aria-controls="v-tabs-messages" aria-selected="false"><i class="fas fa-eye"></i> View products</a>
              <a class="nav-link" id="v-tabs-customers" data-mdb-toggle="tab" href="#v-customers" role="tab" aria-controls="v-customers" aria-selected="false"><i class="fas fa-users"></i> Customers</a>
              <a class="nav-link" id="v-tabs-admins" data-mdb-toggle="tab" href="#v-admins" role="tab" aria-controls="v-admins" aria-selected="false"><i class="fas fa-user-shield"></i> Admins</a>
              <a class="nav-link" id="v-tabs-orders" data-mdb-toggle="tab" href="#v-orders" role="tab" aria-controls="v-orders" aria-selected="false"><i class="fas fa-notes-medical"></i> Orders
                <span class="position-absolute mt-2 ms-3 translate-middle badge rounded-0 bg-warning d-none" id="orders-counter">
                  0
                  <span class="visually-hidden">unread messages</span>
                </span>
              </a>
            </div>
            <!-- Tab navs -->
          </div>

        </div>
      </div>
      <div class="col-lg-9">
        <div class="col-lg-12 p-3">
          <!-- Tab content -->
          <div class="tab-content text-start p-3 bg-white " id="v-tabs-tabContent">
            <div class="tab-pane fade show active" id="v-tabs-home" role="tabpanel" aria-labelledby="v-tabs-home-tab">
              <section>
                <div class="row">
                  <div class="col-12 mt-3 mb-1">
                    <h5 class="text-uppercase">Minimal Statistics Cards</h5>
                    <p>Statistics on minimal cards.</p>
                  </div>
                </div>
                <div class="row">
                  <div class="col-xl-4 col-sm-6 col-12 mb-4">
                    <div class="card">
                      <div class="card-body">
                        <div class="d-flex justify-content-between px-md-1">
                          <div class="align-self-center">
                            <i class="fas fa-calendar-check text-info fa-3x"></i>
                          </div>
                          <div class="text-end">
                            <h3 id="today"></h3>
                            <p class="mb-0">Today Date</p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-xl-4 col-sm-6 col-12 mb-4">
                    <div class="card">
                      <div class="card-body">
                        <div class="d-flex justify-content-between px-md-1">
                          <div class="align-self-center">
                            <i class="fas fa-chart-line text-success fa-3x"></i>
                          </div>
                          <div class="text-end">
                            <h3>
                              <!-- Get sales confirmed rate -->
                              <?php
                              $rate = $db->prepare("SELECT * FROM users_order_infos WHERE order_status='confirmed'");
                              $rate->execute();
                              $sales_rate = $rate->fetch();
                              if ($sales_rate) {
                                // get removed orders :
                                $removed = $db->prepare("SELECT * FROM users_order_infos");
                                $removed->execute();
                                $total_rate = $removed->fetch();
                                if ($total_rate) {
                                  echo ceil($rate->rowCount() / ($rate->rowCount() + $removed->rowCount() / $removed->rowCount())) * 3 . " %";
                                }
                              }
                              ?>
                            </h3>
                            <p class="mb-0">Orders Rate per (week)</p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-xl-4 col-sm-6 col-12 mb-4">
                    <div class="card">
                      <div class="card-body">
                        <div class="d-flex justify-content-between px-md-1">
                          <div class="align-self-center">
                            <i class="fas fa-map-marker-alt text-danger fa-3x"></i>
                          </div>
                          <div class="text-end">
                            <h3>
                              <!-- Get visits number -->
                              <?php
                              $visits = $db->prepare("SELECT * FROM visits");
                              $visits->execute();
                              if ($visits_rate = $visits->fetch()) {
                                $vists_number = $visits_rate['visits_number'];
                                echo $vists_number;
                              }
                              ?>
                            </h3>
                            <p class="mb-0">Total Visits per (page)</p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-xl-4 col-sm-6 col-12 mb-4">
                    <div class="card">
                      <div class="card-body">
                        <div class="d-flex justify-content-between px-md-1">
                          <div>
                            <h3 class="text-danger"><?php
                                                    // get total products :
                                                    $products = $db->prepare("SELECT * FROM products");
                                                    $products->execute();
                                                    $products_total = $products->rowCount();
                                                    echo $products_total;
                                                    ?></h3>
                            <p class="mb-0">All Products</p>
                          </div>
                          <div class="align-self-center">
                            <i class="fas fa-rocket text-danger fa-3x"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-xl-4 col-sm-6 col-12 mb-4">
                    <div class="card">
                      <div class="card-body">
                        <div class="d-flex justify-content-between px-md-1">
                          <div>
                            <h3 class="text-success"><?php
                                                      // get total products :
                                                      $users = $db->prepare("SELECT * FROM users");
                                                      $users->execute();
                                                      $users_total = $users->rowCount();
                                                      echo $users_total;
                                                      ?></h3>
                            <p class="mb-0">New Clients</p>
                          </div>
                          <div class="align-self-center">
                            <i class="far fa-user text-success fa-3x"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>


                </div>

              </section>
            </div>
            <div class="tab-pane fade" id="v-tabs-profile" role="tabpanel" aria-labelledby="v-tabs-profile-tab">
              <p id="result"></p>
              <!-- Error Alert -->
              <div class="alert alert-warning alert-dismissible fade show">
                <strong>Add a new product NB : </strong> To add a new product , please fill in these text fiels with all product details.
                <button type="button" class="btn-close" data-mdb-dismiss="alert"></button>
              </div>
              <form class="card p-3 rounded-0" id="product-form">
                <!-- 2 column grid layout with text inputs for the first and last names -->
                <div class="row mb-4 ">
                  <div class="col-12 col-lg-6">
                    <div class="form-outline">
                      <input type="text" id="name" class="form-control  mb-2" required />
                      <label class="form-label" for="name">Product name</label>
                    </div>
                  </div>
                  <div class="col-12 col-lg-6">
                    <div class="form-outline">
                      <input type="number" id="price" class="form-control mb-2" min="1" required />
                      <label class="form-label" for="price">Product price</label>
                    </div>
                  </div>
                </div>

                <!-- qt input -->
                <div class="form-outline mb-4">
                  <input type="number" id="quantity" class="form-control" min="1" required />
                  <label class="form-label" for="quantity">Product Quantity</label>
                </div>

                <!-- files input -->
                <label class="label mb-4 text-info" for="images">Product images</label>
                <p id="alert"></p>
                <div class="form-outline mb-4">
                  <input type="file" id="images" class="form-control" multiple required />
                </div>
                <!-- description input -->
                <div class="form-outline mb-4">
                  <textarea class="form-control" id="description" rows="4" required></textarea>
                  <label class="form-label" for="description">Descripton</label>
                </div>
                <!-- Checked checkbox -->
                <div class="form-check mb-4">
                  <input class="form-check-input" type="checkbox" value="" id="promotion-check" />
                  <label class="form-check-label" for="promotion-check">With promotion</label>
                </div>
                <!-- with promotion area -->
                <div class="row mb-4 d-none" id="with-promotion">
                  <div class="col-12 col-lg-6">
                    <div class="form-outline">
                      <input type="number" id="product-promotion" class="form-control" />
                      <label class="form-label" for="product-promotion">Product promotion</label>
                    </div>
                  </div>
                  <div class="col-12 col-lg-6">
                    <div class="form-outline">
                      <input type="date" id="promotion-date" class="form-control" />
                      <label class="form-label" for="promotion-date">Promotion date</label>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-lg-2">
                  <!-- Submit button -->
                  <button type="submit" class="btn btn-primary  mb-4" id="add-product">Add</button>
                </div>
              </form>
            </div>
            <div class="tab-pane fade" id="v-tabs-messages" role="tabpanel" aria-labelledby="v-tabs-messages-tab">
              <div class="row" id="myProducts">
                <h3 class="text-muted text-center text-decoration-underline mb-3">Recent added products</h3>
                <?php
                // get products from db :
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
                          <div class="card" style="height: 460px;">
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
                                  <p class="text-muted">4.5 <?php
                                                            if ($product_quantity >= 10) {
                                                            ?> <span class="badge bg-success text-white fw-bold">IN STOCK ( <?php echo $product_quantity;  ?> )</span> <?php
                                                                                                                                                                      } else if ($product_quantity < 2) {
                                                                                                                                                                        ?> <span class="badge bg-danger text-white fw-bold">OUT STOCK ( <?php echo $product_quantity;  ?> )</span> <?php
                                                                                                                                                                                                                                                } else {
                                                                                                                                                                                                                                                  ?> <span class="badge bg-warning text-white fw-bold">ALERT STOCK ( <?php echo $product_quantity;  ?> )</span> <?php
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
                              <div class="row border border-dark ">
                                <input type="hidden" value="<?php echo  $product_name; ?>">
                                <input type="hidden" value="<?php echo  $product_id; ?>">
                                <div class="col-12 col-lg-6 border border-dark text-center p-2"><i class="fas fa-pen-alt fs-6 text-success w-100 p-2 " style="cursor:pointer" title="Edit" data-mdb-toggle="modal" data-mdb-target="#modifications" data-id="<?php echo $product_id; ?>" id="edit"></i></div>
                                <div class="col-12 col-lg-6 p-2 text-center border border-dark"><i class="fas fa-trash-alt fs-6 text-danger w-100 p-2" style="cursor:pointer" title="Delete" data-mdb-toggle="modal" data-mdb-target="#delete" id="btn_delete"></i></div>
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
            <div class="tab-pane fade" id="v-customers" role="tabpanel" aria-labelledby="v-tabs-customers">
              <div class="container mt-3 mb-4">
                <h3 class="text-muted text-center text-decoration-underline mb-3">My customers details</h3>
                <div class="col-lg-12 mt-4 mt-lg-0">
                  <div id="clients_disponibilty"></div>
                  <div class="row" id="client_area">
                    <div class="col-md-12 card rounded-0 p-3">
                      <div class="user-dashboard-info-box table-responsive mb-0 bg-white p-4 shadow-sm">
                        <table class="table manage-candidates-top mb-0">
                          <thead>
                            <tr>
                              <th>Client Name</th>
                              <th class="text-center">E-mail</th>
                              <th class="action text-right">Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php

                            try {
                              # get == all my == customers == infos :
                              $clients_infos = $db->prepare("SELECT * FROM users ORDER BY register_date DESC");
                              $clients_infos->execute();
                              while ($clients = $clients_infos->fetch()) {
                                if ($clients) {
                                  $client_email = $clients['email'];
                                  $client_firstname = $clients['firstname'];
                                  $client_lastname = $clients['lastname'];
                                  $client_phone = $clients['client_phone'];
                                  $client_adress = $clients['client_address'];
                            ?>
                                  <tr class="candidates-list">
                                    <td class="title">
                                      <div class="thumb">
                                        <img class="img-fluid" src="images/avatar.png" alt="">
                                      </div>
                                      <div class="candidate-list-details">
                                        <div class="candidate-list-info">
                                          <div class="candidate-list-title">
                                            <h5 class="mb-0"><a href="#"><?php echo $client_firstname;  ?></a></h5>
                                          </div>
                                          <div class="candidate-list-option">
                                            <ul class="list-unstyled">
                                              <li><i class="fas fa-phone pr-1"></i> <?php if ($client_phone === NULL) {
                                                                                      echo "Not available";
                                                                                    } else {
                                                                                      echo $client_phone;
                                                                                    } ?></li>
                                              <li><i class="fas fa-map-marker-alt pr-1"></i> <?php if ($client_adress === "") {
                                                                                                echo "Not available";
                                                                                              } else {
                                                                                                echo $client_adress;
                                                                                              } ?></li>
                                            </ul>
                                          </div>
                                        </div>
                                      </div>
                                    </td>
                                    <td class="candidate-list-favourite-time text-center">
                                      <a class="candidate-list-favourite order-2 text-danger" href="#"></a>
                                      <span class="candidate-list-time order-1"><a href="mailto:<?php echo $client_email; ?>"><?php echo $client_email; ?></a></span>
                                    </td>
                                    <td>
                                      <ul class="list-unstyled mb-0 d-flex justify-content-end">
                                        <input type="hidden" value="<?php echo $client_email; ?>">
                                        <input type="hidden" value="<?php echo $client_firstname; ?>">
                                        <li><a href="<?php if ($client_phone === NULL) {
                                                        echo "#!";
                                                      } else {
                                                        echo "tel:" . $client_phone;
                                                      } ?>"><i class="fas fa-phone text-info me-3" style="cursor: pointer;" data-mdb-toggle="tooltip" data-mdb-placement="bottom" title="Contact client"></i></a></li>
                                        <li><a href="#" class="text-danger me-3" data-mdb-toggle="tooltip" title="Delete client" data-original-title="Delete" data-mdb-placement="bottom"><i class="far fa-trash-alt" data-mdb-toggle="modal" data-mdb-target="#delete_client" id="delete-client"></i></a></li>
                                      </ul>
                                    </td>
                                  </tr>

                              <?php
                                }
                              }
                            } catch (Exception $e) {
                              die("error : " . $e->getMessage());
                            }
                            if ($clients_infos->rowCount() === 0) {
                              ?>
                              <script>
                                var client_area = document.getElementById('client_area').style.display = "none";
                                var clients_disponibility = document.getElementById('clients_disponibilty').innerHTML = `
<div class="alert alert-white text-dark p-2 rounded-0 fw-bold text-center">No customer account found yet</div>`
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
            <div class="tab-pane fade" id="v-admins" role="tabpanel" aria-labelledby="v-tabs-admins">
              <div class="container">
                <div class="main-body">
                  <h3 class="text-muted text-center text-decoration-underline mb-3">List of admins</h3>
                  <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl- gutters-sm">
                    <?php
                    // get == admins == lists == code == start :
                    $admins = $db->prepare("SELECT * FROM admins ORDER BY register_date DESC");
                    $admins->execute();
                    while ($admins_infos = $admins->fetch()) {
                      $admin_email = $admins_infos['email'];
                      $admin_firstname = $admins_infos['firstname'];
                      $admin_lastname = $admins_infos['lastname'];
                    ?>
                      <div class="col-lg-4 mb-3">
                        <div class="card">
                          <img src="images/logo-admin.jpg" alt="Cover" class="card-img-top">
                          <div class="card-body text-center">
                            <img src="images/avatar2.jpg" style="width:100px;margin-top:-65px" alt="User" class="img-fluid img-thumbnail rounded-circle border-0 mb-3">
                            <h5 class="card-title"><?php echo $admin_firstname . "_" . $admin_lastname; ?></h5>
                            <p class="text-secondary mb-1">Admin</p>
                            <p class="text-muted font-size-sm">Bay Area, Jendouba , TN</p>
                          </div>
                          <div class="card-footer">
                            <a href="mailto:<?php echo $admin_email; ?>"> <button class="btn btn-light btn-sm bg-white has-icon btn-block" type="button"><i class="material-icons"></i><i class="fas fa-phone-volume"></i> Contact</button></a>
                          </div>
                        </div>
                      </div>
                    <?php
                    }
                    ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="v-orders" role="tabpanel" aria-labelledby="v-tabs-orders">
              <div class="row" id="orders_area">
                <h3 class="text-muted text-center text-decoration-underline mb-3">Recent receiving orders </h3>
                <hr>
                <div class="row row-cols-lg-2 mb-3">
                  <div class="lead">
                    <p class="lead text-secondary">Filter orders by statuts : </p>
                  </div>
                  <div class="select">
                    <select class="form-select" id="order-status">
                      <option value="null">In progress</option>
                      <option value="confirmed">Confirmed</option>
                      <option value="removed">Removed</option>
                    </select>
                  </div>
                </div>
                <hr>
                <div id="filter"></div>
                <div id="order_result"></div>
                <?php
                // get receiving orders :
                $get_orders = $db->prepare("SELECT * FROM users_order_infos WHERE order_status ='in progress' ORDER BY order_date DESC LIMIT 2");
                $get_orders->execute();
                while ($order = $get_orders->fetch()) {
                  if ($order) {
                    $user_email = $order['user_email'];
                    // get order_id
                    $order_products_id = $db->prepare("SELECT * FROM order_infos WHERE user_email='$user_email' LIMIT 1");
                    $order_products_id->execute();
                    $current_id = $order_products_id->fetch();

                    if ($current_id) {
                      $result_id = $current_id['order_id'];
                ?>
                      <!-- order  -->
                      <div class="col-12 col-lg-6 mb-2">
                        <div class="card px-2" style="height: 360px;overflow-y:auto">
                          <div class="card-header bg-white">
                            <div class="row justify-content-between">
                              <div class="col-12 col-lg-6">
                                <p class="text-muted mt-1"> Order ID : <br> <span class="font-weight-bold text-dark"><?php echo $result_id; ?></span></p>
                              </div>
                              <div class="col-12 col-lg-6 m-auto">
                                <h6 class="ml-auto mr-3">
                                  <input type="hidden" value="<?php echo $user_email;  ?>" id="user_id">
                                  <a href="#" id="order_details">View Details</a>
                                </h6>
                              </div>
                            </div>
                          </div>
                          <div class="card-body">

                            <div class="media flex-column flex-sm-row flex-lg-row">
                              <div class="media-body ">
                                <?php
                                // get products names :
                                $order_products = $db->prepare("SELECT * FROM order_infos WHERE user_email='$user_email' ORDER BY order_date DESC");
                                $order_products->execute();
                                while ($order_result = $order_products->fetch()) {
                                  $id = $order_result['id'];
                                  $order_id = $order_result['order_id'];
                                  $order_name = $order_result['order_products_name'];
                                  $order_quantity = $order_result['order_products_quantity'];
                                  $order_product_total = $order_result['product_total'];
                                  $order_total = $order_result['total'];
                                  $order_date = $order_result['order_date'];

                                ?>

                                  <input type="hidden" value="<?php echo $order_name;  ?>">
                                  <input type="hidden" value="<?php echo $order_quantity;  ?>">
                                  <h5 class="bold">X <?php echo $order_quantity . " " . $order_name; ?> <span class="text-secondary">[<?php echo $order_product_total; ?> TND]</span> </h5>
                                <?php
                                }
                                ?>
                                <h4 class="mt-3 mb-4 bold text-danger"> <span class="mt-5"></span> <?php global $order_total;
                                                                                                    echo $order_total; ?><span class="small text-muted"> TND </span></h4>
                                <p class="text-muted">Tracking Status on: <span class="Today"><?php global $order_date;
                                                                                              echo $order_date; ?></span></p>

                              </div>
                            </div>
                          </div>
                          <div class="card-footer  bg-white px-sm-3 pt-sm-4 px-0">
                            <div class="row text-center">
                              <div class="col my-auto  border-line text-success" data-mdb-toggle="modal" data-mdb-target="#delete_order" id="confirme-order">
                                <input type="hidden" value="<?php echo $user_email;  ?>">
                                <h5>Confirme</h5>
                              </div>
                              <div class="col  my-auto  border-line text-danger border-0" id="cancel-order">
                                <input type="hidden" value="<?php echo $user_email;  ?>">
                                <input type="hidden" value="<?php echo $order_id;  ?>">
                                <h5>Cancel</h5>
                              </div>

                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- /order  -->

                <?php
                    }
                  }
                }
                ?>
                <!-- Get the next orders -->
                <?php
                $next_order = $db->prepare("SELECT * FROM users_order_infos WHERE order_status ='in progress'   ORDER BY order_date DESC LIMIT 10 OFFSET 2");
                $next_order->execute();
                if ($next_order->rowCount() > 0) {
                ?>
                  <a class="link p-2 ms-2" data-mdb-toggle="collapse" href="#next_order" role="button" aria-expanded="false" aria-controls="next_order">
                    View more...
                  </a>
                  <!-- Collapsed content -->
                  <div class="collapse mt-3 " id="next_order">
                    <div class="row row-cols-lg-2">
                      <?php
                    }
                    while ($next = $next_order->fetch()) {
                      if ($next) {
                      ?>

                        <div>
                          <?php
                          $user_email = $next['user_email'];
                          // get order_id
                          $order_products_id = $db->prepare("SELECT * FROM order_infos WHERE user_email='$user_email' ");
                          $order_products_id->execute();
                          $current_id = $order_products_id->fetch();
                          $result_id = $current_id['order_id'];
                          ?>
                          <!-- order  -->
                          <div class="card px-2" style="height: 360px;overflow-y:auto">
                            <div class="card-header bg-white">
                              <div class="row justify-content-between">
                                <div class="col-12 col-lg-6">
                                  <p class="text-muted mt-1"> Order ID : <br> <span class="font-weight-bold text-dark"><?php echo $result_id; ?></span></p>
                                </div>
                                <div class="col-12 col-lg-6 m-auto">
                                  <h6 class="ml-auto mr-3">
                                    <input type="hidden" value="<?php echo $user_email;  ?>" id="user_id">
                                    <a href="#" id="order_details">View Details</a>
                                  </h6>
                                </div>
                              </div>
                            </div>
                            <div class="card-body">

                              <div class="media flex-column flex-sm-row flex-lg-row">
                                <div class="media-body ">
                                  <?php
                                  // get products names :
                                  $order_products = $db->prepare("SELECT * FROM order_infos WHERE user_email='$user_email' ORDER BY order_date DESC");
                                  $order_products->execute();
                                  while ($order_result = $order_products->fetch()) {
                                    $id = $order_result['id'];
                                    $order_id = $order_result['order_id'];
                                    $order_name = $order_result['order_products_name'];
                                    $order_quantity = $order_result['order_products_quantity'];
                                    $order_product_total = $order_result['product_total'];
                                    $order_total = $order_result['total'];
                                    $order_date = $order_result['order_date'];

                                  ?>
                                    <input type="hidden" value="<?php echo $order_name;  ?>">
                                    <input type="hidden" value="<?php echo $order_quantity;  ?>">
                                    <h5 class="bold">X <?php echo $order_quantity . " " . $order_name; ?> <span class="text-secondary">[<?php echo $order_product_total; ?> TND]</span> </h5>
                                  <?php
                                  }
                                  ?>
                                  <h4 class="mt-3 mb-4 bold text-danger"> <span class="mt-5"></span> <?php echo $order_total; ?><span class="small text-muted"> TND </span></h4>
                                  <p class="text-muted">Tracking Status on: <span class="Today"><?php echo $order_date; ?></span></p>

                                </div>
                              </div>
                            </div>
                            <div class="card-footer  bg-white px-sm-3 pt-sm-4 px-0">
                              <div class="row text-center">
                                <div class="col my-auto  border-line text-success" data-mdb-toggle="modal" data-mdb-target="#delete_order" id="confirme-order">

                                  <h5>Confirme</h5>
                                </div>
                                <div class="col  my-auto  border-line text-danger border-0" id="cancel-order">
                                  <input type="hidden" value="<?php echo $user_email;  ?>">
                                  <input type="hidden" value="<?php echo $order_id;  ?>">
                                  <h5>Cancel</h5>
                                </div>

                              </div>
                            </div>
                          </div>

                          <!-- /order  -->

                          <?php

                          ?>
                        </div>

                    <?php

                      }
                    } // while end
                    ?>
                    </div>
                  </div>
                  <?php
                  ?>

              </div>
            </div>
          </div>
          <!-- Tab content -->
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<!-- content end -->
<!-- modification product modal component -->
<!-- Modal -->
<div class="modal top fade" id="modifications" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-mdb-backdrop="static" data-mdb-keyboard="false">
  <div class="modal-dialog modal-lg  modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <input type="hidden" id="p_id">
        <h5 class="modal-title" id="exampleModalLabel">Edit product :</h5>
        <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
      </div>
      <div id="image_delete"></div>
      <div class="modal-body" id="response">
        <?php
        if (isset($_SESSION['id'])) {
          echo $_SESSION['id'];
        }
        ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">
          Close
        </button>
        <button type="button" class="btn btn-primary" id="save-modification">Save changes</button>
      </div>
    </div>
  </div>
</div>
<!-- delete product modal -->
<!-- Modal -->
<div class="modal top fade" id="delete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-mdb-backdrop="static" data-mdb-keyboard="false">
  <div class="modal-dialog modal-md  modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Delete product</h5>
        <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
      </div>
      <input type="hidden" id="delete-p-id">
      <div class="modal-body" id="product_infos">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">
          Cancel
        </button>
        <button type="button" class="btn btn-primary" id="delation">Delete</button>
      </div>
    </div>
  </div>
</div>
<!-- delete client modal -->
<!-- Modal -->
<div class="modal top fade " id="delete_client" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-mdb-backdrop="static" data-mdb-keyboard="false">
  <div class="modal-dialog modal-md  modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Delete Client</h5>
        <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
      </div>
      <input type="hidden" id="client-id">
      <div class="modal-body" id="client_infos">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">
          Cancel
        </button>
        <button type="button" class="btn btn-primary" id="remove-client-btn">Delete</button>
      </div>
    </div>
  </div>
</div>
<!-- delete order modal -->
<!-- Modal -->
<div class="modal top fade" id="delete_order" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-mdb-backdrop="true" data-mdb-keyboard="true">
  <div class="modal-dialog   modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Confirme order</h5>
        <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="modal-confirme">
        <h5 class="text-danger  text-center">If accept this order :</h5>
        <p class="lead">1/ Quantity will be updating in stock</p>
        <p class="lead">2/ Client will receive a confirmation E-mail</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">
          Close
        </button>
        <button type="button" class="btn btn-primary" id="confirmation">Confirme</button>
      </div>
    </div>
  </div>
</div>
<!-- order details modal -->
<!-- Modal -->
<button class="d-none" data-mdb-target="#details" data-mdb-toggle="modal" id="get_modal_details"></button>
<div class="modal top fade " id="details" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-mdb-backdrop="true" data-mdb-keyboard="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content order">
      <div class="modal-header">
        <h5 class="modal-title text-white" id="exampleModalLabel">Order details</h5>
        <button type="button" class="btn-close btn-danger" data-mdb-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="order_place">

      </div>
    </div>
  </div>
</div>
<!-- css -->
<style>
  .nav-tabs .nav-item.show .nav-link,
  .nav-tabs .nav-link {
    color: blueviolet;
    background-color: white;
    border-color: #e0e0e0 #e0e0e0 #fff;
    font-size: 16px;
    margin-top: 10px;
    font-weight: 300;
  }

  .nav-tabs .nav-item.show .nav-link,
  .nav-tabs .nav-link.active {
    color: #fff !important;
    background-color: darkmagenta;
    border-color: #e0e0e0 #e0e0e0 #fff !important;
    text-align: center !important;
    font-weight: bold;
  }

  /* customer style */
  .p-4 {
    padding: 1.5rem !important;
  }

  .mb-0,
  .my-0 {
    margin-bottom: 0 !important;
  }

  .shadow-sm {
    box-shadow: 0 .125rem .25rem rgba(0, 0, 0, .075) !important;
  }

  /* user-dashboard-info-box */
  .user-dashboard-info-box .candidates-list .thumb {
    margin-right: 20px;
  }

  .user-dashboard-info-box .candidates-list .thumb img {
    width: 80px;
    height: 80px;
    -o-object-fit: cover;
    object-fit: cover;
    overflow: hidden;
    border-radius: 50%;
  }

  .user-dashboard-info-box .title {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    padding: 30px 0;
  }

  .user-dashboard-info-box .candidates-list td {
    vertical-align: middle;
  }

  .user-dashboard-info-box td li {
    margin: 0 4px;
  }

  .user-dashboard-info-box .table thead th {
    border-bottom: none;
  }

  .table.manage-candidates-top th {
    border: 0;
  }

  .user-dashboard-info-box .candidate-list-favourite-time .candidate-list-favourite {
    margin-bottom: 10px;
  }

  .table.manage-candidates-top {
    min-width: 650px;
  }

  .user-dashboard-info-box .candidate-list-details ul {
    color: #969696;
  }

  /* clients List */
  .candidate-list {
    background: #ffffff;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    border-bottom: 1px solid #eeeeee;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    padding: 20px;
    -webkit-transition: all 0.3s ease-in-out;
    transition: all 0.3s ease-in-out;
  }

  .candidate-list:hover {
    -webkit-box-shadow: 0px 0px 34px 4px rgba(33, 37, 41, 0.06);
    box-shadow: 0px 0px 34px 4px rgba(33, 37, 41, 0.06);
    position: relative;
    z-index: 99;
  }

  .candidate-list:hover a.candidate-list-favourite {
    color: #e74c3c;
    -webkit-box-shadow: -1px 4px 10px 1px rgba(24, 111, 201, 0.1);
    box-shadow: -1px 4px 10px 1px rgba(24, 111, 201, 0.1);
  }

  .candidate-list .candidate-list-image {
    margin-right: 25px;
    -webkit-box-flex: 0;
    -ms-flex: 0 0 80px;
    flex: 0 0 80px;
    border: none;
  }

  .candidate-list .candidate-list-image img {
    width: 80px;
    height: 80px;
    -o-object-fit: cover;
    object-fit: cover;
  }

  .candidate-list-title {
    margin-bottom: 5px;
  }

  .candidate-list-details ul {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    margin-bottom: 0px;
  }

  .candidate-list-details ul li {
    margin: 5px 10px 5px 0px;
    font-size: 13px;
  }

  .candidate-list .candidate-list-favourite-time {
    margin-left: auto;
    text-align: center;
    font-size: 13px;
    -webkit-box-flex: 0;
    -ms-flex: 0 0 90px;
    flex: 0 0 90px;
  }

  .candidate-list .candidate-list-favourite-time span {
    display: block;
    margin: 0 auto;
  }

  .candidate-list .candidate-list-favourite-time .candidate-list-favourite {
    display: inline-block;
    position: relative;
    height: 40px;
    width: 40px;
    line-height: 40px;
    border: 1px solid #eeeeee;
    border-radius: 100%;
    text-align: center;
    -webkit-transition: all 0.3s ease-in-out;
    transition: all 0.3s ease-in-out;
    margin-bottom: 20px;
    font-size: 16px;
    color: #646f79;
  }

  .candidate-list .candidate-list-favourite-time .candidate-list-favourite:hover {
    background: #ffffff;
    color: #e74c3c;
  }

  .candidate-banner .candidate-list:hover {
    position: inherit;
    -webkit-box-shadow: inherit;
    box-shadow: inherit;
    z-index: inherit;
  }

  .bg-white {
    background-color: #ffffff !important;
  }

  .p-4 {
    padding: 1.5rem !important;
  }

  .mb-0,
  .my-0 {
    margin-bottom: 0 !important;
  }

  .shadow-sm {
    box-shadow: 0 .125rem .25rem rgba(0, 0, 0, .075) !important;
  }

  .user-dashboard-info-box .candidates-list .thumb {
    margin-right: 20px;
  }

  /* orders style */
  p {
    font-size: 14px;
    margin-bottom: 7px;
  }

  .cursor-pointer {
    cursor: pointer;
  }

  a {
    text-decoration: none !important;
    color: #651FFF;
  }

  .bold {
    font-weight: 600;
  }

  .small {
    font-size: 12px !important;
    letter-spacing: 0.5px !important;
  }

  .Today {
    color: rgb(83, 83, 83);
  }

  .btn-outline-primary {
    background-color: #fff !important;
    color: #4bb8a9 !important;
    border: 1.3px solid #4bb8a9;
    font-size: 12px;
    border-radius: 0.4em !important;
  }

  .btn-outline-primary:hover {
    background-color: #4bb8a9 !important;
    color: #fff !important;
    border: 1.3px solid #4bb8a9;
  }

  .btn-outline-primary:focus,
  .btn-outline-primary:active {
    outline: none !important;
    box-shadow: none !important;
    border-color: #42A5F5 !important;
  }



  .card {
    background-color: #fff;
    box-shadow: 1px 2px 10px 0px rgb(0, 108, 170);
    z-index: 0;
  }

  small {
    font-size: 12px !important;
  }

  .a {
    justify-content: space-between !important;
  }

  .border-line {
    border-right: 1px solid rgb(226, 206, 226)
  }

  .card-footer img {
    opacity: 0.3;
  }

  .card-footer h5 {
    font-size: 1.1em;
    color: #8C9EFF;
    cursor: pointer;
  }

  .plus {
    margin-top: 8vh;
    font-size: 17px;
    color: blue;
    cursor: pointer;
    background-color: whitesmoke;
    text-align: center;
    padding: 5px;
    border-radius: 5px;
  }

  .plus:hover {
    color: red;
    font-size: 17px;
    transition: .3s ease-in;
  }

  .preview {
    width: 250px !important;
    height: 150px !important;
    margin: 15px !important;
  }

  .order {
    background: url(./images/pexels-pixabay-531880.jpg);
  }
</style>
<!-- js -->
<script>
  // today date :
  var today_card = document.getElementById('today')
  var today = new Date();
  var dd = String(today.getDate()).padStart(2, '0');
  var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
  var yyyy = today.getFullYear();
  today = dd + '-' + mm + '-' + yyyy;
  today_card.innerHTML = today;

  // with promotion :
  var with_promotion_area = document.getElementById('with-promotion');
  var promotion_check_checkbox = document.getElementById('promotion-check');
  var add_product_btn = document.getElementById('add-product');
  var product_promotion = document.getElementById('product-promotion');
  var promotion_date = document.getElementById('promotion-date');
  setInterval(function() {
    if (promotion_check_checkbox.checked === true) {
      with_promotion_area.classList = "row mb-4"
      if (product_promotion.value === "" || product_promotion.value[0] === "0") {
        add_product_btn.style.pointerEvents = "none"
      } else if (promotion_date.value === "" || promotion_date.value[0] === null) {
        add_product_btn.style.pointerEvents = "none"
      } else {
        add_product_btn.style.pointerEvents = "all"
      }
    } else {
      with_promotion_area.classList = "row mb-4 d-none"
      product_promotion.value = ""
      promotion_date.value = null
      add_product_btn.style.pointerEvents = "all"
    }
  }, 100)

  // add product code start :
  var product_name = document.getElementById('name');
  var product_price = document.getElementById('price');
  var product_quantity = document.getElementById('quantity');
  var product_images = document.getElementById('images');
  var product_description = document.getElementById('description');
  var result = document.getElementById('result')
  var product_form = document.getElementById('product-form')
  add_product_btn.addEventListener('click', addProduct);

  function addProduct(e) {
    if (product_name.value === "") {
      return false
    } else if (product_price.value === "" || product_price.value === "0") {
      return false
    } else if (product_quantity.value === "" || product_quantity.value === "0") {
      return false
    } else if (product_images.value == "") {
      return false
    } else if (product_description.value === "") {
      return false
    } else {
      e.preventDefault();
      add_product_btn.disabled = true;
      var request = new XMLHttpRequest();
      var form = new FormData();
      for (var image of product_images.files) {
        form.append('product_images[]', image)
      }
      var product_details = [product_name.value, product_price.value, product_quantity.value, product_description.value, product_promotion.value, promotion_date.value];
      form.append('details', product_details);
      request.onreadystatechange = function() {
        if (request.readyState === 4 && request.status === 200) {
          add_product_btn.disabled = false;
          result.innerHTML = request.responseText
          product_form.reset()
        }

      }

      request.open('POST', 'response.php');
      request.send(form);
    }
  }

  // set product images length :
  var warning = document.getElementById('alert')
  product_images.onchange = function() {
    if (product_images.files.length > 3) {
      warning.innerHTML = `
    <div class="alert alert-danger alert-dismissible fade fs-6 show">
      <strong> NB : </strong> You should not give than 3 images for product.
      <button type="button" class="btn-close" data-mdb-dismiss="alert"></button>
  </div>`;
      product_images.value = null;
    } else {
      warning.innerHTML = "";
    }
  }
  var load ;
  // edit product code start : 
  var edits = document.querySelectorAll('#edit');
  var input_id = document.getElementById('p_id')
  var response = document.getElementById('response')
  edits.forEach(edit => {
    edit.addEventListener('click', function() {
      var id = edit.getAttribute('data-id');
      // input_id.value=id;
      edit.disabled = true;
      var edit_request = new XMLHttpRequest()
      var edit_form = new FormData()
      edit_form.append('modifiateID', id)
      edit_request.onreadystatechange = function() {
        if (edit_request.readyState === 4 && edit_request.status === 200) {
          edit.disabled = false
          response.innerHTML = edit_request.responseText
          // $('#v-tabs-messages').load(location.href + " #v-tabs-messages")
          // input === file === show === result
          var show = document.getElementById('show')
          var preview = document.getElementById('preview')
          var file2 = document.getElementById('file2_modif')
          file2.onchange = function() {
            show.classList = "row mt-4 mb-4 p-2"
            for (var image of file2.files) {
              var image_preview = document.createElement('img')
              image_preview.setAttribute('class', 'img-fluid rounded p-2  border border-success preview')
              var col = document.createElement('div')
              col.setAttribute('class', 'col-3')
              var image_preview_src = URL.createObjectURL(image)
              image_preview.src = image_preview_src
              col.append(image_preview)
              preview.append(col)
            }
          }
          // send === request === for === annuler === button :
          var annuler = document.getElementById('console');
          annuler.onclick = function() {
            file2.value = null
            preview.innerHTML = ""
            show.classList = "row mt-4 mb-4 p-2 d-none"
          }
          // date control :
          var today = new Date();
          var dd = String(today.getDate()).padStart(2, '0');
          var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
          var yyyy = today.getFullYear();
          today = yyyy + '-' + mm + '-' + dd;
          var btn_save = document.getElementById('save-modification')
          var p_promotion_rate = document.getElementById('edit-p-promotion-rate')
          var retard_alert = document.getElementById('date-retard')
          setInterval(function() {
            var date_modifier = document.getElementById('edit-p-promotion-date');
            date_modifier.onchange = function() {
              if (date_modifier.value < today) {

                retard_alert.innerHTML = `    <!-- Error Alert -->
    <div class="alert alert-danger alert-dismissible fade show fs-6">
          <strong>NB : </strong> Please choose another date that be equal or greater than today
          <button type="button" class="btn-close" data-mdb-dismiss="alert"></button>
      </div>`
                date_modifier.value = null
                btn_save.style.pointerEvents = "none"
              } else {
                retard_alert.innerHTML = ''
                btn_save.style.pointerEvents = "all"
              }
            }
            if (date_modifier.value >= today && p_promotion_rate.value === "") {
              btn_save.style.pointerEvents = "none"
              retard_alert.innerHTML = `
 <!-- Error Alert -->
    <div class="alert alert-danger alert-dismissible fade show fs-6">
          <strong>NB : </strong> Product promotion value does not empty
          <button type="button" class="btn-close" data-mdb-dismiss="alert"></button>
      </div>`
            } else if (date_modifier.value === "" && p_promotion_rate.value !== "0") {
              p_promotion_rate.value = "0"
              retard_alert.innerHTML = ""
              btn_save.style.pointerEvents = "all"
            } else if (date_modifier.value >= today && p_promotion_rate.value[0] === "0") {
              btn_save.style.pointerEvents = "none"
              retard_alert.innerHTML = `
 <!-- Error Alert -->
    <div class="alert alert-danger alert-dismissible fade show fs-6">
          <strong>NB : </strong> Product promotion value does not empty
          <button type="button" class="btn-close" data-mdb-dismiss="alert"></button>
      </div>`
            } else {
              btn_save.style.pointerEvents = "all"
              retard_alert.innerHTML = ""
            }
          }, 100)
          // delete === image === button === request 
          var deletes_image = document.querySelectorAll('#delete_image');
          deletes_image.forEach(dell => {
            dell.addEventListener('click', dellImage)
          })
          // function === delete === image === code === start :
          var response_area = document.getElementById('image_delete')

          function dellImage() {
            var image_id = this.parentElement.parentElement.children[0]
            this.parentElement.parentElement.parentElement.parentElement.remove()
            console.log(image_id.value)
            // send === new === form === data === to === delete === image === from === database :
            var request_delete = new XMLHttpRequest()
            var id_delete = new FormData()
            id_delete.append('delete_id', image_id.value)
            this.disabled = true
            request_delete.onreadystatechange = function() {
              if (request_delete.readyState === 4 && request_delete.status === 200) {
                response_area.innerHTML = request_delete.responseText
                this.disabled = false
              }
            }
            request_delete.open('POST', 'response.php')
            request_delete.send(id_delete)

          }
          
          // save === changes === button === code === start :
          var save = document.getElementById('save-modification');
          save.onclick = function() {
            var file_input = document.getElementById('file2_modif')
            var nom_modifier = document.getElementById('edit-p-name')
            var prix_modifier = document.getElementById('edit-p-price')
            var quantity_modifier = document.getElementById('edit-p-quantity')
            var description_modifier = document.getElementById('edit-p-description')
            var promo_modifier = document.getElementById('edit-p-promotion-rate')
            var date_modifier = document.getElementById('edit-p-promotion-date')
            var id_produit_modifier = document.getElementById('p-modifiate-id')
            save.disabled = true
            save.innerHTML = `Saving...`
            var input_modification = new XMLHttpRequest()
            var fomr_inputs_modif = new FormData()
            for (var newImage of file_input.files) {
              fomr_inputs_modif.append('newimages[]', newImage)
            }
            var infos_modification = [nom_modifier.value, prix_modifier.value, quantity_modifier.value, description_modifier.value, promo_modifier.value, id_produit_modifier.value, date_modifier.value]
            fomr_inputs_modif.append('modifcation', infos_modification)
            input_modification.onreadystatechange = function() {
              if (input_modification.readyState === 4 && input_modification.status === 200) {
                response_area.innerHTML = input_modification.responseText
                save.disabled = false
                save.innerHTML = "Save changes"
                file_input.value = null
                preview.innerHTML = ""
                show.classList = "row mt-4 mb-4 p-2 d-none"
              }
            }

            input_modification.open('POST', 'response.php')
            input_modification.send(fomr_inputs_modif)

          }
          // next
        }

      }
      edit_request.open('POST', 'response.php')
      edit_request.send(edit_form)
    })
  })
  // delete == product == code == start :
  var btn_dells = document.querySelectorAll('#btn_delete')
  var product_infos = document.getElementById('product_infos')
  var delete_p_id = document.getElementById('delete-p-id')
  var btn_delation = document.getElementById('delation')
  var remove_parent;
  btn_dells.forEach(dell => {
    dell.addEventListener('click', function() {
      remove_parent = this.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement;
      var product_deleted_name = this.parentElement.parentElement.children[0].value;
      var product_deleted_id = this.parentElement.parentElement.children[1].value;
      product_infos.innerHTML = `
       <h5 class="text-danger text-center">You want really delete this product ?</h5>
        <div  class="text-center text-success lead fs-4">${product_deleted_name}</div>`;
      delete_p_id.value = product_deleted_id;
      btn_delation.style.display = "block"
    })
  })
  // confirme delete : 

  btn_delation.onclick = function() {
    // send == confirmation == request == code == start :
    btn_delation.disabled = true
    var confirmation_request = new XMLHttpRequest()
    var confirmation_form = new FormData()
    confirmation_form.append('confirmation', delete_p_id.value)
    product_infos.innerHTML = `
        <div class="d-flex justify-content-center">
  <div class="spinner-border spinner-border-lg text-success me-3" role="status">
    <span class="visually-hidden">Loading...</span>
  </div> Please wait...
</div>
`
    confirmation_request.onreadystatechange = function() {
      if (confirmation_request.readyState === 4 && confirmation_request.status === 200) {
        product_infos.innerHTML = confirmation_request.responseText
        btn_delation.disabled = false
        remove_parent.remove()
        btn_delation.style.display = "none"
      }
    }
    confirmation_request.open('POST', 'response.php')
    confirmation_request.send(confirmation_form)
  }

  // +++ delete +++ client --- code ___ start : 
  var remove_client_btn = document.getElementById('remove-client-btn');
  var delete_clients = document.querySelectorAll('#delete-client');
  var client_infos_area = document.getElementById('client_infos')
  var client_id_input = document.getElementById('client-id')
  delete_clients.forEach(client => {
    client.addEventListener('click', removeClient);
  })
  var remove_client_parent;

  function removeClient() {
    var client_name = this.parentElement.parentElement.parentElement.children[1];
    var client_id = this.parentElement.parentElement.parentElement.children[0];
    remove_client_parent = this.parentElement.parentElement.parentElement.parentElement.parentElement;
    console.log(remove_client_parent)
    client_infos_area.innerHTML = `
       <h5 class="text-danger text-center">You want really delete this client ?</h5>
        <div  class="text-center text-success lead fs-4">${client_name.value} || ${client_id.value}</div>`;
    client_id_input.value = client_id.value;
    remove_client_btn.style.display = "block"
  }
  // send delete --- cient --- confirmation :
  remove_client_btn.onclick = function() {
    // send == confirmation == request === delete === client == code == start :
    remove_client_btn.disabled = true
    var confirmation_delete_client_request = new XMLHttpRequest()
    var confirmation_delete_client_form = new FormData()
    confirmation_delete_client_form.append('client-delete', client_id_input.value)
    client_infos_area.innerHTML = `
        <div class="d-flex justify-content-center">
  <div class="spinner-border spinner-border-lg text-success me-3" role="status">
    <span class="visually-hidden">Loading...</span>
  </div> Please wait...
</div>
`
    confirmation_delete_client_request.onreadystatechange = function() {
      if (confirmation_delete_client_request.readyState === 4 && confirmation_delete_client_request.status === 200) {
        client_infos_area.innerHTML = confirmation_delete_client_request.responseText
        remove_client_btn.disabled = false
        remove_client_parent.remove()
        remove_client_btn.style.display = "none"
      }
    }
    confirmation_delete_client_request.open('POST', 'response.php')
    confirmation_delete_client_request.send(confirmation_delete_client_form)
  }

  // admin log out btn :
  var admin_disconnect = document.getElementById('admin_disconnect');
  admin_disconnect.onclick = function() {
    admin_disconnect.disabled = true
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

  // view customers from  notifs :
  var views = document.querySelectorAll('#view')
  views.forEach(view => {
    view.addEventListener('click', function() {
      var customers_tab = document.getElementById('v-tabs-customers');
      customers_tab.click();
    })
  })
  // view orders from  notifs :
  var orders = document.querySelectorAll('#order')
  orders.forEach(order => {
    order.addEventListener('click', function() {
      var orders_tab = document.getElementById('v-tabs-orders');
      orders_tab.click();
    })
  })

  // Get order_details function start :
  var order_details = document.querySelectorAll('#order_details');
  var get_modal_details_btn = document.getElementById('get_modal_details');
  var order_modal_body = document.getElementById('order_place');
  order_details.forEach(detail => {
    detail.addEventListener('click', function() {
      var order_id = detail.parentElement.children[0];
      detail.innerHTML = `
  <span class="text-warning">Processing...</span>
  <div class="spinner-border spinner-border-sm text-warning" role="status"></div>`
      detail.style.pointerEvents = "none";
      var getOrderInfos = new XMLHttpRequest();
      var form_data = new FormData();
      form_data.append('order_id', order_id.value);
      getOrderInfos.onreadystatechange = function() {
        if (getOrderInfos.readyState === 4 && getOrderInfos.status === 200) {
          detail.innerHTML = "View Details"
          detail.style.pointerEvents = "all";
          order_modal_body.innerHTML = getOrderInfos.responseText;
          get_modal_details_btn.click();
        }
      }
      getOrderInfos.open('POST', 'response.php');
      getOrderInfos.send(form_data);
    })
  })
  // cancel order code start :
  var cancel_order = document.querySelectorAll('#cancel-order');
  var order_result = document.getElementById('order_result');
  cancel_order.forEach(cancel => {
    cancel.addEventListener('click', function() {
      var order_email = cancel.children[0];
      var order_id = cancel.children[1];
      var order_parent = cancel.parentElement.parentElement.parentElement.parentElement;
      // send cancel request :
      var cancel_request = new XMLHttpRequest();
      var cancel_form = new FormData();
      cancel.disabled = true;
      var order_infos = [order_email.value, order_id.value]
      cancel_form.append('cancel', order_infos);
      cancel_request.onreadystatechange = function() {
        if (cancel_request.readyState === 4 && cancel_request.status === 200) {
          cancel.disabled = false;
          order_result.innerHTML = cancel_request.responseText;
          order_parent.remove();
        }
      }
      cancel_request.open('POST', 'response.php');
      cancel_request.send(cancel_form);
    })
  })
  // orders area controls :
  setInterval(function() {
    var order_area = document.getElementById('orders_area');
    var orders_counter = document.getElementById('orders-counter');
    if (order_area.children.length === "6") {
      order_result.innerHTML = `<div class="alert alert-white text-dark fw-bold mt-3 text-center">No order requests available for now !</div>`
      orders_counter.classList="position-absolute mt-2 ms-3 translate-middle badge rounded-0 bg-warning d-none";
    } else if (order_area.children.length > 8) {
      orders_counter.classList = "position-absolute mt-2 ms-3 translate-middle badge rounded-2 bg-warning ";
      orders_counter.innerHTML = order_area.children.length - 7;
    } else {
      orders_counter.innerHTML = order_area.children.length - 6;
      orders_counter.classList = "position-absolute mt-2 ms-3 translate-middle badge rounded-2 bg-warning ";
    }
  }, 1000)

  // confirme order code start :
  var confirme_order = document.querySelectorAll('#confirme-order');
  var modal_confirme_body = document.getElementById('modal-confirme');
  var confirme_btn = document.getElementById('confirmation');
  confirme_order.forEach(confirme => {
    confirme.addEventListener('click', function() {
      confirme_btn.style.display = "block";
      modal_confirme_body.innerHTML = `
          <h5 class="text-danger  text-center">If accept this order :</h5> 
<p class="lead">1/ Quantity will be updating in stock</p>
<p class="lead">2/ Client will receive a confirmation E-mail</p>
          `
      var confirme_email = confirme.children[0];
      var confirme_parent = confirme.parentElement.parentElement.parentElement.children[1].children[0].children[0].getElementsByTagName('input');
      var parent_order = confirme.parentElement.parentElement.parentElement.parentElement;
      confirme_btn.onclick = function() {
        // send confirme request :
        var confirme_request = new XMLHttpRequest();
        var confirme_form = new FormData();
        confirme.disabled = true;
        confirme_form.append('email', confirme_email.value)
        for (var input of confirme_parent) {
          if (isNaN(input.value)) {
            confirme_form.append('names[]', input.value);
          } else {
            confirme_form.append('quantities[]', input.value);
          }
        }
        confirme_request.onreadystatechange = function() {
          if (confirme_request.readyState === 4 && confirme_request.status === 200) {
            confirme.disabled = false;
            modal_confirme_body.innerHTML = confirme_request.responseText;
            parent_order.remove();
            confirme_btn.style.display = "none"
          }
        }
        confirme_request.open('POST', 'response.php');
        confirme_request.send(confirme_form);
      }
    })
  })
  // filter orders code start :
  var orders_status = document.getElementById('order-status');
  var filter = document.getElementById('filter');
  orders_status.onchange = function() {
    if (orders_status.value === "null") {
      order_result.style.display = "block";
      filter.innerHTML = ""
    } else {
      var filter_request = new XMLHttpRequest();
      var filter_form = new FormData();
      filter_form.append('filter', orders_status.value);
      orders_status.disabled = true;
      filter_request.onreadystatechange = function() {
        if (filter_request.readyState === 4 && filter_request.status === 200) {
          orders_status.disabled = false;
          order_result.style.display = "none";
          filter.innerHTML = filter_request.responseText;
          // delete user from filter :
          var dell_filter = document.querySelectorAll('#dell_filter');
          dell_filter.forEach(dellFilter => {
            dellFilter.addEventListener('click', function() {
              var deleted_email = dellFilter.parentElement.children[0];
              var table_parent = dellFilter.parentElement.parentElement.parentElement.parentElement;
              var area = document.getElementById('lead');
              var dell_request = new XMLHttpRequest();
              var dell_form = new FormData();
              dell_form.append('delete_filter', deleted_email.value);
              dellFilter.disabled = true;
              dell_request.onreadystatechange = function() {
                if (dell_request.readyState === 4 && dell_request.status === 200) {
                  dellFilter.disabled = false;
                  area.innerHTML = dell_request.responseText;
                  table_parent.remove();
                }
              }
              dell_request.open('POST', 'response.php');
              dell_request.send(dell_form);
            })
          })
        }
      }
      filter_request.open('POST', 'response.php');
      filter_request.send(filter_form);
    }
  }
  // notifications counter code :
  var not = document.getElementById('notifs');
  var count = document.getElementById('count_notif');
  count.innerHTML = not.children.length - 1;
  // notifications counter code :
  var messg = document.getElementById('messg');
  var count_message = document.getElementById('count_message');
  count_message.innerHTML = messg.children.length - 1;
  // live content :
  // setInterval (function (){
  //   load = $('#loaded').load(location.href + "#loaded");
  // },1000)
</script>
<?php
include "includes/footer.php";
?>