<?php require_once('php/function.php') ?>
<div class="container">
    <div class="row">
    <?php 
        $data = getAllArticle();
        foreach($data as $item) { 
            $gambar = $item['gambar'];
            if($item['publikasi'] == 'F') continue;
        ?>
        <div class="col-12">                    
            <div class="row">                          
                <div class="card mb-3 col-md-8">
                <a href="/detail?id=<?=my_encrypt($item['id'], session_id())?>" style="text-decoration:none; color: black">
                    <div class="row g-0">                        
                        <div class="col-4">
                        <div style="height: 152px">
                            <img src="<?= ((!filter_var($gambar, FILTER_VALIDATE_URL)) ? 'storage/image/'.$gambar : $gambar) ?>" alt="" width="100%" height="100%">
                        </div>     
                        </div>                        
                        <div class="col-8">
                        <div class="card-body">
                            <h5 class="card-title"><?= $item['judul'] ?></h5>
                            <p class="card-text"><?= (strlen(strip_tags($item['konten'])) > 160 ? substr(strip_tags($item['konten']), 0, 160) . ' ...' : strip_tags($item['konten']))  ?></p>
                            <p class="card-text"><small class="text-muted"><?= $item['tanggal'] ?></small></p>
                        </div>                        
                        </div>                                                                                               
                    </div>
                    </a>        
                </div>                        
            </div>
        </div>
    <?php } ?>              
    </div>    
</div>