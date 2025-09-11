<?php
include_once("../../config.php");
if(isset($_POST['selectOption'])){
    $id = $_POST['selectOption'];

    $sql = "SELECT * FROM `select_an_option_desc`  WHERE `tm_id` = '$id'";
    $result = mysqli_query($con, $sql);
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
        echo '
            <input type="text" class="form-control" id="text" name="Dispo_Hours"  value="'.$row["tm_desc"].'"" >
        ';
        }
    }else{
        echo '
            <input type="text" class="form-control" placeholder="No Hours" disabled="disabled" >
        ';
    }
}





?>