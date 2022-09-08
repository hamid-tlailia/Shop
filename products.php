<?php
include "includes/config.php";
include "includes/header.php";
?>
<div class="container" id="container">
<h3 class="text-muted text-center text-decoration-underline mb-3">Recent added products</h3>
<?php
// get products from db :
try{
$get_product_infos = $db -> prepare("SELECT * FROM products ORDER BY product_publish_date DESC ");
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
                <section class="mx-auto my-5" style="max-width: 23rem;">
                  <div class="card" id="card" style="max-height: 500px;">
                  <div class="col-12 text-end"><?php
                  if($product_promotion_rate!="0"){
                    ?> <span class="badge bg-danger text-white rounded">-<?php echo $product_promotion_rate ?>%</span> <?php
                  }else{
                   ?> <span class="badge bg-danger text-white rounded" style="opacity: 0;">0%</span> <?php
                  }
                  ?>
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
                          <p class="text-muted">4.5 <?php   
                          if($product_quantity>=10){
                           ?> <span class="badge bg-success text-white fw-bold">IN STOCK</span>  <?php
                          }else if($product_quantity<2){
                            ?> <span class="badge bg-danger text-white fw-bold">OUT STOCK</span>  <?php
                          }else{
                            ?> <span class="badge bg-warning text-white fw-bold">ALERT STOCK</span>  <?php
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
                      <div class="row border border-dark ">
                        <input type="hidden" value="<?php echo  $product_name;?>">
                        <input type="hidden" value="<?php echo  $product_id;?>">
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
<script>
      // edit product code start : 
    var edits = document.querySelectorAll('#edit');
    var input_id = document.getElementById('p_id')
    var response = document.getElementById('response')
    edits.forEach(edit => {
      edit.addEventListener('click' , function (){
        var id = edit.getAttribute('data-id');
        // input_id.value=id;
        edit.disabled = true ;
        var edit_request = new XMLHttpRequest()
        var edit_form = new FormData()
        edit_form.append('modifiateID',id)
        edit_request.onreadystatechange = function (){
          if(edit_request.readyState === 4 && edit_request.status === 200){
            edit.disabled=false
            response.innerHTML = edit_request.responseText
          // input === file === show === result
var show = document.getElementById('show') 
var preview = document.getElementById('preview')
var file2 = document.getElementById('file2_modif')
file2.onchange = function(){
  show.classList="row mt-4 mb-4 p-2"
 for(var image of file2.files){
   var image_preview = document.createElement('img')
   image_preview.setAttribute('class','img-fluid rounded p-2  border border-success preview')
   var col = document.createElement('div')
   col.setAttribute('class','col-3')
   var image_preview_src = URL.createObjectURL(image)
   image_preview.src=image_preview_src
   col.append(image_preview)
   preview.append(col)
 }
}
// send === request === for === annuler === button :
  var annuler = document.getElementById('console');
  annuler.onclick = function(){
    file2.value=null
    preview.innerHTML =""
    show.classList="row mt-4 mb-4 p-2 d-none"
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
setInterval(function(){
  var date_modifier = document.getElementById('edit-p-promotion-date');
date_modifier.onchange = function (){
  if(date_modifier.value<today){
  
  retard_alert.innerHTML=`    <!-- Error Alert -->
    <div class="alert alert-danger alert-dismissible fade show fs-6">
          <strong>NB : </strong> Please choose another date that be equal or greater than today
          <button type="button" class="btn-close" data-mdb-dismiss="alert"></button>
      </div>`
      date_modifier.value = null
      btn_save.style.pointerEvents="none"
 }else{
  retard_alert.innerHTML=''
  btn_save.style.pointerEvents="all"
 }
}
if(date_modifier.value>=today && p_promotion_rate.value === ""){
  btn_save.style.pointerEvents="none"
  retard_alert.innerHTML=`
 <!-- Error Alert -->
    <div class="alert alert-danger alert-dismissible fade show fs-6">
          <strong>NB : </strong> Product promotion value does not empty
          <button type="button" class="btn-close" data-mdb-dismiss="alert"></button>
      </div>`
}else if(date_modifier.value==="" && p_promotion_rate.value!=="0"){
p_promotion_rate.value="0"
retard_alert.innerHTML=""
btn_save.style.pointerEvents="all"
}else if(date_modifier.value>=today && p_promotion_rate.value[0]==="0"){
  btn_save.style.pointerEvents="none"
  retard_alert.innerHTML=`
 <!-- Error Alert -->
    <div class="alert alert-danger alert-dismissible fade show fs-6">
          <strong>NB : </strong> Product promotion value does not empty
          <button type="button" class="btn-close" data-mdb-dismiss="alert"></button>
      </div>` 
}
else{
  btn_save.style.pointerEvents="all"
  retard_alert.innerHTML=""
}
},100)
// delete === image === button === request 
var deletes_image = document.querySelectorAll('#delete_image');
deletes_image.forEach(dell => {
  dell.addEventListener('click' , dellImage)
})
// function === delete === image === code === start :
var response_area = document.getElementById('image_delete')
function dellImage (){
    var image_id = this.parentElement.parentElement.children[0]
    this.parentElement.parentElement.parentElement.parentElement.remove()
    console.log(image_id.value)
    // send === new === form === data === to === delete === image === from === database :
      var request_delete = new XMLHttpRequest()
      var id_delete = new FormData()
      id_delete.append('delete_id',image_id.value)
      this.disabled = true
      request_delete.onreadystatechange = function (){
        if(request_delete.readyState === 4 && request_delete.status === 200){
        response_area.innerHTML = request_delete.responseText
        this.disabled = false
        }
      }
      request_delete.open('POST','response.php')
        request_delete.send(id_delete)
        
  }
  // save === changes === button === code === start :
var save = document.getElementById('save-modification');
save.onclick = function (){
  var file_input = document.getElementById('file2_modif')
  var nom_modifier = document.getElementById('edit-p-name')
  var prix_modifier = document.getElementById('edit-p-price')
  var quantity_modifier = document.getElementById('edit-p-quantity')
  var description_modifier = document.getElementById('edit-p-description')
  var promo_modifier = document.getElementById('edit-p-promotion-rate')
  var date_modifier = document.getElementById('edit-p-promotion-date')
  var id_produit_modifier = document.getElementById('p-modifiate-id')
 save.disabled = true
 save.innerHTML=`Saving...`
 var input_modification = new XMLHttpRequest()
var fomr_inputs_modif = new FormData()
for(var newImage of file_input.files){
  fomr_inputs_modif.append('newimages[]',newImage)
}
var infos_modification = [nom_modifier.value,prix_modifier.value,quantity_modifier.value,description_modifier.value,promo_modifier.value,id_produit_modifier.value,date_modifier.value]
fomr_inputs_modif.append('modifcation',infos_modification)
input_modification.onreadystatechange = function(){
  if(input_modification.readyState === 4 && input_modification.status === 200){
    response_area.innerHTML=input_modification.responseText
    save.disabled = false
    save.innerHTML="Save changes"
    file_input.value=null
    preview.innerHTML =""
    show.classList="row mt-4 mb-4 p-2 d-none"
  
   
  }
}
  
input_modification.open('POST','response.php')
  input_modification.send(fomr_inputs_modif)

}
// next
          }
         
        }
        edit_request.open('POST','response.php')
          edit_request.send(edit_form)
      })
    })
</script>
</div>
<?php
include "includes/footer.php";
?>
