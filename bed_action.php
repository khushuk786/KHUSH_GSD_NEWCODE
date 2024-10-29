<?php
include('config.php');

$action = $_POST["action"];

if($action == 'show'){  
    $search = $_POST['search'];
    $a = "";
    if($search != ''){  
        $a = " and b.Number like '%$search%' or w.Name like '%$search%'";
    }      
    
    $sql = "select b.*, w.Name as wname from tblbed b, tblward w where b.WardID = w.AID ".$a;
    $result=mysqli_query($connect,$sql) or die("SQL a Query");
    $out="";

    if(mysqli_num_rows($result) > 0){
        $out.='
        <table class="table table-hover table-bordered mb-0">
        <thead>
        <tr> 
            <th width="7%;">No</th> 
            <th>Bed Number</th> 
            <th>Ward Name</th>
            <th>Availability</th>
            <th width="10%;" class="text-center">Action</th>      
        </tr>
        </thead>
        <tbody>
        ';
        $no = 0;
        while($row = mysqli_fetch_array($result)){
            $no=$no+1;
            if($row["Availability"] == 0) {
                $available = "Yes";
            }
            else {
                $available = "No";
            }
            $out.="<tr>
                <td>{$no}</td>
                <td>{$row["Number"]}</td>
                <td>{$row["wname"]}</td>
                <td>{$available}</td>
                <td class='text-center'>
                    <a data-bs-toggle='dropdown'>
                        <span class='text-primary' style='cursor:pointer;'>o o o</span>
                    </a>
                    <ul class='dropdown-menu dropdown-menu-end dropdown-menu-arrow'>
                        <li>
                            <a href='#' id='btnedit' class='dropdown-item'
                                data-aid='{$row['AID']}'
                                data-number='{$row['Number']}'
                                data-ward='{$row['WardID']}'
                                data-availability='{$row['Availability']}'>
                                <i class='la la-edit text-primary'></i>
                                Edit</a>
                        </li>
                        <li>
                            <hr class='dropdown-divider'>
                        </li>
                        <li>
                            <a href='#' id='btndelete' class='dropdown-item'
                            data-aid='{$row['AID']}'
                            data-number='{$row['Number']}'>
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
            <th>Bed Number</th> 
            <th>Ward Name</th>
            <th>Availability</th>
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
    $number = $_POST["number"];
    $ward = $_POST["ward"];
    $sql = 'insert into tblbed (Number, WardID, Availability) values ("'.$number.'",'.$ward.',0)';
    if(mysqli_query($connect,$sql)){
        save_log($_SESSION['clinic_username']." added a bed (".$number.")");
        echo 1;
    }else{
        echo $sql;
    }
}

if($action == 'delete'){
    $aid = $_POST["aid"];
    $number = $_POST["number"];
    $sql = "delete from tblbed where AID={$aid}";
    if(mysqli_query($connect,$sql)){
        save_log($_SESSION['clinic_username']." deleted a bed (".$number.")");
        echo 1;
    }else{
        echo 0;
    }    
}

if($action == 'edit'){
    $aid = $_POST["eaid"];
    $number = $_POST["enumber"];
    $ward = $_POST["eward"];
    $sql = 'update tblbed set Number="'.$number.'", WardID='.$ward.' where AID='.$aid;
    if(mysqli_query($connect,$sql)){
        save_log($_SESSION['clinic_username']." edited a bed (".$number.")");
        echo 1;
    }else{
        echo $sql;
    }
}

?>