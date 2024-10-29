<?php

session_start();

$server_name = "localhost";
$server_username = "root";
$server_password = ""; // Adjust this as necessary
$database_name = "hospital";

$connect = mysqli_connect($server_name, $server_username, $server_password, $database_name);

if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}

define('root', __DIR__ . '/');
define('roothtml', "http://" . $_SERVER['HTTP_HOST'] . "/hospital/");

define('curlink',basename($_SERVER['SCRIPT_NAME']));

$arr_gender = array("Male","Female");

function enDateTime($date){
    $date = date_create($date);
    $date = date_format($date,"M, d, Y h:i A");
    return $date;
}

function all_session_kill(){
    unset($_SESSION["clinic_userid"]);
    unset($_SESSION["clinic_username"]);
    unset($_SESSION["clinic_password"]); 
}

function load_gender()
{
    global $arr_gender;
    $out="";
    foreach($arr_gender as $value)
    {
        $out.="<option value='{$value}'>{$value}</option>";
    }
    return $out;
}

function load_ward(){
    global $connect;
    $sql="select * from tblward";
    $result=mysqli_query($connect,$sql) or die("Query fail.");
    $out="";
    while($row = mysqli_fetch_array($result)){
        $out.="<option value='{$row["AID"]}'>{$row["Name"]}</option>";
    }
    return $out;
}

function load_team(){
    global $connect;
    $sql="select * from tblteam";
    $result=mysqli_query($connect,$sql) or die("Query fail.");
    $out="";
    while($row = mysqli_fetch_array($result)){
        $out.="<option value='{$row["AID"]}'>{$row["Name"]}</option>";
    }
    return $out;
}

function load_patient(){
    global $connect;
    $sql="select * from tblpatient";
    $result=mysqli_query($connect,$sql) or die("Query fail.");
    $out="";
    while($row = mysqli_fetch_array($result)){
        $out.="<option value='{$row["AID"]}'>{$row["Name"]}</option>";
    }
    return $out;
}

function load_doctor(){
    global $connect;
    $sql="select * from tbldoctor";
    $result=mysqli_query($connect,$sql) or die("Query fail.");
    $out="";
    while($row = mysqli_fetch_array($result)){
        $out.="<option value='{$row["AID"]}'>{$row["Name"]}</option>";
    }
    return $out;
}

function save_log($des){
    global $connect;
    $dt=date("Y-m-d H:i:s");
    $userid=$_SESSION['clinic_userid'];
    $sql="insert into tbllog (Description,UserID,Date) values ('{$des}'
    ,$userid,'{$dt}')";
    mysqli_query($connect,$sql);   
}


