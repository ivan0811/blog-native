<?php require_once("php/function.php") ?>
<div class="container">
    <div class="row justify-content-md-center">
        <?php                                               
            if(isset($_SESSION["error"])){                
                $err = $_SESSION["error"];                     
                if($err > 0){
                    if ($err == 1)
                        showMessage("username dan password tidak sesuai", "alert-danger");
                    else if ($err == 2)
                        showMessage("Error database. Silahkan hubungi administrator", "alert-danger");                    
                    else if ($err == 3)
                        showMessage("Koneksi ke Database gagal. Autentikasi gagal.", "alert-danger");                    
                    else                    
                        showMessage("Unknown Error.", "alert-danger");
                }                
                session_destroy();
            }            
        ?>
        <div class="card mb-3 shadow p-3 bg-body rounded w-50">            
                <div class="row g-0">                    
                    <div class="col-md-12">
                        <div class="card-body">                                        
                                <h3 class="card-title text-center mb-3">Masuk</h3>                                     
                            <form action="/login/auth" method="POST">
                                <div class="form-group mb-3">
                                    <label for="" class="form-control-label">Username</label>
                                    <input type="text" name="username" class="form-control" value="<?php echo ($_SERVER["REMOTE_ADDR"]=="5.189.147.4"?"admin":"");?>">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="" class="form-control-label">Password</label>
                                    <input type="password" name="password" class="form-control" value=""<?php echo ($_SERVER["REMOTE_ADDR"]=="5.189.147.4"?"admin":"");?>">
                                </div>
                                <div class="d-flex">
                                    <div class="form-check mb-3 me-auto">
                                        <input type="checkbox" class="form-check-input">
                                        <label for="" class="form-check-label">
                                            Remember me
                                        </label>                                    
                                    </div>      
                                    <a href=""><small class="text-muted">Forgot Password?</small></a>                          
                                </div>         
                                <div class="d-flex justify-content-between">                                             
                                    <a href="/register" class="btn btn-outline-secondary">Daftar</a>                                                                                                                                                        
                                    <button type="submit" name="login" class="btn btn-primary">Masuk</button>                                    
                                </div>                                
                            </form>
                        </div>  
                    </div>          
                </div>                                                                                   
        </div>                  
    </div>
</div>
