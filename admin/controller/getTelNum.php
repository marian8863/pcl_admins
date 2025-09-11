<?php
include_once("../../config.php");
if(isset($_POST['users'])){
    $id = $_POST['users'];

    $sql = "SELECT * FROM `users`  WHERE `id` = '$id'";
    $result = mysqli_query($con, $sql);
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
        echo '<option  value="'.$row["id"].'" required>'.$row["phone"].'</option>';
        }
    }else{
        echo '<option value="null"   selected disabled>-- No tp number --</option>';
    }
}





?>