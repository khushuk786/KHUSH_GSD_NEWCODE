<?php
include('config.php');

$action = $_POST["action"];

if($action == 'show'){  
    $search = $_POST['search'];
    $a = "";
    if($search != ''){  
        $a = " where Name like '%$search%' or Code like '%$search%'";
    }      
    
    $sql = "select * from tblteam".$a;
    $result=mysqli_query($connect,$sql) or die("SQL a Query");
    $out="";

    if(mysqli_num_rows($result) > 0){
        $out.='
        <table class="table table-hover table-bordered mb-0">
        <thead>
        <tr> 
            <th width="7%;">No</th> 
            <th>Team Code</th>  
            <th>Team Name</th> 
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
                <td>{$row["Code"]}</td>
                <td>{$row["Name"]}</td>
                <td class='text-center'>
                    <a data-bs-toggle='dropdown'>
                        <span class='text-primary' style='cursor:pointer;'>o o o</span>
                    </a>
                    <ul class='dropdown-menu dropdown-menu-end dropdown-menu-arrow'>
                        <li>
                            <a href='#' id='btnedit' class='dropdown-item'
                                data-aid='{$row['AID']}'
                                data-code='{$row['Code']}'
                                data-name='{$row['Name']}'>
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
            <th>Team Code</th>  
            <th>Team Name</th> 
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
    $code = $_POST["code"];
    $name = $_POST["name"];
    $sql = 'insert into tblteam (Code, Name) values ("'.$code.'","'.$name.'")';
    if(mysqli_query($connect,$sql)){
        save_log($_SESSION['clinic_username']." added new team (".$name.")");
        echo 1;
    }else{
        echo 0;
    }
}

if($action == 'delete'){
    $aid = $_POST["aid"];
    $name = $_POST["name"];
    $sql = "delete from tblteam where AID={$aid}";
    if(mysqli_query($connect,$sql)){
        save_log($_SESSION['clinic_username']." deleted a team (".$name.")");
        echo 1;
    }else{
        echo 0;
    }    
}

if($action == 'edit'){
    $aid = $_POST["eaid"];
    $code = $_POST["ecode"];
    $name = $_POST["ename"];
    $sql = 'update tblteam set Name="'.$name.'",Code="'.$code.'" where AID='.$aid;
    if(mysqli_query($connect,$sql)){
        save_log($_SESSION['clinic_username']." edited a team (".$name.")");
        echo 1;
    }else{
        echo $sql;
    }
}


?>