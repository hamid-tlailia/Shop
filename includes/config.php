<?php
// start session :
session_start();
// stat db connection :
try {
  $db = new PDO("mysql:host=localhost", "root", "");
  // create db shop :
  $new_db = $db->prepare("CREATE DATABASE IF NOT EXISTS shop");
  $new_db->execute();
  // USE SHOP :
  $db_type = $db->prepare("USE shop");
  $db_type->execute();
  // create admins table :
  $admins = $db->prepare("CREATE TABLE IF NOT EXISTS admins (
    email VARCHAR (100) PRIMARY KEY NOT NULL ,
    firstname VARCHAR (100) NOT NULL ,
    lastname VARCHAR (100) NOT NULL,
    admin_password VARCHAR (100) NOT NULL,
    secret_word VARCHAR (200) NOT NULL,
    register_date TIMESTAMP
  )");
  $admins->execute();
  // create table users :
  $users = $db->prepare("CREATE TABLE IF NOT EXISTS users (
    email VARCHAR (100) PRIMARY KEY NOT NULL ,
    firstname VARCHAR (100) NOT NULL ,
    lastname VARCHAR (100) NOT NULL,
    client_password VARCHAR (100) NOT NULL,
    client_phone INT,
    client_address VARCHAR (500) NOT NULL,
    register_date TIMESTAMP
  )");
  $users->execute();
  // create newslater table :
  $newslater = $db->prepare("CREATE TABLE IF NOT EXISTS newslater (
    email VARCHAR (100) PRIMARY KEY NOT NULL ,
    firstname VARCHAR (100) NOT NULL ,
    lastname VARCHAR (100) NOT NULL,
    register_date TIMESTAMP
  )");
  $newslater->execute();
  // create table products :
  $products = $db->prepare("CREATE TABLE IF NOT EXISTS products (
    product_id int (10) AUTO_INCREMENT PRIMARY KEY ,
    product_name VARCHAR (100) NOT NULL ,
    product_price int (10) NOT NULL,
    product_quantity VARCHAR (100),
    product_description VARCHAR (1500),
    product_disponibity VARCHAR (200),
    product_promotion_rate int (10) NOT NULL,
    product_promotion_end date,
    product_publish_date TIMESTAMP
  )");
  $products->execute();
  // crate table product images :
  $product_images = $db->prepare("CREATE TABLE IF NOT EXISTS product_images (
    image_id int (10) AUTO_INCREMENT PRIMARY KEY  ,
    product_id int (10) NOT NULL ,
    image_name VARCHAR (100) NOT NULL,
    image_src VARCHAR (100) NOT NULL,
    image_publish_date TIMESTAMP
  )");
  $product_images->execute();
  // auto update product promotion :
  $updates = $db->prepare("UPDATE products 
  set 
  product_promotion_rate='0' ,
   product_promotion_end='0000-00-00' 
   WHERE DATEDIFF(CURDATE(),product_promotion_end) > 0");
  $updates->execute();
  // crate table orders users  :
  $users_order_infos = $db->prepare("CREATE TABLE IF NOT EXISTS users_order_infos (
    user_email VARCHAR (100)  PRIMARY KEY  ,
    user_firstname VARCHAR (100) NOT NULL ,
    user_lastname VARCHAR (100) NOT NULL,
    user_addresse VARCHAR (300) NOT NULL,
    zip_code INT NOT NULL,
    user_phone INT NOT NULL,
    additional_infos VARCHAR (500) NOT NULL,
    order_status VARCHAR (200) NOT NULL,
    order_date TIMESTAMP
  )");
  $users_order_infos->execute();
  // crate table orders infos  :
  $order_infos = $db->prepare("CREATE TABLE IF NOT EXISTS order_infos (
      id INT AUTO_INCREMENT  PRIMARY KEY  ,
      order_id INT NOT NULL,
      user_email VARCHAR (100) NOT NULL ,
      order_products_name VARCHAR (1000) NOT NULL,
      order_products_quantity INT  NOT NULL,
      product_total INT NOT NULL,
      total INT NOT NULL,
      order_date TIMESTAMP
    )");
  $order_infos->execute();
  // crate table notifs   :
  $notifications = $db->prepare("CREATE TABLE IF NOT EXISTS notifications (
          id INT AUTO_INCREMENT  PRIMARY KEY  ,
          notif_type VARCHAR (200) NOT NULL,
          user_firstname VARCHAR (100) NOT NULL ,
          user_lastname VARCHAR (100) NOT NULL,
          order_date TIMESTAMP
        )");
  $notifications->execute();
  // auto delete notifications table :
  $dells_notifs = $db->prepare("DELETE  FROM notifications 
   WHERE DATEDIFF(CURDATE(),order_date) > 2");
  $dells_notifs->execute();
  // auto delete orders table :
  $dells_orders = $db->prepare("DELETE  FROM users_order_infos 
    WHERE DATEDIFF(CURDATE(),order_date) > 6");
  $dells_orders->execute();
  // crate table message-contact   :
  $contact = $db->prepare("CREATE TABLE IF NOT EXISTS contact (
    contact_id INT AUTO_INCREMENT  PRIMARY KEY  ,
    contact_email VARCHAR (200) NOT NULL,
    contact_full_name VARCHAR (100) NOT NULL ,
    contact_message VARCHAR (1000) NOT NULL ,
    contact_date TIMESTAMP
  )");
  $contact->execute();
  // auto delete contact table :
  $dell_contact = $db->prepare("DELETE  FROM contact 
   WHERE DATEDIFF(CURDATE(),contact_date) > 15");
  $dell_contact->execute();
  // crate table visitor counter   :
  $visits = $db->prepare("CREATE TABLE IF NOT EXISTS visits (
  id INT AUTO_INCREMENT  PRIMARY KEY  ,
  visits_number INT  NOT NULL,
  visit_date TIMESTAMP
)");
  $visits->execute();
  // intialisation for visists table :
  $check_visits = $db->prepare("SELECT * FROM visits");
  $check_visits->execute();
  if ($check_visits->rowCount() === 0) {
    // insert first visit init :
    $insert_visit = $db->prepare("INSERT INTO visits(visits_number)
      VALUES('1')");
    $insert_visit->execute();
  } else {
    // ipdate visits :
    $update_visits = $db->prepare("UPDATE visits SET visits_number = visits_number+1");
    $update_visits->execute();
  }
  // crate table favorites   :
  $favorites = $db->prepare("CREATE TABLE IF NOT EXISTS favorites (
  id INT AUTO_INCREMENT PRIMARY KEY ,
  product_id INT NOT NULL,
  user_email VARCHAR (200) NOT NULL,
  product_name VARCHAR (100) NOT NULL,
  product_image VARCHAR (200) NOT NULL,
  product_price INT  NOT NULL,
  date TIMESTAMP
)");
  $favorites->execute();
} catch (Exception $e) {
  die('Error : ') . $e->getMessage();
}
