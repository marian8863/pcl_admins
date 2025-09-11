<?php

//process.php

include 'database_connection.php';

if(isset($_POST["pk"]))
{
	$query = "
	UPDATE employee 
	SET ".$_POST['name']." = '".$_POST["value"]."' 
	WHERE id = '".$_POST["pk"]."'
	";


	if(mysqli_query($con,$query)){
   
		$message ="<h4 class='text-success' >Update successfully-1</h4>";
				echo "$message";
	}else{
		echo "Error :-".$sql.
	  "<br>"  .mysqli_error($con);
	}
}

?>