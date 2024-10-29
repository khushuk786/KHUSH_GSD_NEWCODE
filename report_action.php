<?php
include('config.php');

$action = $_POST["action"];

if($action == 'show'){  
    $search = $_POST['search'];
    $ward = $_POST['ward'];
    $a = "";
    if($search != ''){  
        $a = " and p.Name like '%$search%'";
    } 
    $b = "";
    if($ward >0){  
        $b = " and w.AID=$ward";
    }    
    
    $sql = "select p.*, b.Number as bname, w.Name as wname from tblpatient p, tblward w, tblbed b where p.WardID=w.AID and p.BedID=b.AID".$a.$b;
    $result=mysqli_query($connect,$sql) or die("SQL a Query");
    $out="";

    if(mysqli_num_rows($result) > 0){
        $out.='
        <table class="table table-hover table-bordered mb-0">
        <thead>
        <tr> 
            <th width="7%;">No</th> 
            <th>Patient Name</th> 
            <th>Age</th>
            <th>Ward Name</th>
            <th>Bed Number</th>     
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
                <td>{$row["wname"]}</td>
                <td>{$row["bname"]}</td>
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
            <th>Age</th>
            <th>Ward Name</th>
            <th>Bed Number</th>           
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

if($action == 'showbyteam'){  
    $search = $_POST['search'];
    $team = $_POST['team'];
    $a = "";
    if($search != ''){  
        $a = " and p.Name like '%$search%'";
    } 
    $b = "";
    if($team >0){  
        $b = " and t.AID=$team";
    }    
    
    $sql = "select p.*, b.Number as bname, t.Name as tname, w.Name as wname from tblpatient p, tblward w, tblteam t, tblbed b where p.WardID=w.AID and p.BedID=b.AID and p.TeamID=t.AID".$a.$b;
    $result=mysqli_query($connect,$sql) or die("SQL a Query");
    $out="";

    if(mysqli_num_rows($result) > 0){
        $out.='
        <table class="table table-hover table-bordered mb-0">
        <thead>
        <tr> 
            <th width="7%;">No</th> 
            <th>Patient Name</th> 
            <th>Age</th>
            <th>Ward Name</th>
            <th>Bed Number</th> 
            <th>Team Name</th>     
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
                <td>{$row["wname"]}</td>
                <td>{$row["bname"]}</td>
                <td>{$row["tname"]}</td>
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
            <th>Age</th>
            <th>Ward Name</th>
            <th>Bed Number</th> 
            <th>Team Name</th>           
        </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="6" class="text-center">No data</td>
            </tr>
        </tbody>
        </table>
        ';
        echo $out;
    }
}

if($action == 'showbypatient') {
    $search = $_POST['search'];
    $patient = $_POST['patient'];
    $a = "";
    if($search != ''){  
        $a = " and d.Name like '%$search%'";
    } 
    $b = "";
    $out="";
    if($patient >0){  
        $b = " and p.AID=$patient";
        

        $sqlinfo = "select p.*, d.Name as dname, t.Name as tname, b.Number as bname, w.Name as wname from tblpatient p, tblteam t, tbldoctor d, tblward w, tblbed b where p.TeamID=t.AID and d.TeamID=t.AID and d.Grade='Consultant' and p.WardID=w.AID and p.BedID=b.AID".$a.$b;

        $resultinfo=mysqli_query($connect,$sqlinfo) or die("SQL a Query");
        
        

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
                                <div class='col-lg-3 col-md-4 label '>Responsible Consultant Doctor</div>
                                <div class='col-lg-9 col-md-8'>{$row["dname"]}</div>
                            </div>

                            <div class='row'>
                                <div class='col-lg-3 col-md-4 label '>Registration Date</div>
                                <div class='col-lg-9 col-md-8'>{$row["RegisterDate"]}</div>
                            </div>
                        </div>  
                    </div>";
        }

        $out.="<div class='card profile-overview'>
                            <div class='card-body'>

                                <h5 class='card-title'>Treatment Appointment</h5>
                                <div id='show_detail'>";
        $sql = "select a.*, p.Name as pname, d.Name as dname, d.Grade as dgrade from tblappointment a, tblpatient p, tbldoctor d where a.DoctorID=d.AID and a.PatientID=p.AID".$a.$b;

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
                <th>Doctor Name</th> 
                <th>Doctor Grade</th> 
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
    else {
        $out.="<div class='card profile-overview'>
                            <div class='card-body'>

                                <h5 class='card-title'>Treatment Appointment</h5>
                                <div id='show_detail'>";
        $sql = "select a.*, p.Name as pname, d.Name as dname, d.Grade as dgrade from tblappointment a, tblpatient p, tbldoctor d where a.DoctorID=d.AID and a.PatientID=p.AID".$a.$b;

        $result=mysqli_query($connect,$sql) or die("SQL a Query");

        if(mysqli_num_rows($result) > 0){
            $out.='
                    <table class="table table-hover table-bordered mb-0">
                    <thead>
                        <tr> 
                            <th width="7%;">No</th> 
                            <th>Patient Name</th>
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
                            <td>{$row["pname"]}</td>
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

    
}


?>