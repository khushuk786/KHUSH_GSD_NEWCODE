<?php
include('config.php');

$action = $_POST["action"];

if($action == 'show'){  
    $search = $_POST['search'];
    $a = "";
    if($search != ''){  
        $a = " and l.Description like '%$search%'";
    }  
    
    $sql = "select l.*, a.Username as Username from tbllog l, tbladmin a where l.UserID=a.AID".$a;
    $result=mysqli_query($connect,$sql) or die("SQL a Query");
    $out="";

    if(mysqli_num_rows($result) > 0){
        $out.='
        <table class="table table-hover table-bordered mb-0">
        <thead>
        <tr> 
            <th width="7%;">No</th> 
            <th>Date</th> 
            <th>Description</th>
            <th>User Name</th>    
        </tr>
        </thead>
        <tbody>
        ';
        $no = 0;
        while($row = mysqli_fetch_array($result)){
            $no=$no+1;
            $out.="<tr>
                <td>{$no}</td>
                <td>{$row["Date"]}</td>
                <td>{$row["Description"]}</td>
                <td>{$row["Username"]}</td>
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
            <th>Date</th> 
            <th>Description</th>
            <th>User Name</th>          
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

?>