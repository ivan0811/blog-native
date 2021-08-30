<?php
 require_once("php/function.php");  
?>

<main class="container">
    <?php 
        if(isset($_SESSION["error"])){                
            $err = $_SESSION["error"];                     
            if($err > 0){
                if ($err == 1)
                    showMessage("Ukuran gambar terlalu besar", "alert-danger");
                else if ($err == 2)
                    showMessage("Ekstensi gambar tidak sesuai", "alert-danger");                    
                else if ($err == 3)
                    showMessage("Koneksi ke Database gagal. Menambahkan postingan gagal.", "alert-danger");                    
                else                    
                    showMessage("Unknown Error.", "alert-danger");
            } 
            $_SESSION["error"] = 0;
        }                
    ?>
    <div class="card mb-3 shadow p-3 bg-body rounded">            
                <div class="row g-0">                    
                    <div class="col-md-12">
                        <div class="card-body">
                        <h4 class="card-title mb-4">Tambah Pengguna</h4>                                
                            <form action="/store-users" method="POST">
                                <div class="mb-3 row">
                                    <label for="" class="col-sm-2 col-form-label">Nama</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="nama" class="form-control" placeholder="nama">
                                    </div>
                                </div>                                   
                                <div class="mb-3 row">
                                    <label for="" class="col-sm-2 col-form-label">Username</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="username" class="form-control" placeholder="username">
                                    </div>
                                </div>    

                                <div class="mb-3 row">
                                    <label for="" class="col-sm-2 col-form-label">Password</label>
                                    <div class="col-sm-10">
                                        <input type="password" name="password" class="form-control" placeholder="password">
                                    </div>
                                </div>    

                                <div class="mb-3 row">
                                    <label for="" class="col-sm-2 col-form-label">Konfirmasi Password</label>
                                    <div class="col-sm-10">
                                        <input type="password" name="confirm_password" class="form-control" placeholder="konfirmasi password">
                                    </div>
                                </div>    
                                <div class="mb-3 row">
                                    <label for="" class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-10">
                                        <input type="email" name="email" class="form-control" placeholder="email">
                                    </div>
                                </div>    
                                <div class="mb-3 row">
                                    <label for="" class="col-sm-2 col-form-label">Status</label>
                                    <div class="col-sm-10">
                                        <select name="status" id="" class="form-control">                                            
                                            <option value="">Pilih Status</option>
                                            <option value="admin">Admin</option>                                            
                                            <option value="penulis">Penulis</option>
                                        </select>                           
                                    </div>
                                </div>    
                                                                                                               
                                <div class="d-flex">
                                    <a href="/users" class="me-2 btn btn-secondary">Kembali</a>
                                    <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>                        
                        </div>  
                    </div>          
                </div>                                                                                   
        </div>       
</main>
