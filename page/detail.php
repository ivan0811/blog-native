<?php
 require_once('php/function.php');  
?>

<main class="container">
    <?php         
        $id = $_GET['id'];        
        $data = articleDetail($id, session_id());        
        $gambar = $data['gambar'];
        if(isset($_POST['komentar'])){        
            $comments = postComments($data['artikelID'], $_SESSION['id'], $_POST['comments_id']);            
            if($comments == 1){                
                showMessage("Koneksi ke Database gagal. Menambahkan postingan gagal.", "alert-danger"); 
            }  
        }           
        
        if(isset($_POST['updateKomentar'])){            
            $updateComments = updateComments($_POST['comments_id']);
            if($updateComments == 1){
                showMessage("Koneksi ke Database gagal. Menambahkan postingan gagal.", "alert-danger"); 
            }
        }

        if(isset($_POST['deleteKomentar'])){
            $deleteKomentar = deleteComments($_POST['deleteCommentsId']);
            if($deleteKomentar == 1){
                showMessage("Koneksi ke Database gagal. Menambahkan postingan gagal.", "alert-danger"); 
            }
        }
    ?>
    <div class="card mb-3 shadow p-3 bg-body rounded">    
        <h4 class="card-title me-auto"><?= $data['judul'] ?></h4>        
        <p class="fs-5"><?= $data['nama'] ?></p>
        <div class="text-center mb-3">
            <img src="<?= ((!filter_var($gambar, FILTER_VALIDATE_URL)) ? 'storage/image/'.$gambar : $gambar) ?>" width="50%" class="center">                                                 
        </div>        
        <?= $data['konten'] ?>
    </div>      
    <div class="card mb-3 shadow p-3 bg-body rounded">            
        <h4 class="card-title me-auto mb-4">Komentar</h4> 
        <?php if(getStatus()) {
            ?>
            <form action="" method="post" class="mb-3">
            <div class="d-flex mb-3">                
                <input type="text" class="form-control me-3" name="konten" placeholder="Tulis Komentar" required>
                <button type="submit" name="komentar" class="btn btn-outline-secondary">Komentar</button>
            </div>            
        </form>  
        <?php
        }else{?>  
        <div class="alert alert-warning" role="alert">
            Jika Ingin berkomentar harap masuk terlebih dahulu
        </div>            
        <?php
        }
            $comments = getComments($data['artikelID']);            
            foreach ($comments as $key => $value) {                                            
         ?>
            <div class="mb-3">            
            <div class="d-flex justify-content-between">
                <h6><?= $value['nama'] ?></h6>                
                <?php 
                if(getStatus()){
                    if($value['id_pengguna'] == $_SESSION['id']) { 
                ?>
                <div>
                    <button class="btn outline-none p-0 me-3"><i class="fa fa-edit" onclick="editKomentar(<?= $value['komentar_id']?>)"></i></button>
                    <button class="btn outline-none p-0" onclick="hapusKomentar(<?= $value['komentar_id']?>)"><i class="fa fa-times"></i></button>
                </div>                    
                <?php } 
                }?>
             </div>                        
                <p id="isi<?= $value['komentar_id'] ?>"><?= $value['isi'] ?></p>                                                                   
            </div>
         <?php } ?>
    </div>         
</main>

<div class="modal fade" tabindex="-1" id="modalEdit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Komentar</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="" method="POST">
      <input type="hidden" name="comments_id" id="editKomentarId">
        <div class="modal-body">        
            <input type="text" name="editComments" id="editComments" class="form-control">        
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" name="updateKomentar" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal" tabindex="-1" id="modalHapus" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Pesan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Konfirmasi Hapus Komentar</p>
      </div>
      <div class="modal-footer">
      <form action="" method="POST">
        <input type="hidden" name="deleteCommentsId" id="deleteID">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-danger" name="deleteKomentar">Hapus</button>
      </form>        
      </div>
    </div>
  </div>
</div>

<?php ob_start('setScript') ?>
    <script type="text/javascript">
        function editKomentar(id){
            $('#modalEdit').modal('show')
            $('#editKomentarId').val(id)
            $('#editComments').val($('#isi'+id).text())
        }

        function hapusKomentar(id){
            $('#modalHapus').modal('show')
            $('#deleteID').val(id)
        }
    </script>
<?php ob_end_flush() ?>
