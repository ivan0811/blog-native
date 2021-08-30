<?php 
  include_once('php/function.php');   
?>

<main class="container">

<div class="card mb-3 shadow p-3 bg-body rounded">            
                <div class="row g-0">                    
                    <div class="col-md-12">
                        <div class="card-body">
                        <?php 
                            $q = $_GET['q'];
                            $id = $_SESSION['id'];
                            $data = searchArticle($q, $id); 
                            if($data == null){
                              showMessage('Data tidak ditemukan', ' alert-light');
                            }else{      
                        ?>
                            <div class="d-flex mb-3">
                                <h4 class="card-title me-auto">Postingan</h4>
                                <a href="/create-post" class="btn btn-success">Tambah Postingan</a>
                            </div>                                                        
                            <table class="table table-bordered">
                            <thead>                            
                                <tr>
                                    <th>No</th>        
                                    <th>Tanggal</th>                                                      
                                    <th>Judul</th>     
                                    <th>Publikasi</th>                                         
                                    <th>Aksi</th>
                                </tr>                             
                            </thead>
                            <tbody>
                            <?php 
                                                        
                                $no = 1;
                                foreach ($data as $key => $item) { ?>
                                <tr>
                                    <td width=50><?= $no++ ?></td>
                                    <td width=200><?= $item['tanggal'] ?></td>
                                    <td><?= $item['judul'] ?></td>    
                                    <td width=100>
                                        <?= $item['publikasi'] ?>
                                    </td>                                     
                                    <td width=105>
                                        <form action="/delete-post" method="post">
                                            <input type="hidden" name="ArticleID" value="<?= $item['id'] ?>">
                                            <div class="d-flex justify-content-between">
                                                <a href="/edit-post?id=<?= $item['id']?>" class="btn btn-warning"><i class="fa fa-edit"></i></a>
                                                <button type="button" class="btn btn-danger" onclick="showDeleteModal()"><i class="fa fa-trash"></i></button>
                                            </div>                                            
                                        </form>
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
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Pesan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>      
      <div class="modal-body">
        Yakin menghapus postingan?
      </div>
      <div class="modal-footer">
        <form action="/delete-post" method="post">
            <input type="hidden" name="ArticleID" value="<?= $item['id'] ?>">                                                        
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-danger">Hapus</button>
        </form>
      </div>
    </div>
  </div>
</div>
<?php   
  if(isset($_SESSION['status'])){
    if($_SESSION['status']){      
      showToast($_SESSION['message']);   
      $_SESSION['status'] = false;
      $_SESSION['message'] = '';
    }    
  }  
?>


<?php ob_start('setScript') ?>
    <script type="text/javascript">        
    function showDeleteModal(){
        $('#deleteModal').modal('show')
    }        
    setTimeout(() => {
        $('.toast').toast('show')
    }, 300);    
    </script>
<?php ob_end_flush() ?>
