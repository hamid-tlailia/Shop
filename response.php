<?php
// START OF CODE
include "includes/config.php";
// start with sign up code :
# admins array :
$admins = array(
  "admin1" => "tlailia757@gmail.com"
);
// check if user is admins or simple user :
try {
  if (isset($_POST['infos'])) {
    $infos_array = $_POST['infos'];
    $infos = explode(',', $infos_array);
    $admin_fname = $infos[0];
    $admin_lname = $infos[1];
    $admin_email = $infos[2];
    $admin_password = $infos[3];
    $vadlid_pass = md5($admin_password);
    $newslater_checkbox = $infos[4];
    // if admin : 
    if (in_array($admin_email, $admins)) {
      $insert_admin_infos = $db->prepare("INSERT INTO admins (email,firstname,lastname,admin_password,secret_word)
       VALUES('$admin_email','$admin_fname','$admin_lname','$vadlid_pass','tffmn986')");
      $insert_admin_infos->execute();
      if ($insert_admin_infos) {
?>
        <!-- Success Alert -->
        <div class="alert alert-success alert-dismissible fade show p-3 rounded-0">
          <strong>Congratulations Admin <span class="text-danger text-decoration-underline"><?php echo $admin_fname; ?></span> : </strong> Your account successfully created <a href="login.php"> Login</a>
          <button type="button" class="btn-close" data-mdb-dismiss="alert"></button>
        </div>
      <?php
      }
    } else {
      $insert_user_infos = $db->prepare("INSERT INTO users (email,firstname,lastname,client_password) 
VALUES('$admin_email','$admin_fname','$admin_lname','$vadlid_pass')");
      $insert_user_infos->execute();
      if ($insert_user_infos) {
      ?>
        <!-- Success Alert -->
        <div class="alert alert-success alert-dismissible fade show p-3 rounded-0">
          <strong>Congratulations <span class="text-danger text-decoration-underline"><?php echo $admin_fname; ?></span> : </strong> Your account successfully created <a href="login.php"> Login</a>
          <button type="button" class="btn-close" data-mdb-dismiss="alert"></button>
        </div>
  <?php
        // add user to newslater if newslater checkbox is checked :
        if ($newslater_checkbox === "checked") {
          $insert_newslater = $db->prepare("INSERT INTO newslater (email,firstname,lastname)
          VALUES('$admin_email','$admin_fname','$admin_lname')");
          $insert_newslater->execute();
        }
        // add new notifications :        
        $insert_notif = $db->prepare("INSERT INTO notifications (notif_type,user_firstname,user_lastname)
          VALUES('account','$admin_fname','$admin_lname')");
        $insert_notif->execute();
      }
    }
  }
} catch (Exception $e) {
  ?>
  <!-- Error Alert -->
  <div class="alert alert-danger alert-dismissible fade show p-3 rounded-0">
    <strong>NB: </strong> This account with email : <span class="text-warning text-decoration-underline"><?php echo $admin_email; ?></span> already exists <a href="login.php"> Login</a>
    <button type="button" class="btn-close" data-mdb-dismiss="alert"></button>
  </div>
  <?php
}

// get login infos to verifiate :
try {
  if (isset($_POST['login_infos'])) {
    $login_infos = $_POST['login_infos'];
    $logins = explode(',', $login_infos);
    $login_email = $logins[0];
    $login_password = $logins[1];
    $valid_login_pass = md5($login_password);
    if (in_array($login_email, $admins)) {
      $verifie_admin_login = $db->prepare("SELECT * FROM admins WHERE email='$login_email' and admin_password='$valid_login_pass'");
      $verifie_admin_login->execute();
      $admin_login_verification_result = $verifie_admin_login->fetch();
      if ($admin_login_verification_result) {
        // header("Location :admin-space.php");
        echo "admin";
        $_SESSION['admin'] = $login_email;
      } else {
        if ($verifie_admin_login->rowCount() === 0) {
  ?>
          <!-- Error Alert -->
          <div class="alert alert-danger alert-dismissible fade show p-3 rounded-0">
            <strong>NB: </strong> E-mail or password incorrect !
            <button type="button" class="btn-close" data-mdb-dismiss="alert"></button>
          </div>
        <?php
        }
      }
    } else {
      $verifie_client_login = $db->prepare("SELECT * FROM users WHERE email='$login_email' and client_password='$valid_login_pass'");
      $verifie_client_login->execute();
      $client_login_verification_result = $verifie_client_login->fetch();
      if ($client_login_verification_result) {
        echo "client";
        $_SESSION['client'] = $login_email;
      } else {
        if ($verifie_client_login->rowCount() === 0) {
        ?>
          <!-- Error Alert -->
          <div class="alert alert-danger alert-dismissible fade show p-3 rounded-0">
            <strong>NB: </strong> E-mail or password incorrect !
            <button type="button" class="btn-close" data-mdb-dismiss="alert"></button>
          </div>
  <?php
        }
      }
    }
  }
} catch (Exception $e) {
  ?>
  <!-- Error Alert -->
  <div class="alert alert-danger alert-dismissible fade show p-3 rounded-0">
    <strong>NB: </strong> Something went wrong , please contact us : <a href="tel:94143166">+216 94 143 166</a>
    <button type="button" class="btn-close" data-mdb-dismiss="alert"></button>
  </div>
<?php
}

// log out btn :
try {
  if (isset($_POST['log'])) {
    session_destroy();
  }
} catch (Exception $e) {
?>
  <!-- Error Alert -->
  <div class="alert alert-danger alert-dismissible fade show p-0 rounded-0">
    <strong>NB :</strong> Something went wrong , please contact the support number : <a href="tel:94143166">+216 94 143 166</a>
    <button type="button" class="btn-close" data-mdb-dismiss="alert"></button>
  </div>
  <?php
}

// add new product code start :
try {
  if (isset($_POST['details']) && isset($_FILES['product_images'])) {
    $product_details = $_POST['details'];
    $details = explode(',', $product_details);
    $product_name = $details[0];
    $product_price = $details[1];
    $product_quantity = $details[2];
    $product_description = $details[3];
    $valid_description = filter_var($product_description, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $product_promotion_rate = $details[4];
    $product_promotion_date = $details[5];
    $product_images_name = $_FILES['product_images']['name'];
    $product_images_tmp_name = $_FILES['product_images']['tmp_name'];
    $dir = "images/product-images/";

    // insert product infos :
    $insert_product_infos = $db->prepare("INSERT INTO products (product_name,product_price,product_quantity,product_description,product_disponibity,product_promotion_rate,product_promotion_end)
    VALUES('$product_name','$product_price','$product_quantity','$valid_description','disponible','$product_promotion_rate','$product_promotion_date')");
    $insert_product_infos->execute();
    if ($insert_product_infos) {
      // insert === product === associative === images === to === database :
      $get_id = $db->prepare("SELECT * FROM products ORDER BY product_publish_date DESC LIMIT 1");
      $get_id->execute();
      $result_id = $get_id->fetch();
      $current_id = $result_id['product_id'];
      for ($d = 0; $d < count($product_images_name); $d++) {
        // upload === images === to === the server :
        $images_random_name = rand();
        move_uploaded_file($product_images_tmp_name[$d], $dir . $images_random_name . $product_images_name[$d]);
        $insert_p_images = $db->prepare("INSERT INTO product_images(product_id,image_name,image_src)
VALUES('$current_id','$images_random_name','$product_images_name[$d]')");
        $insert_p_images->execute();
      }
  ?>
      <!-- Success Alert -->
      <div class="alert alert-success alert-dismissible fade show fs-6">
        <strong>Congratulations : </strong> Product successfully published !
        <button type="button" class="btn-close" data-mdb-dismiss="alert"></button>
      </div>
  <?php
    }
  }
} catch (Exception $e) {
  ?>
  <!-- Error Alert -->
  <div class="alert alert-danger alert-dismissible fade show fs-6">
    <strong>NB : </strong> Something went wrong , please contact us : <a href="tel:94143166"> +216 94 143 166</a>
    <button type="button" class="btn-close" data-mdb-dismiss="alert"></button>
  </div>
  <?php
}

// get modifiate product infos :
try {

  if (isset($_POST['modifiateID'])) {
    $id = $_POST['modifiateID'];
    $get_modifiate_infos = $db->prepare("SELECT * FROM products WHERE product_id='$id'");
    $get_modifiate_infos->execute();
    $modifications = $get_modifiate_infos->fetch();
    if ($modifications) {
      $product_id = $modifications['product_id'];
      $product_name = $modifications['product_name'];
      $product_price = $modifications['product_price'];
      $product_quantity = $modifications['product_quantity'];
      $product_description = $modifications['product_description'];
      $product_disponibity = $modifications['product_disponibity'];
      $product_promotion_rate = $modifications['product_promotion_rate'];
      $product_promotion_end = $modifications['product_promotion_end'];
  ?>
      <form class="p-3 rounded-0" id="edit-product-form">
        <!-- 2 column +++ grid +++ layout +++ with +++ text +++ inputs +++ for +++ the +++ first +++ and +++ last +++ names -->
        <div class="row mb-4 ">
          <div class="col-12 col-lg-6">

            <div class="form-floating mb-3">
              <input type="text" class="form-control" id="edit-p-name" value="<?php echo $product_name; ?>" placeholder="name@example.com">
              <label for="edit-p-name">Product name</label>
            </div>
            <input type="hidden" value="<?php echo $product_id;  ?>" id="p-modifiate-id">
          </div>
          <div class="col-12 col-lg-6">
            <div class="form-floating mb-3">
              <input type="number" class="form-control" id="edit-p-price" value="<?php echo $product_price; ?>" placeholder="name@example.com">
              <label for="edit-p-price">Product price</label>
            </div>
          </div>
        </div>

        <!-- qt input -->

        <div class="form-floating mb-3">
          <input type="number" class="form-control" id="edit-p-quantity" value="<?php echo $product_quantity; ?>" placeholder="name@example.com">
          <label for="edit-p-quantity">Product quantity</label>
        </div>
        </div>
        <hr>
        <!-- images area -->
        <div class="col-12 mt-3 mb-3">
          <p class="lead text-success p-2 text-start mb-1 fs-6">Product images :</p>
          <div class="row gap-3 p-3">
            <?php
            // get == associative == images == from == server == code == start :
            $modifiate_product_images = $db->prepare("SELECT * FROM product_images WHERE product_id='$product_id'");
            $modifiate_product_images->execute();
            while ($result_modifiate_product_images = $modifiate_product_images->fetch()) {
              if ($result_modifiate_product_images) {
                $image_modifiate_product_id = $result_modifiate_product_images['image_id'];
                $image_modifiate_name = $result_modifiate_product_images['image_name'];
                $image_modifiate_product_productID = $result_modifiate_product_images['product_id'];
                $image_modifiate_product_src = $result_modifiate_product_images['image_src'];
            ?>
                <div class="col-sm-12 col-md-2 col-lg-3  border border-success">
                  <div class="row">
                    <div class="col-12 text-end mb-3">
                      <input type="hidden" value="<?php echo $image_modifiate_product_id;  ?>">
                      <span class=" bg-transparent"><button class="btn btn-white  shadow-1-strong text-danger btn-floating fs-6" type="button" id="delete_image" style="margin-top: -2vh;margin-left:7vh !important">X</button></span>
                    </div>
                    <img src="<?php echo "images/product-images/" . $image_modifiate_name . $image_modifiate_product_src;  ?>" class="img-fluid rounded " width="150" height="150" alt="image">
                  </div>
                </div>
            <?php
              }
            }
            ?>
            <div class="col-2  p-2 ms-3">
              <div class="row text-center align-items-center">
                <div class="col-12 text-center p-0 w-100"><label for="file2_modif" class="form-label plus"><i class="far fa-images" style="cursor: pointer"></i> Ajouter</label></div>
                <input type="file" class="d-none" id="file2_modif" multiple>
              </div>
            </div>
          </div>
        </div>
        <!-- show images area -->
        <hr>
        <div class="row mt-4 mb-4 p-2 gap-2 d-none" id="show">
          <div class="row mb-4">
            <input type="hidden" value="<?php echo $image_modifiate_product_productID; ?>" id="product_id">
            <div class="col-8 text-start">
              <p class="text-success mb-4 lead fs-6">See images before add :</p>
            </div>
            <div class="col-4 mb-4">
              <button class="btn btn-white shadow-1-strong text-danger " type="button" id="console">Cancel</button>
            </div>
            <hr>
            <div class="row mt-2" id="preview"></div>
          </div>
        </div>
        <!-- description input -->
        <div class="form-floating mb-3">
          <textarea class="form-control" placeholder="Leave a comment here" id="edit-p-description" style="height: 100px"><?php echo $product_description; ?></textarea>
          <label for="edit-p-description">Descrription</label>
        </div>
        <!-- with promotion area -->
        <div class="row mb-4 ">
          <p id="date-retard"></p>
          <div class="col-12 col-lg-6">
            <div class="form-floating mb-3">
              <input type="number" class="form-control" id="edit-p-promotion-rate" value="<?php echo $product_promotion_rate; ?>" placeholder="name@example.com">
              <label for="edit-p-promotion-rate">Product promotion</label>
            </div>
          </div>

          <div class="col-12 col-lg-6">

            <div class="form-floating mb-3">
              <input type="date" class="form-control" id="edit-p-promotion-date" value="<?php echo $product_promotion_end; ?>" placeholder="name@example.com">
              <label for="edit-p-promotion-date">Promotion date</label>
            </div>
          </div>
        </div>
      </form>
    <?php
    }
  }
} catch (Exception $e) {
  die("error : " . $e->getMessage());
}


// delete === product === images === code === start :
try {
  if (isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];
    $get_image_name = $db->prepare("SELECT * FROM product_images WHERE image_id='$delete_id'");
    $get_image_name->execute();
    $get_image_current_name = $get_image_name->fetch();
    $image_src = $get_image_current_name['image_src'];
    $image_name = $get_image_current_name['image_name'];
    $folder = 'images/product-images/' . $image_name . $image_src;
    $delete_product_image_request = $db->prepare("DELETE FROM product_images WHERE image_id='$delete_id'");
    $delete_product_image_request->execute();
    if ($delete_product_image_request) {
      if (file_exists($folder)) {
        unlink($folder);
      }
    ?>
      <!-- Error Alert -->
      <div class="alert alert-success alert-dismissible rounded-0 fade show fs-6">
        <strong>Congratulations : </strong> Image successfully deleted
        <button type="button" class="btn-close" data-mdb-dismiss="alert"></button>
      </div>
    <?php
    } else {
    ?>
      <!-- Error Alert -->
      <div class="alert alert-danger alert-dismissible fade show fs-6">
        <strong>NB : </strong> Something went wrong , please contact us : <a href="tel:94143166"> +216 94 143 166</a>
        <button type="button" class="btn-close" data-mdb-dismiss="alert"></button>
      </div>
  <?php
    }
  }
} catch (Exception $e) {
  ?>
  <!-- Error Alert -->
  <div class="alert alert-danger alert-dismissible fade show fs-6">
    <strong>NB : </strong> Something went wrong , please contact us : <a href="tel:94143166"> +216 94 143 166</a>
    <button type="button" class="btn-close" data-mdb-dismiss="alert"></button>
  </div>
  <?php
}
// product === modification === code === start :

try {
  // begin === with === inputs === modifications === only :
  if (isset($_POST['modifcation'])) {
    $modification = $_POST['modifcation'];

    // all = product == infos :
    $array_infos = explode(',', $modification);
    $nom_p_modifier = $array_infos[0];
    $prix_p_modifier = $array_infos[1];
    $qt_p_modifier = $array_infos[2];
    $desc_p_modifier = $array_infos[3];
    $good_desc_p_modifier = filter_var($desc_p_modifier, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $promo_p_modifier = $array_infos[4];
    $id_p_modifier = $array_infos[5];
    $date_p_modifier = $array_infos[6];
    // check === if === there === is === new === added === images :
    if (isset($_FILES['newimages'])) {
      // starting == global === update === infos + images :
      $new_images_name = $_FILES['newimages']['name'];
      $new_images_tmp_name = $_FILES['newimages']['tmp_name'];
      $global_update = $db->prepare("UPDATE products SET 
        product_name = '$nom_p_modifier' ,
        product_price ='$prix_p_modifier',
        product_quantity ='$qt_p_modifier',
        product_description ='$good_desc_p_modifier',
        product_promotion_rate ='$promo_p_modifier',
        product_promotion_end ='$date_p_modifier'
        WHERE product_id='$id_p_modifier'
        ");
      $global_update->execute();
      if ($global_update) {
        // define === folder :
        $dir = "images/product-images/";
        // inserting === images === after === inserting === infos + move === uploaded === files === to images folder :
        $images_random_name = rand();
        for ($i = 0; $i < count($new_images_name); $i++) {
          move_uploaded_file($new_images_tmp_name[$i], $dir . $images_random_name . $new_images_name[$i]);
          $insert_updated_product_images = $db->prepare("INSERT INTO product_images (product_id,image_name,image_src)
      VALUES('$id_p_modifier','$images_random_name','$new_images_name[$i]')");
          $insert_updated_product_images->execute();
        }
  ?>
        <!-- Error Alert -->
        <div class="alert alert-success alert-dismissible fade show rounded-0 fs-6">
          <strong>Congratulations : </strong> Product successfully updated in <?php echo date("d:m:Y"); ?>
          <button type="button" class="btn-close" data-mdb-dismiss="alert"></button>
        </div>
      <?php
      }
    } else {
      // starting == minimize === update === infos only :
      $minimize_update = $db->prepare("UPDATE products SET 
        product_name = '$nom_p_modifier' ,
        product_price ='$prix_p_modifier',
        product_quantity ='$qt_p_modifier',
        product_description ='$good_desc_p_modifier',
        product_promotion_rate ='$promo_p_modifier',
        product_promotion_end ='$date_p_modifier'
        WHERE product_id='$id_p_modifier'
        ");
      $minimize_update->execute();
      if ($minimize_update) {
      ?>
        <!-- Success Alert -->
        <div class="alert alert-success alert-dismissible fade rounded-0 show fs-6">
          <strong>Congratulations : </strong> Product successfully updated in <?php echo  date("d:m:Y"); ?>
          <button type="button" class="btn-close" data-mdb-dismiss="alert"></button>
        </div>
      <?php
      }
    }
  }
} catch (Exception $e) {
  die("Error :" . $e->getMessage());
}

// delete === product === code === start ^_^
try {
  if (isset($_POST['confirmation'])) {
    $confirm_id = $_POST['confirmation'];
    $dell_product = $db->prepare("DELETE FROM products WHERE product_id='$confirm_id'");
    $dell_product->execute();
    if ($dell_product) {
      // delete == images == from == db == after == delete == product :
      $select_images = $db->prepare("SELECT * FROM product_images WHERE product_id='$confirm_id'");
      $select_images->execute();
      while ($currnet_product_images = $select_images->fetch()) {
        if ($currnet_product_images) {
          // delete == images == from == folder == after == delete == product :
          $current_src = $currnet_product_images['image_src'];
          $current_name = $currnet_product_images['image_name'];
          $directory = "images/product-images/" . $current_name . $current_src;
          if (file_exists($directory)) {
            unlink($directory);
          }
          // delete == from == db :
          $dell_images = $db->prepare("DELETE FROM product_images WHERE product_id='$confirm_id'");
          $dell_images->execute();
        }
      }
      ?>
      <div class="text-center">
        <i class="far fa-check-circle text-success fa-4x"></i> </br>
        <h4 class='text-success'> Product successufully removed ! </h4>
      </div>
      <?php
    }
  }
} catch (Exception $e) {
  die("Error :" . $e->getMessage());
}
// delete === client === code === start ^_^
try {
  if (isset($_POST['client-delete'])) {
    $client_id = $_POST['client-delete'];
    $dell_client = $db->prepare("DELETE FROM users WHERE email='$client_id'");
    $dell_client->execute();
    if ($dell_client) {

      // delete client from newslater :
      $dell_newslater = $db->prepare("DELETE FROM newslater WHERE email='$client_id'");
      $dell_newslater->execute();
      if ($dell_newslater) {
      ?>
        <div class="text-center">
          <i class="far fa-check-circle text-success fa-4x"></i> </br>
          <h4 class='text-success'> Client successufully removed ! </h4>
        </div>
      <?php
        // unset session client :
        unset($_SESSION['client']);
      }
    }
  }
} catch (Exception $e) {
  die("Error :" . $e->getMessage());
}

// edit user profile code start :
try {
  if (isset($_POST['edit_profile_infos'])) {
    $profile_infos = $_POST['edit_profile_infos'];
    $user_infos = explode(',', $profile_infos);
    $user_fname = $user_infos[0];
    $user_lname = $user_infos[1];
    $user_address = $user_infos[2];
    $user_email = $user_infos[3];
    $user_phone = $user_infos[4];
    if (strlen($user_address) < 6) {
      ?>
      <!-- Error Alert -->
      <div class="alert alert-danger alert-dismissible fade rounded-0 show fs-6">
        <strong>NB : Address must be more than 6 characters </strong>
        <button type="button" class="btn-close" data-mdb-dismiss="alert"></button>
      </div>
    <?php
    } else if (strlen($user_phone) < 8) {
    ?>
      <!-- Error Alert -->
      <div class="alert alert-danger alert-dismissible fade rounded-0 show fs-6">
        <strong>NB : Phone number must be more or equal than 8 characters </strong>
        <button type="button" class="btn-close" data-mdb-dismiss="alert"></button>
      </div>
      <?php
    } else {
      // update user infos :
      $updates_user_infos = $db->prepare("UPDATE users SET 
  email ='$user_email',
  firstname = '$user_fname',
  lastname = '$user_lname',
  client_phone = '$user_phone',
  client_address = '$user_address'
  WHERE email = '$user_email'
  ");
      $updates_user_infos->execute();
      if ($updates_user_infos) {

      ?>
        <!-- Success Alert -->
        <div class="alert alert-success alert-dismissible fade rounded-0 show fs-6">
          <strong>Congratulations : </strong> Your profile suucessfully updated
          <button type="button" class="btn-close" data-mdb-dismiss="alert"></button>
        </div>
      <?php
      }
    }
  }
} catch (Exception $e) {
  die("Error : " . $e->getMessage());
}

# add _^^_ to _^^_ cart _^^_ btn _^^_ funtion :
try {
  if (isset($_POST['add_cart'])) {
    $cart_id = $_POST['cart_id'];
    $page_url = $_POST['page'];
    // search product id from db :
    $Get_product = $db->prepare("SELECT * FROM products WHERE product_id = '$cart_id'");
    $Get_product->execute();
    $addedd_product = $Get_product->fetch();
    if ($addedd_product) {
      $product_name = $addedd_product['product_name'];
      $product_price = $addedd_product['product_price'];
      $product_quantity = $addedd_product['product_quantity'];
      $product_description = $addedd_product['product_description'];
      $product_disponibity = $addedd_product['product_disponibity'];
      $product_promotion_rate = $addedd_product['product_promotion_rate'];
      $product_promotion_end = $addedd_product['product_promotion_end'];
      // get product images :
      $product_cart_images = $db->prepare("SELECT * FROM product_images WHERE product_id ='$cart_id' LIMIT 1");
      $product_cart_images->execute();
      $img = $product_cart_images->fetch();

      $image_id = $img['image_id'];
      $image_name = $img['image_name'];
      $image_src = $img['image_src'];
      ?> <script>
        window.location = "<?php echo $page_url; ?>"
      </script> <?php
              }
              // check and create session :
              if (isset($_SESSION['cart'])) {
                $check_id = array_column($_SESSION['cart'], 'id');
                if (in_array($cart_id, $check_id)) {
                  // echo "product already exists";
                  $shipping = $product_price - ($product_price * ($product_promotion_rate / 100));
                  $_SESSION['added'] = "<div class='alert alert-danger alert-dismissible fade rounded-0 show fs-6'>
                     <strong>NB : </strong> Product already exists in your cart <a href='cart.php'> update cart </a>
                     <button type='button' class='btn-close' data-mdb-dismiss='alert'></button>
                 </div>";
                  $_SESSION['timer'] = time();
                } else {
                  $_SESSION['cart'][] = array(
                    'id' => $cart_id,
                    'name' => $product_name,
                    'description' => $product_description,
                    'qty' => 1,
                    'price' => $product_price - ($product_price * ($product_promotion_rate / 100)),
                    'promotion' => $product_promotion_rate,
                    'date' => $product_promotion_end,
                    'image_src' => $image_src,
                    'image_name' => $image_name
                  );
                  $shipping = $product_price - ($product_price * ($product_promotion_rate / 100));
                  $_SESSION['added'] = "<div class='alert alert-success alert-dismissible fade rounded-0 show fs-6'>
                    <strong>Congratulations :  Product <span class='text-danger'>$product_name </span> <span class='text-warning'>[ $product_description ] </span> <span class='text-secondary'>[ $shipping TND ] </span>  successfully added to your cart </strong>
                    <button type='button' class='btn-close' data-mdb-dismiss='alert'></button>
                </div>";
                  $_SESSION['timer'] = time();
                }
              } else {
                $_SESSION['cart'][] = array(
                  'id' => $cart_id,
                  'name' => $product_name,
                  'description' => $product_description,
                  'qty' => 1,
                  'price' => $product_price - ($product_price * ($product_promotion_rate / 100)),
                  'promotion' => $product_promotion_rate,
                  'date' => $product_promotion_end,
                  'image_src' => $image_src,
                  'image_name' => $image_name
                );

                $_SESSION['added'] = "<div class='alert alert-success alert-dismissible fade rounded-0 show fs-6'>
                  <strong>Congratulations :  Product <span class='text-danger'>$product_name </span> <span class='text-warning'>[ $product_description ] </span> <span class='text-secondary'>[ $shipping TND ] </span>  successfully added to your cart </strong>
                  <button type='button' class='btn-close' data-mdb-dismiss='alert'></button>
              </div>";
                $_SESSION['timer'] = time();
              }
            }
          } catch (Exception $e) {
            die("Error : " . $e->getMessage());
          }
          // unset == item == from == cart == code == start :
          try {
            if (isset($_POST['dell'])) {
              $redirect_url = $_POST['redirect'];
              foreach ($_SESSION['cart'] as $k => $v) {
                if ($v['id'] == $_POST['unset_id']) {
                  unset($_SESSION['cart'][$k]);
                  $_SESSION['cart'] = array_values($_SESSION['cart']);
                  $_SESSION['removed'] = "<div class='alert alert-success alert-dismissible fade rounded-0 show fs-6'>
        <strong>Congratulations : </strong> Product successfully removed from your cart
        <button type='button' class='btn-close' data-mdb-dismiss='alert'></button>
    </div>";
                  $_SESSION['timer'] = time();
                }
              }
                ?> <script>
      window.location = "<?php echo $redirect_url; ?>"
    </script> <?php
            }
          } catch (Exception $e) {
            die("Error :" . $e->getMessage());
          }

          // update carte quantity plus code start :
          try {
            if (isset($_POST['plus'])) {
              $updated_id = $_POST['id'];
              $updated_quantity = $_POST['quantity'];
              // search product id from db :
              $Get_product = $db->prepare("SELECT * FROM products WHERE product_id = '$updated_id'");
              $Get_product->execute();
              $addedd_product = $Get_product->fetch();
              if ($addedd_product) {
                $product_name = $addedd_product['product_name'];
                $product_price = $addedd_product['product_price'];
                $product_quantity = $addedd_product['product_quantity'];
                $product_description = $addedd_product['product_description'];
                $product_disponibity = $addedd_product['product_disponibity'];
                $product_promotion_rate = $addedd_product['product_promotion_rate'];
                $product_promotion_end = $addedd_product['product_promotion_end'];
                // get product images :
                $product_cart_images = $db->prepare("SELECT * FROM product_images WHERE product_id ='$updated_id' LIMIT 1");
                $product_cart_images->execute();
                $img = $product_cart_images->fetch();

                $image_id = $img['image_id'];
                $image_name = $img['image_name'];
                $image_src = $img['image_src'];
              ?> <script>
        window.location = "cart.php"
      </script> <?php
              }
              if (isset($_SESSION['cart'])) {
                foreach ($_SESSION['cart'] as $key => $value) {
                  if ($value['id'] === $updated_id) {
                    if ($value['qty'] < $product_quantity) {
                      $_SESSION['cart'][$key] = array(
                        'id' => $updated_id,
                        'name' => $product_name,
                        'description' => $product_description,
                        'qty' => $updated_quantity + 1,
                        'price' => $product_price - ($product_price * ($product_promotion_rate / 100)),
                        'promotion' => $product_promotion_rate,
                        'date' => $product_promotion_end,
                        'image_src' => $image_src,
                        'image_name' => $image_name
                      );
                      $_SESSION['update'] = "<div class='alert alert-success alert-dismissible fade rounded-0 show fs-6'>
        <strong>Congratulations : </strong> Product quantity successfully updated 
        <button type='button' class='btn-close' data-mdb-dismiss='alert'></button>
    </div>";
                      $_SESSION['timer'] = time();
                    } else if ($product_quantity == $value['qty']) {
                      $_SESSION['max'] = "<div class='alert alert-danger alert-dismissible fade rounded-0 show fs-6'>
        <strong>NB : </strong> Sorry ! you have reached the max quantity 
        <button type='button' class='btn-close' data-mdb-dismiss='alert'></button>
    </div>";
                      $_SESSION['timer'] = time();
                    }
                  }
                }
              }
            }
          } catch (Exception $e) {
            die("Error :" . $e->getMessage());
          }
          // update carte quantity mince code start :
          try {
            if (isset($_POST['mince'])) {
              $updated_id = $_POST['id'];
              $updated_quantity = $_POST['quantity'];
              // search product id from db :
              $Get_product = $db->prepare("SELECT * FROM products WHERE product_id = '$updated_id'");
              $Get_product->execute();
              $addedd_product = $Get_product->fetch();
              if ($addedd_product) {
                $product_name = $addedd_product['product_name'];
                $product_price = $addedd_product['product_price'];
                $product_quantity = $addedd_product['product_quantity'];
                $product_description = $addedd_product['product_description'];
                $product_disponibity = $addedd_product['product_disponibity'];
                $product_promotion_rate = $addedd_product['product_promotion_rate'];
                $product_promotion_end = $addedd_product['product_promotion_end'];
                // get product images :
                $product_cart_images = $db->prepare("SELECT * FROM product_images WHERE product_id ='$updated_id' LIMIT 1");
                $product_cart_images->execute();
                $img = $product_cart_images->fetch();

                $image_id = $img['image_id'];
                $image_name = $img['image_name'];
                $image_src = $img['image_src'];
                ?> <script>
        window.location = "cart.php"
      </script> <?php
              }
              if (isset($_SESSION['cart'])) {
                foreach ($_SESSION['cart'] as $key => $value) {
                  if ($value['id'] === $updated_id) {
                    if ($value['qty'] > 1) {
                      $_SESSION['cart'][$key] = array(
                        'id' => $updated_id,
                        'name' => $product_name,
                        'description' => $product_description,
                        'qty' => $updated_quantity - 1,
                        'price' => $product_price - ($product_price * ($product_promotion_rate / 100)),
                        'promotion' => $product_promotion_rate,
                        'date' => $product_promotion_end,
                        'image_src' => $image_src,
                        'image_name' => $image_name
                      );
                      $_SESSION['update'] = "<div class='alert alert-success alert-dismissible fade rounded-0 show fs-6'>
            <strong>Congratulations : </strong> Product quantity successfully updated 
            <button type='button' class='btn-close' data-mdb-dismiss='alert'></button>
        </div>";
                      $_SESSION['timer'] = time();
                    } else if ($value['qty'] == 1) {
                      $_SESSION['max'] = "<div class='alert alert-danger alert-dismissible fade rounded-0 show fs-6'>
            <strong>NB : </strong> Sorry ! you have reached the min quantity 
            <button type='button' class='btn-close' data-mdb-dismiss='alert'></button>
        </div>";
                      $_SESSION['timer'] = time();
                    }
                  }
                }
              }
            }
          } catch (Exception $e) {
            die("Error :" . $e->getMessage());
          }

          // send oreder and mail :
          // get includes
          use PHPMailer\PHPMailer\PHPMailer;
          use PHPMailer\PHPMailer\Exception;

          require 'includes/Exception.php';
          require 'includes/PHPMailer.php';
          require 'includes/SMTP.php';


          if (isset($_POST['checkout_infos'])) {
            $checkout_infos = $_POST['checkout_infos'];
            $checkout = explode(',', $checkout_infos);
            $checkout_fname = $checkout[0];
            $checkout_lname = $checkout[1];
            $checkout_addresse = $checkout[2];
            $checkout_email = $checkout[3];
            $checkout_phone = $checkout[4];
            $checkout_add_infos = $checkout[5];
            $checkout_total = $checkout[6];
            $checkout_zip_code = $checkout[7];
            // random id :
            $random_id = rand();
            // check session :
            if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
              // check if user have in progress order :
              $check_order = $db->prepare("SELECT * FROM users_order_infos WHERE user_email='$checkout_email'");
              $check_order->execute();
              $userOrder = $check_order->fetch();
              if ($userOrder) {
                ?>
      <div class="alert alert-light rounded-0 p-3 fs-4 text-center text-danger fw-bold">
        <span><i class="fas fa-exclamation-circle fa-3x mb-2"></i></span> <br>
        <span class="lead fs-4">Sorry you have already an order in progress , please wait unitil order delivred </span>
      </div>
      <?php
              } else {

                // add user-order-info to db :
                $order_user_infos = $db->prepare("INSERT INTO users_order_infos(user_email,user_firstname,user_lastname,user_addresse,zip_code,user_phone,additional_infos,order_status)
  VALUES('$checkout_email','$checkout_fname','$checkout_lname','$checkout_addresse','$checkout_zip_code','$checkout_phone','$checkout_add_infos','in progress')");
                $order_user_infos->execute();
                if ($order_user_infos) {

      ?>
        <div class="alert alert-light rounded-0 p-3 text-center text-success fw-bold">
          <span><i class="fas fa-check-circle fa-3x mb-2"></i></span> <br>
          <span class="lead fs-4">Thank you dear client , we hove successfully receive your order</span>
        </div>
    <?php
                  // add new notifications :        
                  $insert_notif = $db->prepare("INSERT INTO notifications (notif_type,user_firstname,user_lastname)
        VALUES('order','$checkout_fname','$checkout_lname')");
                  $insert_notif->execute();
                  // get session cart infos :
                  $total = 0;
                  $g_total = 0;
                  foreach ($_SESSION['cart'] as $name => $title) {
                    $total = $title['price'] * $title['qty'];
                    $g_total += $total = $title['price'] * $title['qty'];
                    $this_name = $title['name'];
                    $this_quanity = $title['qty'];
                    // insert order details in order infos db :
                    $insert_details = $db->prepare("INSERT INTO order_infos(order_id,user_email,order_products_name,order_products_quantity,product_total,total)
      VALUES('$random_id','$checkout_email','$this_name','$this_quanity','$total','$checkout_total')");
                    $insert_details->execute();
                    unset($_SESSION['cart']);
                  }
                }
              }
            } else {
    ?>
    <div class="alert alert-light rounded-0 p-3 text-center text-danger fw-bold">
      <span><i class="fas fa-exclamation-circle fa-3x mb-2"></i></span> <br>
      <span class="lead fs-4">Your cart is empty , please add products to continue your order</span>
    </div>
    <?php
            }
          }

          // view order details btn start :
          try {
            if (isset($_POST['order_id'])) {
              $order_id = $_POST['order_id'];
              // get order_user :
              $order_user = $db->prepare("SELECT * FROM users_order_infos WHERE user_email ='$order_id'");
              $order_user->execute();
              $user = $order_user->fetch();
              if ($user) {
                $order_email = $user['user_email'];
                $order_fname = $user['user_firstname'];
                $order_lname = $user['user_lastname'];
                $order_addresse = $user['user_addresse'];
                $order_zip_code = $user['zip_code'];
                $order_phone = $user['user_phone'];
                $order_infos_add = $user['additional_infos'];
                $order_date = $user['order_date'];
    ?>
      <div class="row text-white p-3">
        <div class="col-lg-4 shadow-5-strong border rounded-0 p-3 text-center"><span class="text-warning fw-bold">Client E-mail :</span> <br> <?php echo $order_email; ?></div>
        <div class="col-lg-4 shadow-5-strong border rounded-0 p-3 text-center"><span class="text-warning fw-bold">Client Firstname :</span> <br> <?php echo $order_fname; ?></div>
        <div class="col-lg-4 shadow-5-strong border rounded-0 p-3 text-center"><span class="text-warning fw-bold">Client Lastname :</span> <br><?php echo $order_lname; ?></div>
      </div>
      <div class="row text-white p-3">
        <div class="col-lg-4 shadow-5-strong border rounded-0 p-3 text-center"><span class="text-warning fw-bold">Client Addresse :</span> <br> <?php echo $order_addresse; ?></div>
        <div class="col-lg-4 shadow-5-strong border rounded-0 p-3 text-center"><span class="text-warning fw-bold">Client Zip Code :</span> <br> <?php echo $order_zip_code; ?></div>
        <div class="col-lg-4 shadow-5-strong border rounded-0 p-3 text-center"><span class="text-warning fw-bold">Client Phone :</span> <br><?php echo $order_phone; ?></div>
      </div>
      <div class="row text-white p-3">
        <div class="col-lg-6 shadow-5-strong border rounded-0 p-3 text-center"><span class="text-warning fw-bold">Additional infos :</span> <br> <?php if ($order_infos_add === "") {
                                                                                                                                                    echo "Not available";
                                                                                                                                                  } else {
                                                                                                                                                    echo $order_infos_add;
                                                                                                                                                  } ?></div>
        <div class="col-lg-6 shadow-5-strong border rounded-0 p-3 text-center"><span class="text-warning fw-bold">Order Date :</span> <br> <?php echo $order_date; ?></div>
      </div>
      <?php
              }
            }
          } catch (Exception $e) {
            die("Error :" . $e->getMessage());
          }

          // cancel order code start :
          try {
            if (isset($_POST['cancel'])) {
              $cancel = $_POST['cancel'];
              $cancel_infos = explode(',', $cancel);
              $cancel_email = $cancel_infos[0];
              $cancel_request_id = $cancel_infos[1];
              $dell_cancel_id = $db->prepare("DELETE  FROM order_infos WHERE user_email ='$cancel_email'");
              $cancel_id = $dell_cancel_id->execute();
              if ($cancel_id) {
                // delete user order :
                $update_user = $db->prepare("UPDATE users_order_infos SET order_status ='removed' WHERE user_email ='$cancel_email'");
                $update_user->execute();
                if ($update_user) {
      ?>
        <div class='alert alert-success alert-dismissible fade rounded-0 show fs-6'>
          <strong>Congratulations : </strong> Order ID <span class="text-warning text-decoration-underline">#<?php echo $cancel_request_id;  ?></span> successfully deleted
          <button type='button' class='btn-close' data-mdb-dismiss='alert'></button>
        </div>
      <?php
                }
              }
            }
          } catch (Exception $e) {
            die("Error :" . $e->getMessage());
          }

          // confirme order code start :
          try {
            if (isset($_POST['names']) && isset($_POST['quantities']) && isset($_POST['email'])) {
              $user_order_email = $_POST['email'];
              $names = $_POST['names'];
              $quantities = $_POST['quantities'];
              for ($i = 0; $i < count($names); $i++) {
                // update quantity :
                $update_quantity = $db->prepare("UPDATE products SET product_quantity=product_quantity-$quantities[$i] WHERE product_name='$names[$i]'");
                $update_quantity->execute();
                if ($update_quantity) {
                  $update_status = $db->prepare("UPDATE users_order_infos SET order_status='confirmed' WHERE user_email='$user_order_email'");
                  $update_status->execute();
                  if ($update_status) {
                    $delete_order_infos = $db->prepare("DELETE  FROM order_infos WHERE user_email ='$user_order_email'");
                    $order_infos_dell = $delete_order_infos->execute();
                  }
                }
              }
              if ($update_quantity->rowCount() > 0) {
      ?>
      <div class="alert alert-light rounded-0 p-3 text-center text-success fw-bold">
        <span><i class="fas fa-check-circle fa-3x mb-2"></i></span> <br>
        <span class="lead fs-4">Done</span>
      </div>
      <?php
              }
            }
          } catch (Exception $e) {
            die("Error :" . $e->getMessage());
          }

          // filter orders by status  code :
          try {
            if (isset($_POST['filter'])) {
              $filter_status = $_POST['filter'];
              // get status :
              $status_req = $db->prepare("SELECT * FROM users_order_infos WHERE order_status ='$filter_status'");
              $readyStatus = $status_req->execute();
              while ($status = $status_req->fetch()) {
                if ($status) {
                  $filter_email = $status['user_email'];
                  $filter_fname = $status['user_firstname'];
                  $filter_lname = $status['user_lastname'];
                  $filter_phone = $status['user_phone'];
                  $filter_date = $status['order_date'];
      ?>
        <div class="row mb-4 table-responsive">
          <div class="lead mb-4" id="lead"></div>
          <table class="table align-middle mb-0 bg-white">
            <thead class="bg-light">
              <tr>
                <th>Name</th>
                <th>Phone</th>
                <th>Status</th>
                <th>Position</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>
                  <div class="d-flex align-items-center">
                    <img src="images/order.png" alt="order" style="width: 55px; height: 55px" class="rounded-circle img-fluid" />
                    <div class="ms-3">
                      <p class="fw-bold mb-1"><?php echo $filter_fname . " " . $filter_lname; ?></p>
                      <p class="text-muted mb-0"><a href="mailto:<?php echo $filter_email; ?>"><?php echo $filter_email; ?></a></p>
                    </div>
                  </div>
                </td>
                <td>
                  <p class="fw-normal mb-1"><a href="tel:<?php echo $filter_phone; ?>"><?php echo $filter_phone; ?></a></p>
                </td>
                <td>
                  <?php
                  if ($filter_status === "confirmed") {
                  ?>
                    <span class="badge badge-success rounded-pill d-inline">
                      Confirmed
                    </span>
                  <?php
                  } else {
                  ?>
                    <span class="badge badge-danger rounded-pill d-inline">
                      Removed
                    </span>
                  <?php
                  }
                  ?>
                </td>
                <td>User</td>
                <td>
                  <input type="hidden" value="<?php echo $filter_email;  ?>">
                  <button type="button" class="btn btn-link btn-sm btn-rounded" id="dell_filter">
                    Delete
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      <?php

                }
              }
            }
          } catch (Exception $e) {
            die("Error :" . $e->getMessage());
          }

          // delete user filtred code :
          try {
            if (isset($_POST['delete_filter'])) {
              $deleted = $_POST['delete_filter'];
              // delete user from users_order_infos :
              $remove_req = $db->prepare("DELETE FROM users_order_infos WHERE user_email='$deleted'");
              $remove_req->execute();
              if ($remove_req) {
      ?>
      <div class='alert alert-success alert-dismissible fade rounded-0 show fs-6'>
        <strong>Congratulations : </strong> Order user [ <span class="text-warning"><?php echo $deleted; ?></span> ] successfully removed
        <button type='button' class='btn-close' data-mdb-dismiss='alert'></button>
      </div>
    <?php
              }
              if ($remove_req->rowCount() === 0) {
    ?>
      <div class='alert alert-white alert-dismissible fade rounded-0 show fs-6'>
        <strong>No oreders requests available </strong>
      </div>
    <?php
              }
            }
          } catch (Exception $e) {
            die("Error :" . $e->getMessage());
          }

          // send contact form code start :
          try {
            if (isset($_POST['contact-infos'])) {
              $contact_infos = $_POST['contact-infos'];
              $contact = explode(',', $contact_infos);
              $contact_full_name = $contact[0];
              $contact_email = $contact[1];
              $contact_message = $contact[2];
              $valid_MESSAGE = filter_var($contact_message, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
              // check if contact email exists with less than 7 days :
              $check_contact = $db->prepare("SELECT * FROM contact WHERE contact_email='$contact_email' and DATEDIFF(CURDATE(),contact_date) < 7");
              $check_contact->execute();
              $contactResult = $check_contact->fetch();
              if ($contactResult) {
    ?>
      <div class='alert alert-danger alert-dismissible fade rounded-0 show fs-6'>
        <strong>NB : </strong> You have already a contact message with less than 7 days , please wait...
        <button type='button' class='btn-close' data-mdb-dismiss='alert'></button>
      </div>
      <?php
              } else {
                // insert contact infos :
                $insert_contact = $db->prepare("INSERT INTO contact(contact_email,contact_full_name,contact_message)
VALUES('$contact_email','$contact_full_name','$valid_MESSAGE')");
                $insert_contact->execute();
                if ($insert_contact) {
      ?>
        <div class='alert alert-success alert-dismissible fade rounded-0 show fs-6'>
          <strong>Congratulations : </strong> We have successfully receive your message , thank you
          <button type='button' class='btn-close' data-mdb-dismiss='alert'></button>
        </div>
        <?php
                }
              }
            }
          } catch (Exception $e) {
            die("Error :" . $e->getMessage());
          }

          // Add to favorite btn code start :
          try {
            if (isset($_POST['favorite'])) {
              $favorite_id = $_POST['p_id'];
              // check if user loged in his account :
              if (isset($_SESSION['client'])) {
                $fav_email = $_SESSION['client'];
                // Get all product infos by id :
                $fav_infos = $db->prepare("SELECT * FROM products WHERE product_id='$favorite_id'");
                $fav_infos->execute();
                $favorites = $fav_infos->fetch();
                if ($favorites) {
                  $fav_name = $favorites['product_name'];
                  $fav_price = $favorites['product_price'];
                  $promotion = $favorites['product_promotion_rate'];
                  //Get image :
                  $fav_image = $db->prepare("SELECT * FROM product_images WHERE product_id='$favorite_id' LIMIT 1");
                  $fav_image->execute();
                  $image_favorite = $fav_image->fetch();
                  if ($image_favorite) {
                    $image_fav_name = $image_favorite['image_name'];
                    $fav_img_src = $image_favorite['image_src'];
                    $image_fav_src = $image_fav_name . $fav_img_src;
                    // check product existance in favorite table  with the same client email :
                    $check_favorites = $db->prepare("SELECT * FROM favorites WHERE product_id ='$favorite_id' and user_email='$fav_email'");
                    $check_favorites->execute();
                    if ($check_favorites->rowCount() > 0) {
                      $_SESSION['removed'] = "
  <div class='alert alert-danger alert-dismissible fade rounded-0 show fs-6'>
    <strong>NB : </strong> Product already exists in your favorites list
    <button type='button' class='btn-close' data-mdb-dismiss='alert'></button>
</div>";
                      $_SESSION['timer'] = time();
        ?> <script>
              window.location.href = "categories.php"
            </script> <?php
                    } else {
                      // Now insert favorite product into db table favorite :
                      $insert_fav = $db->prepare("INSERT INTO favorites(product_id,user_email,product_name,product_image,product_price)
VALUES('$favorite_id','$fav_email','$fav_name','$image_fav_src','$fav_price')");
                      $insert_fav->execute();
                      if ($insert_fav) {
                        $_SESSION['added'] = "<div class='alert alert-success alert-dismissible fade rounded-0 show fs-6'>
  <strong>Congratulations : </strong> Product successfully added to favorite list <a href='customer-space.php'>View favorites</a>
  <button type='button' class='btn-close' data-mdb-dismiss='alert'></button>
</div>";
                        $_SESSION['timer'] = time();
                      ?> <script>
                window.location.href = "categories.php"
              </script> <?php
                      }
                    }
                  }
                }
              } else {
                $_SESSION['removed'] = "
      <div class='alert alert-danger alert-dismissible fade rounded-0 show fs-6'>
        <strong>NB : </strong> you not connected please log in to continue <a href='login.php'>Login</a>
        <button type='button' class='btn-close' data-mdb-dismiss='alert'></button>
    </div>";
                $_SESSION['timer'] = time();
                        ?> <script>
        window.location.href = "categories.php"
      </script> <?php
              }
            }
          } catch (Exception $e) {
            die("Error :" . $e->getMessage());
          }

          //  Wishlist add product btn function start :
          try {
            if (isset($_POST['wishlist'])) {
              $wish_id = $_POST['p_id'];
              // Get all product infos by id :
              $fav_infos = $db->prepare("SELECT * FROM products WHERE product_id='$wish_id'");
              $fav_infos->execute();
              $favorites = $fav_infos->fetch();
              if ($favorites) {
                $fav_name = $favorites['product_name'];
                $fav_price = $favorites['product_price'];
                $promotion = $favorites['product_promotion_rate'];
                //Get image :
                $fav_image = $db->prepare("SELECT * FROM product_images WHERE product_id='$wish_id' LIMIT 1");
                $fav_image->execute();
                $image_favorite = $fav_image->fetch();
                if ($image_favorite) {
                  $image_fav_name = $image_favorite['image_name'];
                  $fav_img_src = $image_favorite['image_src'];
                  $image_fav_src = $image_fav_name . $fav_img_src;
                  // check if exists session wish :
                  if (isset($_SESSION['wish'])) {
                    $check_id = array_column($_SESSION['wish'], 'id');
                    if (in_array($wish_id, $check_id)) {
                      $_SESSION['added'] = "<div class='alert alert-danger alert-dismissible fade rounded-0 show fs-6'>
            <strong>NB : </strong> Product already exists in your wishlist <a href='wishlist.php'> My wishlist </a>
            <button type='button' class='btn-close' data-mdb-dismiss='alert'></button>
        </div>";
                      $_SESSION['timer'] = time();
                ?> <script>
              window.location.href = "categories.php"
            </script> <?php
                    } else {
                      $_SESSION['wish'][] = array(
                        'id' => $wish_id,
                        'name' => $fav_name,
                        'price' => $fav_price - ($fav_price * ($promotion / 100)),
                        'image_src' => $image_fav_src
                      );
                      $shipping = $fav_price - ($fav_price * ($promotion / 100));
                      $_SESSION['added'] = "<div class='alert alert-success alert-dismissible fade rounded-0 show fs-6'>
            <strong>Congratulations :  Product <span class='text-danger'>$fav_name </span>  <span class='text-secondary'>[ $shipping TND ] </span>  successfully added to your wishlist </strong>
            <button type='button' class='btn-close' data-mdb-dismiss='alert'></button>
        </div>";
                      $_SESSION['timer'] = time();
                      ?> <script>
              window.location.href = "categories.php"
            </script> <?php
                    }
                  } else {
                    $_SESSION['wish'][] = array(
                      'id' => $wish_id,
                      'name' => $fav_name,
                      'price' => $fav_price - ($fav_price * ($promotion / 100)),
                      'image_src' => $image_fav_src
                    );
                    $shipping = $fav_price - ($fav_price * ($promotion / 100));
                    $_SESSION['added'] = "<div class='alert alert-success alert-dismissible fade rounded-0 show fs-6'>
          <strong>Congratulations :  Product <span class='text-danger'>$fav_name </span>  <span class='text-secondary'>[ $shipping TND ] </span>  successfully added to your wishlist </strong>
          <button type='button' class='btn-close' data-mdb-dismiss='alert'></button>
      </div>";
                    $_SESSION['timer'] = time();
                      ?> <script>
            window.location.href = "categories.php"
          </script> <?php
                  }
                }
              }
            }
          } catch (Exception $e) {
            die("Error :" . $e->getMessage());
          }

          // remove from wishlist code start : 
          try {
            if (isset($_POST['delete_wish'])) {
              $wish_rem_id = $_POST['wish_id'];
              foreach ($_SESSION['wish'] as $k => $v) {
                if ($v['id'] == $wish_rem_id) {
                  unset($_SESSION['wish'][$k]);
                  $_SESSION['wish'] = array_values($_SESSION['wish']);
                  $_SESSION['added'] = "<div class='alert alert-success alert-dismissible fade rounded-0 show fs-6'>
    <strong>Congratulations : </strong> Product successfully removed from your wishlist
    <button type='button' class='btn-close' data-mdb-dismiss='alert'></button>
</div>";
                  $_SESSION['timer'] = time();
                }
              }
                    ?> <script>
      window.location = "wishlist.php"
    </script> <?php
            }
          } catch (Exception $e) {
            die("Error :" . $e->getMessage());
          }

          // delete from favorite code start :
          try {
            if (isset($_POST['fav_id'])) {
              $fav_id = $_POST['fav_id'];
              // delete favorite :
              $dell_fav = $db->prepare("DELETE FROM favorites WHERE product_id='$fav_id'");
              $dell_fav->execute();
              if ($dell_fav) {
              ?>
      <div class='alert alert-success alert-dismissible fade rounded-0 show fs-6'>
        <strong>Congratulations : </strong> Product successfully removed from your favorites list
        <button type='button' class='btn-close' data-mdb-dismiss='alert'></button>
      </div>
      <?php
              }
            }
          } catch (Exception $e) {
            die("Error :" . $e->getMessage());
          }

          // add session details code start :

          try {
            if (isset($_POST['detail_id'])) {
              $detail_id = $_POST['detail_id'];
              $_SESSION['details'] = $detail_id;
            }
          } catch (Exception $e) {
            die("Error :" . $e->getMessage());
          }

          // subscribe newslater code start :
          try {
            if (isset($_POST['sub_email'])) {
              $sub_email = $_POST['sub_email'];
              // check if user have account :
              $get_user = $db->prepare("SELECT * FROM users WHERE email='$sub_email'");
              $get_user->execute();
              $current_user = $get_user->fetch();
              if ($current_user) {
                $current_fname = $current_user['firstname'];
                $current_lname = $current_user['lastname'];
                // check if client exists in newlater table :
                $check_news = $db->prepare("SELECT * FROM newslater WHERE email='$sub_email'");
                $check_news->execute();
                $check = $check_news->fetch();
                if ($check) {

      ?>
        <div class='alert alert-danger alert-dismissible fade rounded-0 show fs-6'>
          <strong>NB : </strong> You have already register into our Newsletter
          <button type='button' class='btn-close' data-mdb-dismiss='alert'></button>
        </div>
        <?php
                } else {
                  // Insert newslater client email :
                  $insert_newslater = $db->prepare("INSERT INTO newslater (email,firstname,lastname)
  VALUES('$sub_email','$current_fname','$current_lname')");
                  $insert_newslater->execute();
                  if ($insert_newslater) {
        ?>
          <div class='alert alert-success alert-dismissible fade rounded-0 show fs-6'>
            <strong>Congratulations : </strong> Subscribe successfully done , thanks
            <button type='button' class='btn-close' data-mdb-dismiss='alert'></button>
          </div>
      <?php
                  }
                }
              } else {
      ?>
      <div class='alert alert-danger alert-dismissible fade rounded-0 show fs-6'>
        <strong>NB : </strong> To subscribe to our Newsletter please create an account <a href="sign-up.php">Sign-up</a>
        <button type='button' class='btn-close' data-mdb-dismiss='alert'></button>
      </div>
    <?php
              }
            }
          } catch (Exception $e) {
            die("Error :" . $e->getMessage());
          }
          // Search function code start :
          try {
            if (isset($_POST['search'])) {
              $search = $_POST['search'];
              if (isset($_SESSION['search'])) {
                // update
                $_SESSION['search'] = $search;
              } else {
                // set
                $_SESSION['search'] = $search;
              }
            }
          } catch (Exception $e) {
            die("Error :" . $e->getMessage());
          }
          // Filter function code start :
          try {
            if (isset($_POST['filter_products']) && !empty($_POST['filter_products'])) {
              $word = $_POST['filter_products'];
              if ($word === "new") {
    ?>
      <div class="row">
        <?php
                $get_product_infos = $db->prepare("SELECT * FROM products WHERE DATEDIFF(CURDATE(),product_publish_date) < 7 ORDER BY product_publish_date DESC ");
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
        ?>
      </div>
    <?php
              } else {

                // old products
    ?>
      <div class="row">
        <?php
                $get_product_infos = $db->prepare("SELECT * FROM products WHERE DATEDIFF(CURDATE(),product_publish_date) > 7 ORDER BY product_publish_date DESC ");
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
          <div class="alert alert-white text-dark p-2 rounded-0 mt-5 fw-bold text-center">No old products found </div>
        <?php
                }
        ?>
      </div>
    <?php
              }
            }
          } catch (Exception $e) {
            die("Error :" . $e->getMessage());
          }

          // filter by price code start :
          try {
            if (isset($_POST['filter_price'])) {
              $prices = $_POST['filter_price'];
              $priceInfos = explode(',', $prices);
              $price_min = $priceInfos[0];
              $price_max = $priceInfos[1];
    ?>
    <div class="row">
      <?php
              $get_product_infos = $db->prepare("SELECT * FROM products WHERE product_price BETWEEN $price_min and $price_max ORDER BY product_publish_date DESC ");
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
        <div class="alert alert-white text-dark p-2 rounded-0 fw-bold text-center">No product found with this price range</div>
      <?php
              }
      ?>
    </div>
<?php

            }
          } catch (Exception $e) {
            die("Error :" . $e->getMessage());
          }

          // Reset password code start :
          try{
            if(isset($_POST['reset-email'])){
              $reset_email = $_POST['reset-email'];
              $_SESSION['reset'] = $reset_email;
 // verify identity : user / admin :
  $identity = $db -> prepare("SELECT * FROM admins WHERE email='$reset_email'");
  $identity -> execute();
  $final_ident = $identity -> fetch();
  if($final_ident){
    ?>
    <p class="text-success text-center mb-3">Welcome Admin We hove successfully verify your E-mail </p>
    <input type="hidden" value="admins" id="admin">
    <div class="form-floating">
    <input type="text" id="phone" class="form-control" />
    <label class="form-label" for="phone">Secret word</label>
    </div>
          <?php
  }else{
    $verifyEmail = $db -> prepare("SELECT * FROM users WHERE email='$reset_email'");
    $verifyEmail -> execute();
    $response = $verifyEmail -> fetch();
    if($response){
      ?>
<p class="text-success text-center mb-3">We hove successfully verify your E-mail </p>
<input type="hidden" value="users" id="admin">
<div class="form-floating">
<input type="number" id="phone" class="form-control" />
<label class="form-label" for="phone">Phone number</label>
</div>
      <?php
    }else{
      ?>
      <p class="text-danger text-center p-4">This E-mail " <?php echo $reset_email  ?> " not exists : <a href="sign-up.php">Sign up</a> </p>
                <?php
    }
  }
            }
          }
          catch (Exception $e) {
            die("Error :" . $e->getMessage());
          }

          // Get old password verification request :
            try{
              if(isset($_POST['old_password'])){
                $old_password = $_POST['old_password'];
                
                $olds_infos = explode(',',$old_password);
                $pass = $olds_infos [0];
                $ident = $olds_infos[1];
                $reset_email = $_SESSION['reset'];
if($ident === "admins"){
  $check_old = $db -> prepare("SELECT * FROM admins WHERE email='$reset_email' and secret_word = '$pass' ");
  $check_old -> execute();
  $this_password = $check_old -> fetch();
  if($this_password){
?>
<form>
  <input type="hidden" value="admin" id="ident_id">
  <input type="hidden" value="<?php echo $reset_email; ?>" id="ident_email">
  <!-- Password input -->
  <div class="form-floating mb-4">
    <input type="password" id="new-password" class="form-control" required/>
    <label class="form-label" for="new-password">New Password</label>
  </div>
  <!-- 2 column grid layout for inline styling -->
  <div class="row mb-4">
    <div class="col d-flex justify-content-center">
    <button type="submit" class="btn btn-primary" id="change-password">Change</button>
  </div>
</form>
<?php
  }else{
?>
<alert class="alert alert-white text-danger text-center p-2 fw-bold w-100">Sorry your secret word incorrect</alert>
<?php
  }
}else{
  $check_old = $db -> prepare("SELECT * FROM users WHERE email='$reset_email' and client_phone='$pass' ");
  $check_old -> execute();
  $this_password = $check_old -> fetch();
  if($this_password){
    ?>
    <form>
    <input type="hidden" value="client" id="ident_id">
    <input type="hidden" value="<?php echo $reset_email; ?>" id="ident_email">
    <!-- Password input -->
    <div class="form-floating mb-4">
      <input type="password" id="new-password" class="form-control" required/>
      <label class="form-label" for="new-password">New Password</label>
    </div>
    <!-- 2 column grid layout for inline styling -->
    <div class="row mb-4">
      <div class="col d-flex justify-content-center">
      <button type="submit" class="btn btn-primary" id="change-password">Change</button>
    </div>
  </form>
  <?php
  }else{
    ?>
<alert class="alert alert-white text-danger text-center p-2 fw-bold">Sorry your Phone number is incorrect</alert>
<?php
  }
}
              }
            }
            catch (Exception $e) {
              die("Error :" . $e->getMessage());
            }

            // update password code start :
            try{
if(isset($_POST['updates'])){
  $updates = $_POST['updates'];
  $updates_infos = explode(',',$updates);
  $update_ident = $updates_infos[0];
  $update_email = $updates_infos[1];
  $update_pass = $updates_infos[2];
  $cripting_pass = md5($update_pass);
  if($update_ident === "admin"){
    // update admin password 
    $update_admin_password = $db -> prepare("UPDATE admins SET admin_password='$cripting_pass' WHERE email='$update_email'");
    $update_admin_password -> execute();
    if($update_admin_password){
      ?>
      <div class="alert alert-white text-success text-center p-2 fw-bold">Congratulations : your password successfully updated <a href="login.php">Login</a></div>
      <?php 
    }
  }else{
   // update admin password 
   $update_client_password = $db -> prepare("UPDATE users SET client_password='$cripting_pass' WHERE email='$update_email'");
   $update_client_password -> execute();
   if($update_client_password){
     ?>
     <div class="alert alert-white text-success text-center p-2 fw-bold">Congratulations : your password successfully updated <a href="login.php">Login</a></div>
     <?php 
   }
  }
}
            }
            catch (Exception $e) {
              die("Error :" . $e->getMessage());
            }
          // END OF CODE