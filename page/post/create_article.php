<?php
 require_once("php/function.php"); 
 
?>

<main class="container">    
    <div id="box_alert">
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
    </div>
    <div class="card mb-3 shadow p-3 bg-body rounded">            
                <div class="row g-0">                    
                    <div class="col-md-12">
                        <div class="card-body">                        
                            <form action="/store-post" method="POST" enctype="multipart/form-data">
                            <div class="d-flex justify-content-between">
                            <h4 class="card-title mb-4">Tambah Postingan</h4>                                
                            <div class="form-check mb-3">
                                    <input class="form-check-input" name="publish" type="checkbox" value="" id="flexCheckDefault" checked>
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Publikasi
                                    </label>
                                </div>      
                            </div>                            
                                <div class="mb-3 row">
                                    <label for="staticEmail" class="col-sm-2 col-form-label">Judul</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="judul" class="form-control" placeholder="judul">
                                    </div>
                                </div>    
                                <div class="mb-3 row">
                                    <label for="staticEmail" class="col-sm-2 col-form-label">Gambar Judul</label>
                                    <div class="col-sm-10 mb-3">                                                    
                                        <img src="" alt="" width="300" id="previewImage">
                                    </div>                   
                                    <div class="col-sm-2"></div>
                                    <div class="col-sm-2">
                                        <select name="" id="" onchange="selectGambar(this)" class="form-control">                                            
                                            <option value="">URL</option>                                            
                                            <option value="">File</option>
                                        </select>                           
                                    </div>
                                    <div class="col-sm-8" id="box_gambar">                                                     
                                        <input class="form-control" name="gambarURL" oninput="changeURLImage(this)" type="text" placeholder="Masukkan URL Gambar">
                                    </div>
                                </div>    
                                <div class="mb-3 row">
                                    <label for="" class="col-sm-2 col-form-label">Tanggal</label>
                                    <div class="col-sm-10">
                                        <input type="datetime-local" name="postDateTime" id="postDateTime" class="form-control">
                                    </div>                                    
                                </div>                                  
                                <div class="mb-3">
                                    <textarea name="konten" id="trumbowyg-text"></textarea>                                                    
                                </div>                                                                          
                                <div class="d-flex">
                                    <a href="/post" class="me-2 btn btn-secondary">Kembali</a>
                                    <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>                        
                        </div>  
                    </div>          
                </div>                                                                                   
        </div>       
</main>
<?php ob_start("setScript") ?>
<script type="text/javascript">
    $('#trumbowyg-text').trumbowyg()      
    function selectGambar(e){
        var boxGambar = $('#box_gambar')
        $('#previewImage').attr('src', '')
        boxGambar.empty()
        if($(e).find('option').filter(':selected').text() == "URL"){
            boxGambar.append('<input class="form-control" name="gambarURL" oninput="changeURLImage(this)" type="text" placeholder="Masukkan URL Gambar">')            
        }else{            
            boxGambar.append('<input class="form-control" accept="image/*" name="gambarFile" onchange="changeImgFile(this)" type="file" id="formFile">')
        }
    }

    function changeURLImage(e){        
        $('#previewImage').attr('src', $(e).val())
    }

    function changeImgFile(e){                       
        if(/image/.test(e.files[0].type)){
            $('#box_alert').empty()
            $('#previewImage').attr('src', URL.createObjectURL(e.files[0]))                    
        }else{
            showMessage('Gambar tidak sesuai')
        }            
    }

    function showMessage(message){
        let boxImage = $('#box_alert')
        boxImage.empty()
        boxImage.append('<div class="alert alert-danger" role="alert">'+message+'</div>')
    }
</script>
<?php ob_end_flush(); ?>
