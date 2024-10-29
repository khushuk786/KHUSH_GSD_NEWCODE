<?php 
include("config.php");

$action=$_POST["action"];

if($action == "login"){
    $username = $_POST["username"];
    $password = $_POST["userpwd"];
    $chk = "select * from tbladmin where Username='{$username}' and  
    Password='{$password}'";
    $res = mysqli_query($connect,$chk);
    if(mysqli_num_rows($res) > 0){
        $row = mysqli_fetch_array($res);
        $_SESSION["clinic_userid"] = $row["AID"];
        $_SESSION["clinic_username"] = $row["Username"];
        $_SESSION["clinic_password"] = $row["Password"];
        save_log($_SESSION['clinic_username']." logged in.");
        echo 1;
    }else{
        echo 0;
    }
}

if($action == "logout"){  
    save_log($_SESSION['clinic_username']." logged out.");
    // session_unset();
    all_session_kill();
    echo 1;
}
?>