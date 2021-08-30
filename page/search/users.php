<?php include_once('php/function.php'); ?>
<main class="container">
<div class="card mb-3 shadow p-3 bg-body rounded">            
                <div class="row g-0">                    
                    <div class="col-md-12">
                        <div class="card-body">
                        <?php  $q = $_GET['q'];
                                $data = searchUsers($q); 
                                if($data == null){
                                    showMessage('Data tidak ditemukan', ' alert-light');
                                }else{  
                            ?>
                            <div class="d-flex mb-3">
                                <h4 class="card-title me-auto">Pengguna</h4>
                                <a href="/create-users" class="btn btn-success">Tambah Pengguna</a>
                            </div>                                                          
                            <table class="table table-bordered">
                            <thead>                            
                                <tr>
                                    <th>No</th>        
                                    <th>Nama</th>                                                                                          
                                    <th>Email</th>                                         
                                    <th>Status</th>                                         
                                    <th>Aksi</th>
                                </tr>                             
                            </thead>
                            <tbody>
                            <?php                                
                                $no = 1;
                                foreach ($data as $key => $item) { 
                                    if($item['id'] == 1) continue;
                                ?>                            
                                <tr>
                                    <td width=50><?= $no++ ?></td>
                                    <td><?= $item['nama'] ?></td>
                                    <td><?= $item['email'] ?></td>    
                                    <td><?= $item['status'] ?></td>                                                                                                             
                                    <td width=150>                                        
                                        <div class="d-flex justify-content-between">
                                            <a href="/edit-users?id=<?= $item['id']?>" class="btn btn-warning">Edit</a>
                                            <button type="button" class="btn btn-danger deleteConfirm" id="deleteConfirm<?= $key ?>" data-id="<?= $item['id'] ?>">Hapus</button>                                                
                                        </div>                                                                                    
                                    </td>                                                                   
                                </tr>
                                <?php }?>
                            </tbody>
                        </table>
                        <?php } ?> 
                        </div>                         
                    </div>          
                </div>                                                                                   
        </div>       
</main>
<div class="modal fade" id="deleteUsers" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Pesan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>      
      <div class="modal-body">              
        <p>Konfirmasi hapus pengguna</p>
        <form action="/delete-users" method="post">            
        <div class="modal-footer">
        <input type="hidden" name="usersId" id="setUserId">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-danger">Hapus</button>        
            </form>
      </div>      
    </div>
  </div>
</div>
<?php ob_start('setScript') ?>
    <script type="text/javascript">
        // $('.toast').toast('show');                
        for (const item of $('.deleteConfirm')) {
            $(item).click(() => {
                $('#deleteUsers').modal('show')
                $('#setUserId').val($(item).data('id'))                
            })            
        }
    </script>
<?php ob_end_flush() ?>
