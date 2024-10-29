<?php
include('config.php');

$action = $_POST["action"];

if($action == 'show'){  
    $search = $_POST['search'];
    $a = "";
    if($search != ''){  
        $a = " where Name like '%$search%'";
    }      
    
    $sql = "select * from tblward".$a;
    $result=mysqli_query($connect,$sql) or die("SQL a Query");
    $out="";

    if(mysqli_num_rows($result) > 0){
        $out.='
        <table class="table table-hover table-bordered mb-0">
        <thead>
        <tr> 
            <th width="7%;">No</th> 
            <th>Ward Name</th> 
            <th>Ward Type</th>
            <th>Ward Capacity</th>
            <th>Ward Availability</th>
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
                <td>{$row["Type"]}</td>
                <td>{$row["Capacity"]}</td>
                <td>{$row["Availability"]}</td>
                <td class='text-center'>
                    <a data-bs-toggle='dropdown'>
                        <span class='text-primary' style='cursor:pointer;'>o o o</span>
                    </a>
                    <ul class='dropdown-menu dropdown-menu-end dropdown-menu-arrow'>
                        <li>
                            <a href='#' id='btnedit' class='dropdown-item'
                                data-aid='{$row['AID']}'
                                data-name='{$row['Name']}'
                                data-type='{$row['Type']}'
                                data-capacity='{$row['Capacity']}'>
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
            <th>Ward Name</th> 
            <th>Ward Type</th>
            <th>Ward Capacity</th>
            <th>Ward Availability</th>
            <th width="10%;" class="text-center">Action</th>            
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

if($action == 'save'){
    $name = $_POST["name"];
    $type = $_POST["type"];
    $capacity = $_POST["capacity"];
    $sql = 'insert into tblward (Name, Type, Capacity, Availability) values ("'.$name.'","'.$type.'",'.$capacity.','.$capacity.')';
    if(mysqli_query($connect,$sql)){

        save_log($_SESSION['clinic_username']." added new ward (".$name.")");
        echo 1;
    }else{
        echo $sql;
    }
}

if($action == 'delete'){
    $aid = $_POST["aid"];
    $name = $_POST["name"];
    $sql = "delete from tblward where AID={$aid}";
    if(mysqli_query($connect,$sql)){

        save_log($_SESSION['clinic_username']." deleted a ward (".$name.")");
        echo 1;
    }else{
        echo 0;
    }    
}

if($action == 'edit'){
    $aid = $_POST["eaid"];
    $name = $_POST["ename"];
    $type = $_POST["etype"];
    $capacity = $_POST["ecapacity"];
    $sql = 'update tblward set Name="'.$name.'", Type="'.$type.'", Capacity='.$capacity.' where AID='.$aid;
    if(mysqli_query($connect,$sql)){

        save_log($_SESSION['clinic_username']." edited a ward (".$name.")");
        echo 1;
    }else{
        echo $sql;
    }
}

?>