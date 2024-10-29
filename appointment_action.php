<?php
include('config.php');

$action = $_POST["action"];

if($action == 'show'){  
    $search = $_POST['search'];
    $a = "";
    if($search != ''){  
        $a = " and Name like '%$search%'";
    }      
    
    $sql = "select a.*, p.Name as pname, d.Name as dname from tblappointment a, tblpatient p, tbldoctor d where a.PatientID = p.AID and a.DoctorID = d.AID".$a;
    $result=mysqli_query($connect,$sql) or die("SQL a Query");
    $out="";

    if(mysqli_num_rows($result) > 0){
        $out.='
        <table class="table table-hover table-bordered mb-0">
        <thead>
        <tr> 
            <th width="7%;">No</th> 
            <th>Patient Name</th> 
            <th>Doctor Name</th>
            <th>Notes</th>
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
                <td>{$row["pname"]}</td>
                <td>{$row["dname"]}</td>
                <td>{$row["Notes"]}</td>
                <td>{$row["Date"]}</td>
                <td class='text-center'>
                    <a data-bs-toggle='dropdown'>
                        <span class='text-primary' style='cursor:pointer;'>o o o</span>
                    </a>
                    <ul class='dropdown-menu dropdown-menu-end dropdown-menu-arrow'>
                        <li>
                            <a href='#' id='btnedit' class='dropdown-item'
                                data-aid='{$row['AID']}'
                                data-patient='{$row['PatientID']}'
                                data-doctor='{$row['DoctorID']}'
                                data-notes='{$row['Notes']}'
                                data-dt='{$row['Date']}'>
                                <i class='la la-edit text-primary'></i>
                                Edit</a>
                        </li>
                        <li>
                            <hr class='dropdown-divider'>
                        </li>
                        <li>
                            <a href='#' id='btndelete' class='dropdown-item'
                            data-aid='{$row['AID']}'>
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
            <th>Doctor Name</th>
            <th>Notes</th>
            <th>Date</th>
            <th width="10%;" class="text-center">Action</th>            
        </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="6" class="text-center">No data</td>
            </tr>
        </tbody>
        </table>';
        echo $out;
    }
}

if($action == 'save'){
    $patient = $_POST["patient"];
    $doctor = $_POST["doctor"];
    $notes = $_POST["notes"];
    $dt = $_POST["dt"];
    $sql = 'insert into tblappointment (PatientID, DoctorID, Notes, Date) values ('.$patient.','.$doctor.',"'.$notes.'","'.$dt.'")';
    if(mysqli_query($connect,$sql)){
        save_log($_SESSION['clinic_username']." added an appointment");
        echo 1;
    }else{
        echo $sql;
    }
}

if($action == 'delete'){
    $aid = $_POST["aid"];
    $sql = "delete from tblappointment where AID={$aid}";
    if(mysqli_query($connect,$sql)){
        save_log($_SESSION['clinic_username']." deleted an appointment");
        echo 1;
    }else{
        echo 0;
    }    
}

if($action == 'edit'){
    $aid = $_POST["eaid"];
    $patient = $_POST["epatient"];
    $doctor = $_POST["edoctor"];
    $notes = $_POST["enotes"];
    $dt = $_POST["edt"];
    $sql = 'update tblappointment set PatientID='.$patient.', DoctorID='.$doctor.', Notes="'.$notes.'", Date="'.$dt.'" where AID='.$aid;
    if(mysqli_query($connect,$sql)){
        save_log($_SESSION['clinic_username']." edited an appointment");
        echo 1;
    }else{
        echo $sql;
    }
}

if($action == 'showdoctor') {
    $patient_id = $_POST['patient_id'];
    $sql = "select d.* from tbldoctor d where d.TeamID=(SELECT TeamID from tblpatient where AID=$patient_id)";
    $result=mysqli_query($connect,$sql) or die("Query fail.");
    $out="<option value=''>Select Doctor</option>";
    while($row = mysqli_fetch_array($result)){
        $out.="<option value='{$row["AID"]}'>{$row["Name"]}</option>";
    }
    echo $out;  
}

if($action == 'showedoctor') {
    $patient_id = $_POST['patient_id'];
    $doctor_id = $_POST['doctor_id'];
    $sql = "select d.* from tbldoctor d where d.TeamID=(SELECT TeamID from tblpatient where AID=$patient_id)";
    $result=mysqli_query($connect,$sql) or die("Query fail.");
    $out="
    <option value=''>Select Doctor</option>";
    while($row = mysqli_fetch_array($result)){
        if($row["AID"]==$doctor_id)
        {
            $out.="<option value='{$row["AID"]}' selected>{$row["Name"]}</option>";
        }
        else {
            $out.="<option value='{$row["AID"]}'>{$row["Name"]}</option>";
        }
        
    }
    echo $out;  
}

?>