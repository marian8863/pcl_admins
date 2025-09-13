<?php
session_start();

// database connection
// define('DB_HOST', 'pcl_admins.pariscablimousine.com');
// define('DB_USER','c1987705c ');
// define('DB_PASS','7u33gvqUWtktw25');
// define('DB_NAME','c1987705c_admin');




// $con=mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
// if (mysqli_connect_errno()){
//   }else{
//   }
//  $con = mysqli_connect('localhost', 'root', '', 'pcl_admin');
//   $con = mysqli_connect('localhost','ceadhzdi_cedar', 'JKjayanth96@', 'ceadhzdi_cedar');

$con = mysqli_connect('localhost','c1987705c', '7u33gvqUWtktw25', 'c1987705c_admin');
  
// 8uy7gtf
  // variable declaration
	$username = "";
	$email    = "";
	$errors   = array(); 

	// call the register() function if register_btn is clicked
	if (isset($_POST['register_btn'])) {
		register();
	}

	// call the login() function if register_btn is clicked
	if (isset($_POST['login_btn'])) {
		login();
	}

	if (isset($_GET['logout'])) {
		session_destroy();
		unset($_SESSION['user']);
		header("location: admin/index");
	}

	// REGISTER USER
	function register(){
		global $con, $errors;

		// receive all input values from the form
		$username    =  e($_POST['username']);
		$email       =  e($_POST['email']);
		$phone = e($_POST['phone']);
		$password_1  =  e($_POST['password_1']);
		$password_2  =  e($_POST['password_2']);

		// form validation: ensure that the form is correctly filled
		if (empty($username)) { 
			array_push($errors, "Username is required"); 
		}
		if (empty($email)) { 
			array_push($errors, "Email is required"); 
		}
	if (empty($phone)) {
    array_push($errors, "Phone number is required");
} else {
    // Remove spaces, dashes, and brackets for validation & storage
    $clean_phone = preg_replace('/[\s\-\(\)]/', '', $phone);

    if (!preg_match('/^\+?[0-9]{7,15}$/', $clean_phone)) {
        array_push($errors, "Invalid phone number format");
    } else {
        // Use $clean_phone when saving to DB
        $phone = $clean_phone;
    }
}

		if (empty($password_1)) { 
			array_push($errors, "Password is required"); 
		}
		if ($password_1 != $password_2) {
			array_push($errors, "The two passwords do not match");
		}

		// register user if there are no errors in the form
		if (count($errors) == 0) {
			$password = md5($password_1);//encrypt the password before saving in the database

			if (isset($_POST['user_type'])) {
				$user_type = e($_POST['user_type']);
				$query = "INSERT INTO users (username, email, phone, user_type, password) 
						VALUES('$username', '$email', '$phone', '$user_type', '$password')";
				mysqli_query($con, $query);
				$_SESSION['success']  = "New user successfully created!!";
				header('location: index');
			}else{
				$query = "INSERT INTO users (username, email,phone, user_type, password) 
						  VALUES('$username', '$email','$phone', 'user', '$password')";
				mysqli_query($con, $query);

				// get id of the created user
				$logged_in_user_id = mysqli_insert_id($con);

				$_SESSION['user'] = getUserById($logged_in_user_id); // put logged in user in session
				$_SESSION['success']  = "You are now logged in";
				header('location: index');				
			}

		}

	}

	// return user array from their id
	function getUserById($id){
		global $con;
		$query = "SELECT * FROM users WHERE id=" . $id;
		$result = mysqli_query($con, $query);

		$user = mysqli_fetch_assoc($result);
		return $user;
	}

	// LOGIN USER
	function login(){
		global $con, $username, $errors;

		// grap form values
		$username = e($_POST['username']);
		$password = e($_POST['password']);

		// make sure form is filled properly
		if (empty($username)) {
			array_push($errors, "Username is required");
		}
		if (empty($password)) {
			array_push($errors, "Password is required");
		}

		// attempt login if no errors on form
		if (count($errors) == 0) {
			$password = md5($password);

			$query = "SELECT * FROM users WHERE username='$username' AND password='$password' LIMIT 1";
			$results = mysqli_query($con, $query);

			if (mysqli_num_rows($results) == 1) { // user found
				// check if user is admin or user
				$logged_in_user = mysqli_fetch_assoc($results);
				if ($logged_in_user['user_type'] == 'admin' || $logged_in_user['user_type'] == 'user_enties' || $logged_in_user['user_type'] == 'ADM'  || $logged_in_user['user_type'] == 'driver') {

					$_SESSION['user'] = $logged_in_user;
					$_SESSION['success']  = "You are now logged in";
					header('location: admin/');		  
				}
			}else {
				array_push($errors, "Wrong username/password combination");
			}
		}
	}

	function isLoggedIn()
	{
		if (isset($_SESSION['user'])) {
			return true;
		}else{
			return false;
		}
	}



	function isAdmin()
{
    if (isset($_SESSION['user']) && (
        $_SESSION['user']['user_type'] == 'admin' ||
        $_SESSION['user']['user_type'] == 'user_enties' ||
        $_SESSION['user']['user_type'] == 'ADM' ||
        $_SESSION['user']['user_type'] == 'driver'
    )) {
        return true;
    } else {
        return false;
    }
}


	// escape string
	function e($val){
		global $con;
		return mysqli_real_escape_string($con, trim($val));
	}

	function display_error() {
		global $errors;

		if (count($errors) > 0){
			echo '<div class="error alert alert-danger rounded-pill border-0 shadow-sm px-4">';
				foreach ($errors as $error){
					echo $error .'<br>';
				}
			echo '</div>';
		}
	}



	



?>
