<?php
include('config.php');

$action = $_POST["action"];

if($action == 'show'){  
    unset($_SESSION["aid"]);
    $search = $_POST['search'];
    $a = "";
    if($search != ''){  
        $a = " and p.Name like '%$search%'";
    }      
    
    $sql = "select p.*, t.Name as tname, b.Number as bname, w.Name as wname, w.Availability as wavailability from tblpatient p, tblteam t, tblward w, tblbed b where p.TeamID=t.AID and p.WardID=w.AID and p.BedID=b.AID".$a;
    $result=mysqli_query($connect,$sql) or die("SQL a Query");
    $out="";

    if(mysqli_num_rows($result) > 0){
        $out.='
        <table class="table table-hover table-bordered mb-0">
        <thead>
        <tr> 
            <th width="7%;">No</th> 
            <th>Patient Name</th>  
            <th>DOB</th>  
            <th>Gender</th>  
            <th>Ward</th>  
            <th>Bed</th> 
            <th>Doctor Team</th>
            <th>Date</th>
            <th width="10%;" class="text-center">Action</th>      
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
                <td>{$row["Age"]}</td>
                <td>{$row["Gender"]}</td>
                <td>{$row["wname"]}</td>
                <td>{$row["bname"]}</td>
                <td>{$row["tname"]}</td>
                <td>{$row["RegisterDate"]}</td>
                <td class='text-center'>
                    <a data-bs-toggle='dropdown'>
                        <span class='text-primary' style='cursor:pointer;'>o o o</span>
                    </a>
                    <ul class='dropdown-menu dropdown-menu-end dropdown-menu-arrow'>
                        <li>
                            <a href='#' id='btndetail' class='dropdown-item'
                                data-aid='{$row['AID']}'
                                data-ward='{$row['WardID']}'
                                data-wavailability = '{$row['wavailability']}'
                                data-bed='{$row['BedID']}'>
                                <i class='la la-edit text-primary'></i>
                                Detail</a>
                        </li>
                        <li>
                            <hr class='dropdown-divider'>
                        </li>
                        <li>
                            <a href='#' id='btnedit' class='dropdown-item'
                                data-aid='{$row['AID']}'
                                data-name='{$row['Name']}'
                                data-age='{$row['Age']}'
                                data-gender='{$row['Gender']}'
                                data-ward='{$row['WardID']}'
                                data-wavailability = '{$row['wavailability']}'
                                data-bed='{$row['BedID']}'
                                data-bednumber='{$row['bname']}'
                                data-team='{$row['TeamID']}'
                                data-dt='{$row['RegisterDate']}'>
                                <i class='la la-edit text-primary'></i>
                                Edit</a>
                        </li>
                        <li>
                            <hr class='dropdown-divider'>
                        </li>
                        <li>
                            <a href='#' id='btndelete' class='dropdown-item'
                            data-aid='{$row['AID']}'
                            data-ward='{$row['WardID']}'
                            data-bed='{$row['BedID']}'>
                            <i class='la la-trash text-danger'></i>
                            Delete</a>
                        </li>
                    </ul>
                </td>
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
            <th>DOB</th>  
            <th>Gender</th>  
            <th>Ward</th>  
            <th>Bed</th> 
            <th>Doctor Team</th>
            <th>Date</th>
            <th width="10%;" class="text-center">Action</th>            
        </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="9" class="text-center">No data</td>
            </tr>
        </tbody>
        </table>
        ';
        echo $out;
    }
}

if($action == 'save'){
    $name = $_POST["name"];
    $age = $_POST["age"];
    $gender = $_POST["gender"];
    $ward = $_POST["ward"];
    $bed = $_POST["bed"];
    $team = $_POST["team"];
    $dt = $_POST["dt"];
    $wavailability = 0;

    $wardsql = "select * from tblward where AID=$ward";
    $result=mysqli_query($connect,$wardsql) or die("SQL a Query");

    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_array($result)){
            $wavailability = $row["Availability"]-1;
        }
        $updateward = 'update tblward set Availability='.$wavailability.' where AID='.$ward;
        mysqli_query($connect,$updateward);
    }

    $sql = 'insert into tblpatient (Name, Age, Gender, WardID, BedID, TeamID, RegisterDate) values ("'.$name.'",'.$age.',"'.$gender.'",'.$ward.','.$bed.','.$team.',"'.$dt.'")';
    if(mysqli_query($connect,$sql)){
        $updatebed = 'update tblbed set Availability=1 where AID='.$bed;
        mysqli_query($connect,$updatebed);

        save_log($_SESSION['clinic_username']." added new patient (".$name.")");
        echo 1;     
    }else{
        echo 0;
    }  
}

if($action == 'delete'){
    $aid = $_POST["aid"];
    $ward = $_POST["ward"];
    $bed = $_POST["bed"];

    $updatebed = 'update tblbed set Availability=0 where AID='.$bed;
    mysqli_query($connect,$updatebed);

    $log = "select * from tblpatient where AID=$aid";
    $result=mysqli_query($connect,$log) or die("SQL a Query");

    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_array($result)){
            save_log($_SESSION['clinic_username']." deleted a patient (".$row['Name'].")");
        }
    }

    $wavailability = 0;

    $wardsql = "select * from tblward where AID=$ward";
    $result=mysqli_query($connect,$wardsql) or die("SQL a Query");

    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_array($result)){
            $wavailability = $row["Availability"]+1;
        }
        $updateward = 'update tblward set Availability='.$wavailability.' where AID='.$ward;
        mysqli_query($connect,$updateward);
    }
    
    $sql = "delete from tblpatient where AID={$aid}";
    if(mysqli_query($connect,$sql)){
        echo 1;
    }else{
        echo 0;
    }   
    
    
}

if($action == 'edit'){
    $aid = $_POST["eaid"];
    $name = $_POST["ename"];
    $age = $_POST["eage"];
    $gender = $_POST["egender"];
    $ward = $_POST["eward"]; 
    $bed = $_POST["ebed"]; 
    $bed_old = $_POST["ebedold"];
    $team = $_POST["eteam"]; 
    $dt = $_POST["edt"];
    if($bed_old != $bed)
    {
        $updatebedold = 'update tblbed set Availability=0 where AID='.$bed_old;
        mysqli_query($connect,$updatebedold);
    }
    $updatebednew = 'update tblbed set Availability=1 where AID='.$bed;
    mysqli_query($connect,$updatebednew);
    
    $sql = 'update tblpatient set Name="'.$name.'",Age="'.$age.'",Gender="'.$gender.'",WardID="'.$ward.'",BedID="'.$bed.'",TeamID="'.$team.'",RegisterDate="'.$dt.'" where AID='.$aid;
    if(mysqli_query($connect,$sql)){
        save_log($_SESSION['clinic_username']." edited a patient (".$name.")");
        echo 1;
    }else{
        echo 0;
    }
}

if($action == "go_detail"){
    $patientid = $_POST["aid"];
    $ward = $_POST["ward"];
    $bed = $_POST["bed"];
    $available = $_POST["available"];
    $_SESSION["go_patientid"] = $patientid;
    $_SESSION["go_ward"] = $ward;
    $_SESSION["go_bed"] = $bed;
    $_SESSION["go_available"] = $available;
    echo 1;
}

if($action == 'showbed') {
    $ward_id = $_POST['ward_id'];
    $sql = "select * from tblbed where WardID=$ward_id and Availability=0";
    $result=mysqli_query($connect,$sql) or die("Query fail.");
    $out="<option value=''>Select Bed Number</option>";
    while($row = mysqli_fetch_array($result)){
        $out.="<option value='{$row["AID"]}'>{$row["Number"]}</option>";
    }
    echo $out;  
}

if($action == 'showebed') {
    $ward_id = $_POST['ward_id'];
    $bed_id = $_POST['bed_id'];
    $bed_number = $_POST['bed_number'];
    $sql = "select * from tblbed where WardID=$ward_id and Availability=0";
    $result=mysqli_query($connect,$sql) or die("Query fail.");
    $out="
    <option value=''>Select Bed Number</option>
    <option value='$bed_id' selected>$bed_number</option>";
    while($row = mysqli_fetch_array($result)){
        $out.="<option value='{$row["AID"]}'>{$row["Number"]}</option>";
    }
    echo $out;  
}

if($action == 'showdetail') {
    $sqlinfo = "select p.*, t.Name as tname, b.Number as bname, w.Name as wname from tblpatient p, tblteam t, tblward w, tblbed b where p.TeamID=t.AID and p.WardID=w.AID and p.BedID=b.AID and p.AID={$_SESSION['go_patientid']}";

    $resultinfo=mysqli_query($connect,$sqlinfo) or die("SQL a Query");
    
    $out="";

    $no = 0;
    while($row = mysqli_fetch_array($resultinfo)){
        $no=$no+1;

        $out.="<div class='card profile-overview'>
                        <div class='card-body'>
                            <h5 class='card-title'>Profile Details</h5>
                            <div class='row'>
                                <div class='col-lg-3 col-md-4 label '>Name</div>
                                <div class='col-lg-9 col-md-8'>{$row["Name"]}</div>
                            </div>

                            <div class='row'>
                                <div class='col-lg-3 col-md-4 label'>Age</div>
                                <div class='col-lg-9 col-md-8'>{$row["Age"]}</div>
                            </div>

                            <div class='row'>
                                <div class='col-lg-3 col-md-4 label '>Gender</div>
                                <div class='col-lg-9 col-md-8'>{$row["Gender"]}</div>
                            </div>

                            <div class='row'>
                                <div class='col-lg-3 col-md-4 label '>Ward Name</div>
                                <div class='col-lg-9 col-md-8'>{$row["wname"]}</div>
                            </div>

                            <div class='row'>
                                <div class='col-lg-3 col-md-4 label '>Bed Number</div>
                                <div class='col-lg-9 col-md-8'>{$row["bname"]}</div>
                            </div>

                            <div class='row'>
                                <div class='col-lg-3 col-md-4 label '>Doctor Team</div>
                                <div class='col-lg-9 col-md-8'>{$row["tname"]}</div>
                            </div>

                            <div class='row'>
                                <div class='col-lg-3 col-md-4 label '>Registration Date</div>
                                <div class='col-lg-9 col-md-8'>{$row["RegisterDate"]}</div>
                            </div>
                        </div>  
                    </div>

                    <div>
                        <button type='button' id='btnchangeward' class='btn btn-primary'>Change Ward</button>
                    </div>

                    <div class='card profile-overview'>
                        <div class='card-body'>

                            <h5 class='card-title'>Treatment Appointment</h5>
                            <div id='show_detail'>";

    }
    $sql = "select a.*, p.Name as pname, d.Name as dname, d.Grade as dgrade from tblappointment a, tblpatient p, tbldoctor d where a.DoctorID=d.AID and a.PatientID=p.AID and p.AID={$_SESSION['go_patientid']}";

    $result=mysqli_query($connect,$sql) or die("SQL a Query");

    if(mysqli_num_rows($result) > 0){
        $out.='
                <table class="table table-hover table-bordered mb-0">
                <thead>
                    <tr> 
                        <th width="7%;">No</th> 
                        <th>Doctor Name</th>
                        <th>Doctor Grade</th>  
                        <th>Notes</th>  
                        <th>Date</th>    
                    </tr>
                </thead>
                <tbody>';
        $no = 0;
        while($row = mysqli_fetch_array($result)){
            $no=$no+1;
            $out.="<tr>
                        <td>{$no}</td>
                        <td>{$row["dname"]}</td>
                        <td>{$row["dgrade"]}</td>
                        <td>{$row["Notes"]}</td>
                        <td>{$row["Date"]}</td>
                    </tr>";
        }

        $out.="</tbody>
                    </table>
                    </div>
                </div>
            </div>";

        echo $out; 
        
    }else{
    
    $out.='
        <table class="table table-hover table-bordered mb-0">
        <thead>
        <tr>
            <th width="7%;">No</th> 
            <th>Patient Name</th>  
            <th>Doctor Name</th>  
            <th>Notes</th>  
            <th>Date</th>
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

if($action == 'changeward') {
    $ward = $_POST['ward'];
    $bed = $_POST['bed'];

    if ($ward != $_SESSION["go_ward"])
    {
        $count_plus = $_SESSION["go_available"]+1;

        $wardsql = "select * from tblbed b, tblward w where b.AID=$bed and b.WardID=w.AID";
        $result=mysqli_query($connect,$wardsql) or die("SQL a Query");

        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_array($result)){
                $count_minus = $row["Availability"]-1;
            }
        }

        $sqlwardold = "update tblward set Availability=".$count_plus." where AID={$_SESSION["go_ward"]}";
        $sqlwardnew = "update tblward set Availability=".$count_minus." where AID=".$ward;

        mysqli_query($connect,$sqlwardold);
        mysqli_query($connect,$sqlwardnew);
    }
    

    $sql = "update tblpatient set WardID=".$ward.",BedID=".$bed." where AID={$_SESSION['go_patientid']}";
    if(mysqli_query($connect,$sql)){
        save_log($_SESSION['clinic_username']." change the ward from ".$_SESSION['go_ward']." (".$_SESSION['go_bed'].") to ".$ward." (".$bed.")");
        $sqlbedold = "update tblbed set Availability=0 where AID={$_SESSION["go_bed"]}";
        $sqlbednew = "update tblbed set Availability=1 where AID=".$bed;
        
        mysqli_query($connect,$sqlbedold);
        mysqli_query($connect,$sqlbednew);
        
        echo 1;
    }else{
        echo 0;
    }
}

?>