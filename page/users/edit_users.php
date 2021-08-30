<?php
 require_once("php/function.php");  

?>

<main class="container">    
    <div class="card mb-3 shadow p-3 bg-body rounded">            
                <div class="row g-0">                    
                    <div class="col-md-12">
                        <div class="card-body">
                        <h4 class="card-title mb-4">Edit Pengguna</h4>       
                        <?php $data = editUsers($_GET['id']);                             
                        ?>                                   
                            <form action="/update-users" method="POST">
                            <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
                            <input type="hidden" name="password" id="setPassword" value>                                                    
                                <div class="mb-3 row">
                                    <label for="" class="col-sm-2 col-form-label">Nama</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="nama" class="form-control" placeholder="nama" value="<?= $data['nama'] ?>">
                                    </div>
                                </div>                                   
                                <div class="mb-3 row">
                                    <label for="" class="col-sm-2 col-form-label">Username</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="username" class="form-control" placeholder="username" value="<?= $data['username'] ?>">
                                    </div>
                                </div>    
                                <div class="mb-3 row">
                                    <label for="" class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-10">
                                        <input type="email" name="email" class="form-control" placeholder="email" value="<?= $data['email'] ?>">
                                    </div>
                                </div>    
                                <div class="mb-3 row">
                                    <label for="" class="col-sm-2 col-form-label">Status</label>
                                    <div class="col-sm-10">
                                        <select name="status" id="" class="form-control">                                            
                                            <option value="">Pilih Status</option>
                                            <?php 
                                                $status = ['admin', 'penulis'];
                                                foreach ($status as $value) {                                                                          
                                                    echo '<option value="'.$value.'" '.($value == $data["status"] ? "selected" : "").'>'.ucwords($value).'</option>';
                                            } ?>
                                        </select>                           
                                    </div>
                                </div>    
                                <div class="mb-3 row">
                                    <label for="" class="col-sm-2 col-form-label">Reset Password</label>
                                    <div class="col-sm-10">
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#resetPassword">Reset</button>
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
<div class="modal fade" id="resetPassword" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Reset Password</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        
        <div class="mb-3 row">
            <label for="" class="col-sm-4 col-form-label">Password</label>
            <div class="col-sm-8">
                <input type="password" id="password" class="form-control" placeholder="password">
            </div>
        </div>    

        <div class="mb-3 row">
            <label for="" class="col-sm-4 col-form-label">Konfirmasi Password</label>
            <div class="col-sm-8">
                <input type="password"  id="confirm_password" class="form-control" placeholder="konfirmasi password">
            </div>
        </div>    
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-primary" id="save_password">Simpan</button>
      </div>
    </div>
  </div>
</div>

<?php ob_start('setScript') ?>
<script type="text/javascript">    
// var modalDelete = new bootstrap.Modal($('#resetPassword').target, {})
    $('#save_password').click(() => {
        if($('#password').val() == $('#confirm_password').val()){
            $('#setPassword').val($('#password').val())                                    
            $('#resetPassword').modal('hide')
        }
    })
</script>
<?php ob_end_flush() ?>