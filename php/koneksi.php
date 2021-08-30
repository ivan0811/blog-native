<?php
    function dbConnect(){
        $server = "localhost";
        $host = "root";
        $pass = "";
        $db = "native_blog";
        $conn = new mysqli($server, $host, $pass, $db);
        if($conn->connect_errno > 0){
            echo "Gagal koneksi".(DEVELOPMENT?" ".$db->connect_error:"")."<br>";  
        }else            
            return $conn;
    }