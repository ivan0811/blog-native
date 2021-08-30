<?php
    define("DEVELOPMENT", TRUE);    
    require_once("auth.php");
    require_once("koneksi.php");  

    $scripts;    

    function errorMessage($db){
        echo "Gagal Eksekusi SQL" . (DEVELOPMENT ? " : ". $db->error : "") . "<br>";                 
    }    

    function checkUsername($username, $email){
        $db = dbConnect();
        $res = $db->query("SELECT username, email FROM pengguna WHERE username='$username' AND email='$email' ");
        if($res){
            if($res->num_rows > 1){
                return FALSE;
            }else{
                return TRUE;
            }
        }else{
            errorMessage($db);                
            return FALSE;
        }
    }

    function register(){        
        $db = dbConnect();
        if(isset($_POST["register"])){
            $nama = $_POST["nama"];
            $username = $_POST["username"];
            $email = $_POST["email"];
            $password = $_POST["password"];    
            if(checkUsername($username, $email)){
                $res = $db->query("INSERT INTO pengguna (nama, username, email, password, status) 
                VALUES('$nama', '$username', '$email', '$password', 'penulis')");
                if($res){                    
                    setSession($res->insert_id, $username, 'penulis');
                    return TRUE;
                }else{
                    errorMessage($db);                
                    return FALSE;
                }                                                 
            }else{
                return 1;
            }            
        }
    }

    function showToast($message){
        echo '<div class="position-fixed top-0 end-0 p-3 mt-5" data-bs-delay="4000">
        <div class="toast align-items-center" role="alert" aria-live="assertive" aria-atomic="true">
          <div class="d-flex">
            <div class="toast-body">
                '.$message.'
           </div>
            <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
          </div>
        </div>
        </div>';
    }
    
    function showMessage($message, $alert){
        echo '<div class="alert '.$alert.'" role="alert">
               '.$message.'
            </div>';
    }

    function setScript($buffer){
        global $scripts;
        $scripts = $buffer;        
    }

    function getScript(){
        global $scripts;
        return $scripts;
    }

    function showArticle(){        
        $db = dbConnect();                
        $id = $_SESSION['id'];
        $res = $db->query("SELECT * FROM artikel WHERE pengguna_id = '$id'");        
        if($res){
            return $res->fetch_all(MYSQLI_ASSOC);
        }else
            errorMessage($db);
    }

    function editArticle($id){
        $db = dbConnect();        
        $res = $db->query("SELECT * FROM artikel where id = '$id'");        
        if($res){                        
            if($res->num_rows>0){
                $data = $res->fetch_assoc();
                $res->free();
                return $data;
            }else
                errorMessage($db);
        }else
            errorMessage($db);
    }

    function storeArticle(){        
        $db = dbConnect();
        getStatus();
        if(isset($_POST["simpan"])){
            $judul = $_POST["judul"];
            $gambar = isset($_POST["gambarURL"]) ? $_POST["gambarURL"] : $_FILES['gambarFile']['name'];
            $konten = preg_replace('/(<[^>]+) style=".*?"/i', '$1', $_POST["konten"]);
            $tanggal = $_POST["postDateTime"];                     

            if(isset($_FILES['gambarFile'])){                
                $eks = ['png', 'jpg'];                
                $ukuran = $_FILES['gambarFile']['size'];                                
                $file_tmp = $_FILES['gambarFile']['tmp_name'];
                $x = explode('.', $gambar);
                $ekstensi = strtolower(end($x));            
                if(in_array($ekstensi, $eks)){
                    if($ukuran < 1044070){
                        move_uploaded_file($file_tmp, 'storage/image/'.$gambar);                                                                                                
                    }else{
                        return 1;
                    }
                }else{
                    return 2;
                }
            }      
            
            $publish = isset($_POST['publish']) ? 'T' : 'F';     
                    
            
            $pengguna_id = $_SESSION["id"];            
            $tanggal = explode('T', $tanggal);            
            $tanggal = $tanggal[0].' '.$tanggal[1];
            $res = $db->query("INSERT INTO artikel (pengguna_id, judul, konten, tanggal, gambar, publikasi)
            VALUES('$pengguna_id', '$judul', '$konten', '$tanggal', '$gambar', '$publish')");
            if($res){
                if($db->affected_rows>0){
                    return 0;
                }
            }else{                                
                errorMessage($db);
                return 3;
            }
        }                  
    }    

    function updateArticle(){        
        $db = dbConnect();
        getStatus();
        if(isset($_POST["simpan"])){
            $id = $_POST["id"];
            $judul = $_POST["judul"];                        
            $konten = preg_replace('/(<[^>]+) style=".*?"/i', '$1', $_POST["konten"]);
            $tanggal = $_POST["postDateTime"];                     
            $gambar = "";            
                            
            if(isset($_POST['gambarURL'])){
                if($_POST['gambarURL'] != ""){
                    $gambar = $_POST['gambarURL'];
                    $gambar = ", gambar = '$gambar'";                  
                }                
            }

            if(isset($_FILES['gambarFile'])){                    
                $gambar = $_FILES['gambarFile']['name'];                
                $eks = ['png', 'jpg'];                
                $ukuran = $_FILES['gambarFile']['size'];                                
                $file_tmp = $_FILES['gambarFile']['tmp_name'];
                $x = explode('.', $gambar);
                $ekstensi = strtolower(end($x));            
                if(in_array($ekstensi, $eks)){
                    if($ukuran < 1044070){                            
                        move_uploaded_file($file_tmp, 'storage/image/'.$gambar);                
                        $gambar = ", gambar = '$gambar'";                          
                    }else{
                        return [$id, 1];
                    }
                }else{
                    return [$id, 2];
                }
            }            
                        
            if($_POST["gambarURL"] != "" || isset($_FILES["gambarFile"])){                    
                $oldImage = $_POST['oldImage'];                
                if(!filter_var($oldImage, FILTER_VALIDATE_URL)){
                    unlink('storage/image/'.$oldImage);      
                }                
            }            
            
            $pengguna_id = $_SESSION["id"];            
            $tanggal = explode('T', $tanggal);            
            $tanggal = $tanggal[0].' '.$tanggal[1];            
            $publish = isset($_POST['publish']) ? 'T' : 'F';            

            $sql = "UPDATE artikel SET 
                    judul = '$judul',
                    konten = '$konten', 
                    tanggal = '$tanggal',
                    publikasi = '$publish'
                    $gambar WHERE id='$id' AND pengguna_id = '$pengguna_id'";                                        
            $res = $db->query($sql);
            if($res){
                if($db->affected_rows>0){
                    return 0;
                }
            }else{                                
                errorMessage($db);
                return [$id, 3];
            }
        }          
    }

    function deleteArticle(){            
        $db = dbConnect();
        $id = $_POST['ArticleID'];
        $res = $db->query("DELETE FROM artikel WHERE id='$id'");
        if($res){
            return 0;
        }else{
            errorMessage($db);
            return 1;
        }                
    }

    function showUsers(){
        $db = dbConnect();
        $res = $db->query("SELECT * FROM pengguna");
        if($res){
            return $res->fetch_all(MYSQLI_ASSOC);
        }else{
            errorMessage($db);
        }
    }

    function storeUsers(){
        $db = dbConnect();
        if(isset($_POST['simpan'])){
            $nama = $_POST['nama'];
            $username = $_POST['username'];
            $password = $_POST['password'];
            $email = $_POST['email'];
            $status = $_POST['status'];
            $res = $db->query("INSERT INTO pengguna (nama, username, password, email, status)
                                VALUES ('$nama', '$username', '$password', '$email', '$status')");
            if($res){
                return 0;
            }else{
                errorMessage($db);
                return 1;            
            }                                
        }else
            return 2;
    }    

    function editUsers($id){
        $db = dbConnect();        
        $res = $db->query("SELECT * FROM pengguna where id = '$id'");        
        if($res){                        
            if($res->num_rows>0){
                $data = $res->fetch_assoc();
                $res->free();
                return $data;
            }else
                errorMessage($db);
        }else
            errorMessage($db);
    }

    function updateUsers(){
        $db = dbConnect();
        if(isset($_POST['simpan'])){
            $id = $_POST['id']; 
            $nama = $_POST['nama'];
            $username = $_POST['username'];
            $email = $_POST['email'];
            $status = $_POST['status'];            
            // var_dump($_POST);     
            $password = "";
            if($_POST['password'] != ""){
                $password = $_POST['password'];
                $password = "password = '$password'";
            }
                         
            $sql = "UPDATE pengguna SET 
            nama = '$nama',
            username = '$username',
            email = '$email',
            status = '$status', $password WHERE id = '$id'";
            $res = $db->query($sql);
            if($res){
                return TRUE;                        
            }else{
                errorMessage($db);
                return $id;
            }            
        }        
    }

    function deleteUsers(){
        $db = dbConnect();
        $id = $_POST['usersId'];
        $res = $db->query("DELETE FROM pengguna WHERE id='$id'");
        if($res){
            return TRUE;
        }else
            errorMessage($db);                    
    }

    function getAllArticle(){
        $db = dbConnect();
        $res = $db->query('SELECT * FROM artikel ORDER BY tanggal DESC');
        if($res){
            return $res;
        }else
            errorMessage($db);
    }        

    function articleDetail($data, $key){
        $id = my_decrypt($data, $key);
        $db = dbConnect();        
        $res = $db->query("SELECT artikel.id as artikelID, judul, konten, tanggal, gambar, pengguna.nama as nama FROM artikel JOIN pengguna ON artikel.pengguna_id = pengguna.id WHERE artikel.id='$id'");                
        if($res){                                  
            if($res->num_rows>0){
                $data = $res->fetch_assoc();
                $res->free();
                return $data;
            }else
                return errorMessage($db);
        }else
            return errorMessage($db);
    }

    function my_encrypt($data, $key) {        
        $encryption_key = base64_decode($key);        
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));        
        $encrypted = openssl_encrypt($data, 'aes-256-cbc', $encryption_key, 0, $iv);        
        return base64_encode($encrypted . '::' . $iv);
    }
     
    function my_decrypt($data, $key) {        
        $encryption_key = base64_decode($key);        
        list($encrypted_data, $iv) = explode('::', base64_decode($data), 2);
        return openssl_decrypt($encrypted_data, 'aes-256-cbc', $encryption_key, 0, $iv);
    }    

    function postComments($article_id, $user_id){
        $db = dbConnect();        
        $konten = $_POST['konten'];        
        $res = $db->query("INSERT INTO komentar (artikel_id, pengguna_id, konten, tgl)
                            VALUES ('$article_id', '$user_id', '$konten', NOW())");
        if($res){
            return 0;
        }else{
            errorMessage($db);
            return 1;            
        }                                        
    }

    function getComments($id){
        $db = dbConnect();
        $res = $db->query("SELECT komentar.id as komentar_id, komentar.pengguna_id as id_pengguna, komentar.konten as isi, tgl, pengguna.nama as nama FROM komentar 
                            JOIN artikel ON artikel_id = artikel.id
                            JOIN pengguna ON komentar.pengguna_id = pengguna.id
                            WHERE artikel_id = '$id'");
        if($res){                                                          
            return $res;            
        }else
            return errorMessage($db);
    }

    function updateComments($id){
        $db = dbConnect();
        $konten = $_POST['editComments'];
        $res = $db->query("UPDATE komentar SET konten='$konten', tgl=NOW() WHERE id='$id'");
        if($res){
            return 0;
        }else
            errorMessage($db);
            return 1;
    }

    function deleteComments($id){
        $db = dbConnect();
        $res = $db->query("DELETE FROM komentar WHERE id='$id'");
        if($res){
            return 0;
        }else{
            errorMessage($db);
            return 1;
        }
    }

    function searchHome($q){     
        $db = dbConnect();
        $res = $db->query("SELECT * FROM artikel WHERE judul LIKE '%$q%'
                            OR konten LIKE '%$q%' ORDER BY tanggal DESC");
        if($res){                        
            if($res->num_rows>0){
                $data = $res;                
                return $data;
            }                            
        }else
            errorMessage($db);
    }

    function searchArticle($q, $id){     
        $db = dbConnect();        
        $res = $db->query("SELECT * FROM artikel WHERE pengguna_id='$id' AND judul LIKE '%$q%'
                            OR konten LIKE '%$q%'");
        if($res){                        
            if($res->num_rows>0){
                $data = $res;                
                return $data;
            }                            
        }else
            errorMessage($db);
    }

    function searchUsers($q){
        $db = dbConnect();
        $res = $db->query("SELECT * FROM pengguna WHERE nama LIKE '%$q%' OR email LIKE '%$q%'");
        if($res){
            if($res->num_rows>0){
                $data = $res;                
                return $data;
            }     
        }else
        errorMessage($db);
    }


    



