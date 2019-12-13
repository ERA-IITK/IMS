<?php
session_start();
 
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    if($_SESSION["role"] == 'admin')
        header("location: admin.php");
    else if($_SESSION["role"] == 'student')
        header("location: student.php");
  exit;
}

require_once "config.php";
 
$rollno = $password = "";
$rollno_err = $password_err = "";
 
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    if(empty(trim($_POST["rollno"]))){
        $rollno_err = "Please enter rollno.";
        echo $rollno_err;
    } else{
        $rollno = trim($_POST["rollno"]);
        if(is_numeric($rollno) != 1){
            $rollno_err = "Please enter a valid rollno - a number";
            echo "wrong";
        }
    }
    
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    if((empty($rollno_err) && empty($password_err))){
        $sql = "SELECT rollno, password, role FROM users WHERE rollno = $rollno";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_rollno);
            
            $param_rollno = $rollno;
            // $role="student";
            // echo $rollno;
            // echo $password;
            // echo "hi";
            
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    mysqli_stmt_bind_result($stmt, $rollno, $hashed_password , $role);
                    if(mysqli_stmt_fetch($stmt)){
                        
                        if($password == $hashed_password){
                            session_start();
                            // echo $hashed_password;
                            // echo $role;
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["rollno"] = $rollno;
                            $_SESSION["role"] = $role;
                                if($role == "student") {
                                    header("location: student.php");
                                }
                                else if($role == "admin") {
                                    header("location: admin.php?edit=$rollno");
                                }
                                else {
                                    header("location: welcome.php");                                    
                                }
                        } else{
                            //$password_err = $hashed_password;
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    $rollno_err = "No account found with that rollno.";
                    echo $rollno_err;
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        mysqli_stmt_close($stmt);
    }
    mysqli_close($link);
    
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login V1</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body bgcolor= "#3c5280">
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-pic js-tilt" data-tilt>
					<img src="images/img-01.png" alt="IMG">
				</div>

				<form class="login100-form validate-form" action="login.php" method="post">
					<span class="login100-form-title">
						Member Login
					</span>

					<div class="wrap-input100 validate-input" data-validate = "IITK Roll Number Required" >
						<input class="input100" type="text" name="rollno" placeholder="Roll no" >
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-user-o" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Password is required">
						<input class="input100" type="password" name="password" placeholder="Password">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>
					
					<div class="container-login100-form-btn">
						<input class="login100-form-btn" type="submit" value="Login">
					</div>
					<p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
				</form>
			</div>
		</div>
	</div>
	
	

	
<!--===============================================================================================-->	
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/tilt/tilt.jquery.min.js"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>