<?php
include('config.php');

$action = $_POST["action"];

if($action == 'show'){  
    unset($_SESSION["aid"]);
    $search = $_POST['search'];
    $a = "";
    if($search != ''){  
        $a = " and d.Name like '%$search%'";
    }      
    
    $sql = "select d.*, t.Name as tname from tbldoctor d, tblteam t where d.TeamID=t.AID ".$a;
    $result=mysqli_query($connect, $sql) or die("SQL a Query");
    $out="";

    if(mysqli_num_rows($result) > 0){
        $out.='
        <table class="table table-hover table-bordered mb-0">
        <thead>
        <tr> 
            <th width="7%;">No</th> 
            <th>Doctor Name</th>  
            <th>Grade</th>  
            <th>Doctor Team</th>
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
                <td>{$row["Grade"]}</td>
                <td>{$row["tname"]}</td>
                <td class='text-center'>
                    <a data-bs-toggle='dropdown'>
                        <span class='text-primary' style='cursor:pointer;'>o o o</span>
                    </a>
                    <ul class='dropdown-menu dropdown-menu-end dropdown-menu-arrow'>
                        <li>
                            <a href='#' id='btndetail' class='dropdown-item'
                                data-aid='{$row['AID']}'>
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
                                data-grade='{$row['Grade']}'
                                data-team='{$row['TeamID']}'>
                                <i class='la la-edit text-primary'></i>
                                Edit</a>
                        </li>
                        <li>
                            <hr class='dropdown-divider'>
                        </li>
                        <li>
                            <a href='#' id='btndelete' class='dropdown-item'
                            data-aid='{$row['AID']}'
                            data-name='{$row['Name']}'>
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
            <th>Doctor Name</th>  
            <th>Grade</th>  
            <th>Doctor Team</th> 
            <th width="10%;" class="text-center">Action</th>            
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

if($action == 'save'){
    $name = $_POST["name"];
    $grade = $_POST["grade"];
    $team = $_POST["team"];
    $sql = 'insert into tbldoctor (Name, Grade, TeamID) values ("'.$name.'","'.$grade.'",'.$team.')';
    if(mysqli_query($connect,$sql)){

        save_log($_SESSION['clinic_username']." added a new doctor (".$name.")");
        echo 1;
    }else{
        echo $sql;
    }
}

if($action == 'delete'){
    $aid = $_POST["aid"];
    $name = $_POST["name"];
    $sql = "delete from tbldoctor where AID={$aid}";
    if(mysqli_query($connect,$sql)){
        save_log($_SESSION['clinic_username']." deleted a doctor (".$name.")");
        echo 1;
    }else{
        echo 0;
    }    
}

if($action == 'edit'){
    $aid = $_POST["eaid"];
    $name = $_POST["ename"];
    $grade = $_POST["egrade"];
    $team = $_POST["eteam"];
    $sql = 'update tbldoctor set Name="'.$name.'",Grade="'.$grade.'",TeamID="'.$team.'" where AID='.$aid;
    if(mysqli_query($connect,$sql)){
        save_log($_SESSION['clinic_username']." edited a doctor (".$name.")");
        echo 1;
    }else{
        echo 0;
    }
}

if($action == "go_detail"){
    $doctorid = $_POST["aid"];
    $_SESSION["go_doctorid"] = $doctorid;
    echo 1;
}

if($action == 'showdetail') {
    $sqlinfo = "select d.*, t.Name as tname from tbldoctor d, tblteam t where d.TeamID=t.AID and d.AID={$_SESSION['go_doctorid']}";

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
                                <div class='col-lg-3 col-md-4 label'>Grade</div>
                                <div class='col-lg-9 col-md-8'>{$row["Grade"]}</div>
                            </div>

                            <div class='row'>
                                <div class='col-lg-3 col-md-4 label '>Doctor Team</div>
                                <div class='col-lg-9 col-md-8'>{$row["tname"]}</div>
                            </div>
                        </div>  
                    </div>

                    <div class='card profile-overview'>
                        <div class='card-body'>

                            <h5 class='card-title'>Patient Lists</h5>
                            <div id='show_detail'>";

    }

    $sql = "select p.*, w.Name as wname, b.Number as bname from tblpatient p, tblappointment a, tblward w, tblbed b where p.AID=a.PatientID and p.WardID = w.AID and p.BedID = b.AID and a.DoctorID = (select DoctorID from tblappointment a WHERE a.DoctorID={$_SESSION['go_doctorid']})";

    $result=mysqli_query($connect,$sql) or die("SQL a Query");

    if(mysqli_num_rows($result) > 0){
        $out.='
                <table class="table table-hover table-bordered mb-0">
                <thead>
                    <tr> 
                        <th width="7%;">No</th> 
                        <th>Patient Name</th>  
                        <th>Age</th>  
                        <th>Gender</th>  
                        <th>Ward</th>
                        <th>Bed</th>
                        <th width="10%;" class="text-center">Action</th>      
                    </tr>
                </thead>
                <tbody>';
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
                        <td class='text-center'>
                            <button id='btnappointment' class='btn btn-success'
                                        data-aid='{$row['AID']}'>
                                        See Detail</button>
        
                        </td>
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
            <th>Age</th>  
            <th>Gender</th>  
            <th>Ward</th>
            <th>Bed</th>
            <th width="10%;" class="text-center">Action</th>     
        </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="7" class="text-center">No data</td>
            </tr>
        </tbody>
        </table>
        ';
        echo $out;
    }
}

if($action == 'showgrade') {
    $team_id = $_POST['team_id'];
    $sql = "select * from tbldoctor where TeamID=$team_id and Grade='Consultant'";
    $result=mysqli_query($connect,$sql) or die("Query fail.");
    if(mysqli_num_rows($result) > 0){
        $out="<option value=''>Select Doctor Grade</option>
        <option value='Grade 1 Junior'>Grade 1 Junior</option>
        <option value='Other'>Other</option>";
    }
    else {
        $out="<option value=''>Select Doctor Grade</option>
        <option value='Consultant'>Consultant</option>
        <option value='Grade 1 Junior'>Grade 1 Junior</option>
        <option value='Other'>Other</option>";
    }
    echo $out;  
}

