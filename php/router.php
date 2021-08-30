<?php
require_once("function.php");
$req = $_SERVER['REQUEST_URI'];        
$hiddenNav = false;    
$page = "";
$id = isset($_GET["id"]) ? $_GET["id"] : "";
$q = isset($_GET["q"]) ? $_GET["q"] : "";
if(getStatus()){
    if($_SESSION['roles'] == 'admin'){
        switch($req){          
            case '/users':
                $page = 'page/users/users.php';
                break;
            case '/users?q='.$q:
                $page = 'page/search/users.php';
                break;
            case '/create-users':
                $page = 'page/users/create_users.php';
                break;
            case '/store-users':                   
                $storeUsers = storeUsers();
                if($storeUsers == 0){
                    $_SESSION['status'] = true;
                    $_SESSION['message'] = 'Data berhasil ditambahkan';
                    header('Location: /users');
                }else{                    
                    $_SESSION['error'] = $storeUsers;
                    header('Location: /create-users');
                }                                           
                break;
            case '/edit-users?id='.$id:
                $page = 'page/users/edit_users.php';   
                
                break;
            case '/update-users':
                $updateUsers = updateUsers();
                if($updateUsers){
                    header('Location: /users');
                }else{
                    header('Location: /edit-users?id='.$updateUsers);
                }
                break;
            case '/delete-users':
                $deleteUsers = deleteUsers();
                if($deleteUsers) header('Location: /users');                
                break;          
        }
    }    

    switch($req){
        case '/confirm-users':        
            $page = "page/confirm.php";        
            break;            
        case '/logout':
            endSession();
            header("Location: /");
            break;
        case '/test':
            $hiddenNav = true;                            
            break;
        case '/post':                
            $page = "page/post/article.php";                  
            break;       
        case '/create-post':
            $page = "page/post/create_article.php";
            break;
        case '/store-post':
            $hiddenNav = true;        
            $storePost = storeArticle();
            if($storePost == 0){
                $_SESSION['status'] = true;
                $_SESSION['message'] = 'Data berhasil ditambahkan';
                header("Location: /post");            
            }else{                                                         
                $_SESSION["error"] = $storePost;
                header('Location: /create-post');                                                         
            }            
            break;
        case '/edit-post?id='.$id:
            $page = "page/post/edit_article.php";
            break;
        case '/update-post':
            $updatePost = updateArticle();            
            if($updatePost == 0){
                $_SESSION['status'] = true;
                $_SESSION['message'] = 'Data berhasil diubah';
                header('Location: /post');
            }else{
                $_SESSION["error"] = $updatePost[1];
                header('Location: /edit-post?id='.$updatePost[0]);
            }
            break;
        case '/delete-post':
            $deletePost = deleteArticle();
            if($deletePost == 0){
                $_SESSION['status'] = true;
                $_SESSION['message'] = 'Data berhasil dihapus';
                header("Location: /post");            
            }
            break;              
        case '/post?q='.$q:
            $page = 'page/search/article.php';
            break;        
    }    
}

switch ($req) {
    case '/':
        $page = "page/home.php";
        break; 
    case '/?q='.$q:
        $page = "page/search/home.php";
        break;      
    case '/login':                      
        if(getStatus()){            
            header("Location: /");
        }else{
            $hiddenNav = true;                                      
            $page = "page/login.php";                
        }        
        break;
    case '/register':
        if(getStatus()){            
            header("Location: /");
        }else{
            $hiddenNav = true;      
            $page = "page/register.php"; 
        }             
        break;       
    case '/register/store':
        $register = register();        
        if($register) header('Location: /confirm-users');        
        break; 
    case '/login/auth':
        $login = login();                
        if($login == 0){
            header("Location: /");            
        }else{                                         
            session_start();
            $_SESSION["error"] = $login;
            header('Location: /login');                                                         
        }              
        break;
    case '/detail?id='.$id:
        $page = 'page/detail.php';
        break;
}    

if($page == ""){
    $hiddenNav = true;
    $page = 'page/404.php';
}

function getHiddenNav(){    
    global $hiddenNav;    
    return $hiddenNav;
}

function getPage(){   
    global $page; 
    return $page;
}