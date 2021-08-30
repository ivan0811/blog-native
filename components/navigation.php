<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">        
    <link rel="stylesheet" href="css/trumbowyg.min.css">
    <title>Document</title>    
    <style>
        html, body {
            height: 100%;            
        }
        .container{
            padding-top: 100px;
            /* min-height: 100%; */
        }        
        footer {                        
            bottom:0;
            width:100%;                                                
        }
    </style>
</head>
<body style="background-color: #fafafa">
<?php 
    require_once("php/router.php");    
    $hiddenNav = getHiddenNav();    
    // !$hiddenNav ? include "footer.php" : "";    
    if(!$hiddenNav) {
?>
<nav class="navbar navbar-expand-md navbar-light fixed-top bg-white">
    <div class="container-fluid">
      <a class="navbar-brand" href="/">AtolBlog</a>      
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">              
      <?php 
        $keyword = isset($_GET["q"]) ? $_GET["q"] : "";
        $urlSearch = ['/?q='.$keyword, '/post?q='.$keyword, '/users?q='.$keyword];
        $urlCari_diperbolehkan = ['/', '/post', '/users'];
        if(in_array($_SERVER['REQUEST_URI'], $urlCari_diperbolehkan) || in_array($_SERVER['REQUEST_URI'], $urlSearch)){ 
          if(isset($_POST['search'])){
            $q = $_POST['keyword'];       
            if(in_array($_SERVER['REQUEST_URI'], $urlSearch)){                                          
              preg_match("/\?q=/", $_SERVER['REQUEST_URI'], $matches, PREG_OFFSET_CAPTURE);
              $url_path = substr($_SERVER['REQUEST_URI'], 0, $matches);
              header('Location: '.$url_path.'?q='.$q);              
            }else{
              header('Location: '.$_SERVER['REQUEST_URI'].'?q='.$q);
            }            
          }
      ?>
        <form action="" method="POST" class="mx-auto me-auto d-inline w-50">
            <div class="input-group">                            
                <input class="form-control" type="search" name="keyword" placeholder="Search" aria-label="Search">
                <button class="btn btn-secondary" type="submit" name="search"><i class="fa fa-search"></i></button>
            </div>          
        </form>
        <?php } else {?>        
          <div class="me-auto mx-auto"></div>
        <?php } ?>
        <ul class="navbar-nav mb-2 mb-lg-0">        
          <?php if(getStatus()) { ?>        
            <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <?= $_SESSION["username"] ?>
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">            
            <li><a class="dropdown-item" href="/post">Postingan</a></li>            
            <?php if($_SESSION["roles"] == "admin"){ ?>              
              <li><a class="dropdown-item" href="/users">Pengguna</a></li>
            <?php } ?>
            <li><hr class="dropdown-divider "></li>
            <li><a class="dropdown-item" href="/logout">Logout</a></li>
          </ul>
        </li>
          <?php }else{ ?>
            <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="/login">Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="/register">Daftar</a>
          </li>
          <?php } ?>
        </ul>
      </div>
    </div>
  </nav>
  <?php }
    include getPage();    
   ?>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script> -->
<script src="js/trumbowyg.min.js"></script>
<script src="https://use.fontawesome.com/558ab92b73.js"></script>
<script>
    $.trumbowyg.svgPath = 'css/icons.svg';    
    window.onscroll = () => {                
        if(window.scrollY == 0){
            $('.navbar').removeClass('shadow-sm')
        }else{
            $('.navbar').addClass('shadow-sm')
        }
    }
</script>
<?= getScript() ?>
</body>
</html>