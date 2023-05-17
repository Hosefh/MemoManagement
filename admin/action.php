<?php 
    include "../dbcon.php";
    $output='';
    $sql = "SELECT * FROM faculty where department='".trim($_POST['department'])."';";
    $result = mysqli_query($conn,$sql);
    while ($row = mysqli_fetch_array($result)){
        $output .= '<option value="'.$row['name'].'" >'.$row['name'].' </option>';
    }
    echo $output;
?>