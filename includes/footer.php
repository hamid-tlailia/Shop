<!-- toasts -->
<div id="toast"><div id="img"><i class="fas fa-check"></i></div><div id="desc">Product successfuly added</div></div>
<div id="toast2"><div id="img2"><i class="fas fa-check"></i></div><div id="desc2">Product successfuly removed</div></div>
<!-- http://jsfiddle.net/m8x1g0q8/ -->
<!-- /toasts -->
  <!-- footer start -->
  <footer style="background-color: #deded5;">
    <div class="container p-4">
      <div class="row">
        <div class="col-lg-6 col-md-12 mb-4">
          <h5 class="mb-3" style="letter-spacing: 2px; color: #818963;">About company</h5>
          <p>
          <span class="text-danger fw-bold">Fashion-Company (FC)</span> is a strong and old fashion clothes in south africa Tunisia since 1970
        We are a team over than 10 person with most responsabilty and abaility to do hard and fast wich make customers more satisfaction and completely happy 
          </p>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
          <h5 class="mb-3" style="letter-spacing: 2px; color: #818963;">links</h5>
          <ul class="list-unstyled mb-0">
            <li class="mb-1">
              <a href="blogs.php" style="color: #4f4f4f;">Frequently Asked Questions</a>
            </li>
            <li class="mb-1">
              <a href="checkout.php" style="color: #4f4f4f;">Delivery</a>
            </li>
            <li class="mb-1">
              <a href="news.php" style="color: #4f4f4f;">Pricing</a>
            </li>
            <li>
              <a href="blogs.php" style="color: #4f4f4f;">Where we deliver?</a>
            </li>
          </ul>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
          <h5 class="mb-1" style="letter-spacing: 2px; color: #818963;">opening hours</h5>
          <table class="table" style="color: #4f4f4f; border-color: #666;">
            <tbody>
              <tr>
                <td>Mon - Fri:</td>
                <td>8am - 9pm</td>
              </tr>
              <tr>
                <td>Sat - Sun:</td>
                <td>8am - 1am</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
      &copy; <?php echo date("Y"); ?> All Copyrights
      <a class="text-dark" href="#">Reserved</a>
    </div>
    <!-- Copyright -->
  </footer>
  <!-- css -->
  <style>
    /* toast 1 */
    #toast {
    visibility: hidden;
    max-width: 50px;
    height: 50px;
    /*margin-left: -125px;*/
    margin: auto;
    background-color: green;
    color: #fff;
    text-align: center;
    border-radius: 2px;
overflow: hidden;
    position:fixed;
    z-index: 1000;
    left: 0;right:0;
    bottom: 30px;
    top: -88vh;
    font-size: 17px;
    white-space: nowrap;
}
#toast #img{
	width: 50px;
	height: 50px;
    
    float: left;
    
    padding-top: 16px;
    padding-bottom: 16px;
    
    box-sizing: border-box;

    
    background-color: black !important;
    color: #fff;
}
#toast #desc{

    
    color: #fff;
   
    padding: 10px;
    
    overflow: hidden;
	white-space: nowrap;
}

#toast.show {
    visibility: visible;
    -webkit-animation: fadein 0.5s, expand 0.5s 0.5s,stay 3s 1s, shrink 0.5s 2s, fadeout 0.5s 2.5s;
    animation: fadein 0.5s, expand 0.5s 0.5s,stay 3s 1s, shrink 0.5s 4s, fadeout 0.5s 4.5s;
}
/* toast 2 */
#toast2 {
    visibility: hidden;
    max-width: 50px;
    height: 50px;
    /*margin-left: -125px;*/
    margin: auto;
    background-color: green;
    color: #fff;
    text-align: center;
    border-radius: 2px;
overflow: hidden;
    position:fixed;
    z-index: 200;
    left: 0;right:0;
    bottom: 30px;
    top: -88vh;
    font-size: 17px;
    white-space: nowrap;
}
#toast2 #img2{
	width: 50px;
	height: 50px;
    
    float: left;
    
    padding-top: 16px;
    padding-bottom: 16px;
    
    box-sizing: border-box;

    
    background-color: black !important;
    color: #fff;
}
#toast2 #desc2{

    
    color: #fff;
   
    padding: 10px;
    
    overflow: hidden;
	white-space: nowrap;
}

#toast2.show {
    visibility: visible;
    -webkit-animation: fadein 0.5s, expand 0.5s 0.5s,stay 3s 1s, shrink 0.5s 2s, fadeout 0.5s 2.5s;
    animation: fadein 0.5s, expand 0.5s 0.5s,stay 3s 1s, shrink 0.5s 4s, fadeout 0.5s 4.5s;
}
@-webkit-keyframes fadein {
    from {bottom: 0; opacity: 0;} 
    to {bottom: 30px; opacity: 1;}
}

@keyframes fadein {
    from {bottom: 0; opacity: 0;}
    to {bottom: 30px; opacity: 1;}
}

@-webkit-keyframes expand {
    from {min-width: 50px} 
    to {min-width: 350px}
}

@keyframes expand {
    from {min-width: 50px}
    to {min-width: 350px}
}
@-webkit-keyframes stay {
    from {min-width: 350px} 
    to {min-width: 350px}
}

@keyframes stay {
    from {min-width: 350px}
    to {min-width: 350px}
}
@-webkit-keyframes shrink {
    from {min-width: 350px;} 
    to {min-width: 50px;}
}

@keyframes shrink {
    from {min-width: 350px;} 
    to {min-width: 50px;}
}

@-webkit-keyframes fadeout {
    from {bottom: 30px; opacity: 1;} 
    to {bottom: 60px; opacity: 0;}
}

@keyframes fadeout {
    from {bottom: 30px; opacity: 1;}
    to {bottom: 60px; opacity: 0;}
}
  </style>
  <!-- js -->
  <script>
    // toast 1 function
    function launch_toast() {
    var x = document.getElementById("toast")
    x.className = "show";
    setTimeout(function(){ x.className = x.className.replace("show", ""); }, 5000);
}
// toast 2 function
function launch_toast2() {
    var y = document.getElementById("toast2")
    y.className = "show";
    setTimeout(function(){ y.className = y.className.replace("show", ""); }, 5000);
}
// fix navbar when scroll down
window.onscroll = function (){
  var fixed = document.getElementById('fixed')
  if(window.scrollY>200){
    fixed.classList.add('fixed-top')
  }else{
    fixed.classList.remove('fixed-top')
  }
}
// search function  code start :
var search_icon = document.getElementById('search');
var search_input = document.getElementById('search-value');
search_icon.addEventListener('click' , function (){
  if(search_input.value === ""){
    search_input.focus();
    search_input.setAttribute('placeholder','Please type a word');
  }else{
    var request = new XMLHttpRequest();
    var word_form = new FormData();
    word_form.append('search',search_input.value);
    request.onreadystatechange = function (){
      if(request.readyState === 4 && request.status === 200){
window.location.href="searsh.php"
      }
    }
    request.open('POST','response.php');
    request.send(word_form);
  }
})
  </script>
  <!-- footer end -->
  
  <script src="js/main.js"></script>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <!-- MDB -->
  <script src="js/mdb.min.js"></script>
  <script src="js/mdb.min.js.map"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  
</body>
</html>