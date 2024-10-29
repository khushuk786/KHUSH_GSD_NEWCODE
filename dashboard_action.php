<?php
include('config.php');

$action = $_POST["action"];
if($action == 'show'){  
    $ward = $_POST['ward'];
    $b = "";
    if($ward >0){  
        $b = " and w.AID=$ward";
    }    
    
    $sql = "select * from tblward".$b;
    $result=mysqli_query($connect,$sql) or die("SQL a Query");
    $out="";

    if(mysqli_num_rows($result) > 0){
        $out.='
        <table class="table table-hover table-bordered mb-0">
        <thead>
        <tr> 
            <th width="7%;">No</th> 
            <th>Name</th> 
            <th>Type</th>
            <th>Capacity</th>
            <th>Availability</th>      
        </tr>
        </thead>
        <tbody>
        ';
        $no = 0;
        while($row = mysqli_fetch_array($result)){
            $no=$no+1;
            $out.="<tr>
                <td>{$no}</td>
                <td>{$row["Name"]}</td>
                <td>{$row["Type"]}</td>
                <td>{$row["Capacity"]}</td>
                <td>{$row["Availability"]}</td>
            </tr>";
        }
        $out.="</tbody>";
        $out.="</table>";

        echo $out; 
        
    }else{
    
    $out.='
        <table class="table table-hover table-bordered mb-0">
        <thead>
        <tr>
            <th width="7%;">No</th> 
            <th>Name</th> 
            <th>Type</th>
            <th>Capacity</th>
            <th>Availability</th>    
        </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="5" class="text-center">No data</td>
            </tr>
        </tbody>
        </table>
        ';
        echo $out;
    }
}

if($action == 'show_appointment'){  
    $sql = "select a.*, p.Name as pname, d.Name as dname, w.Name as wname from tblappointment a, tblpatient p, tbldoctor d, tblward w where a.PatientID = p.AID and a.DoctorID = d.AID and p.WardID=w.AID LIMIT 5";
    $result=mysqli_query($connect,$sql) or die("SQL a Query");
    $out="";

    if(mysqli_num_rows($result) > 0){
        $out.='
        <table class="table table-hover table-bordered mb-0">
        <thead>
        <tr> 
            <th width="7%;">No</th> 
            <th>Patient</th> 
            <th>Doctor</th>
            <th>Ward</th>
            <th>Date</th>     
        </tr>
        </thead>
        <tbody>
        ';
        $no = 0;
        while($row = mysqli_fetch_array($result)){
            $no=$no+1;
            $out.="<tr>
                <td>{$no}</td>
                <td>{$row["pname"]}</td>
                <td>{$row["dname"]}</td>
                <td>{$row["wname"]}</td>
                <td>{$row["Date"]}</td>
            </tr>";
        }
        $out.="</tbody>";
        $out.="</table>";

        echo $out; 
        
    }else{
    
    $out.='
        <table class="table table-hover table-bordered mb-0">
        <thead>
        <tr>
            <th width="7%;">No</th> 
            <th>Patient Name</th> 
            <th>Doctor Name</th>
            <th>Ward</th>
            <th>Date</th>        
        </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="5" class="text-center">No data</td>
            </tr>
        </tbody>
        </table>';
        echo $out;
    }
}

if($action=='showpatient'){
    $sql = "select count(AID) as count from tblpatient";        
    $result=mysqli_query($connect,$sql) or die("SQL a Query");
    $out="0";
    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_array($result);
        $out=number_format($row['count']);
    }
    echo $out;
}

if($action=='showdoctor'){
    $sql = "select count(AID) as count from tbldoctor";        
    $result=mysqli_query($connect,$sql) or die("SQL a Query");
    $out="0";
    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_array($result);
        $out=number_format($row['count']);
    }
    echo $out;
}

if($action=='showmalebed'){
    $sql = "select sum(Availability) as count from tblward where Type='Male'";        
    $result=mysqli_query($connect,$sql) or die("SQL a Query");
    $out="0";
    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_array($result);
        $out=number_format($row['count']);
    }
    echo $out;
}

if($action=='showfemalebed'){
    $sql = "select sum(Availability) as count from tblward where Type='Female'";        
    $result=mysqli_query($connect,$sql) or die("SQL a Query");
    $out="0";
    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_array($result);
        $out=number_format($row['count']);
    }
    echo $out;
}




?>