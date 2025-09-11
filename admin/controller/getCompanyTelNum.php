<?php
include_once("../../config.php");
if(isset($_POST['company_num'])){
    $id = $_POST['company_num'];

    $sql = "SELECT * FROM `company`  WHERE `c_id` = '$id'";
    $result = mysqli_query($con, $sql);
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
        echo '<option  value="'.$row["c_id"].'" required>'.$row["c_num"].'</option>';
        }
    }else{
        echo '<option value="null"   selected disabled>-- No tp number --</option>';
    }
}





?>