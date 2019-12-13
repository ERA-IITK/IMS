<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$rollno = $password = $confirm_password = $role = "";
$rollno_err = $password_err = $confirm_password_err = $role_err = "";
 

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate rollno
    echo $_POST["role"];
    if(empty(trim($_POST["rollno"]))){
        $rollno_err = "Please enter a rollno.";
    } else{
        // Prepare a select statement
        $sql = "SELECT * FROM users WHERE rollno = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_rollno);
            
            // Set parameters
            $param_rollno = trim($_POST["rollno"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $rollno_err = "This rollno is already taken.";
                } else{
                    $rollno = trim($_POST["rollno"]);
                    // $role= $_POST["role"];
                    // $password=$_POST["password"];
                    // $confirm_password=$_POST["confirm_password"];
                    // INSERT INTO users (rollno, password, role)
                    // VALUES ($rollno, $password, $role); 
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        $rollno = trim($_POST["rollno"]);
        mysqli_stmt_close($stmt);
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } //elseif(strlen(trim($_POST["password"])) < 6){
        //$password_err = "Password must have atleast 6 characters.";}
    else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    if(empty($_POST["role"])){
        $role_err = "Please select a role";
    } else{
        $role = $_POST["role"];
    }
    
    // Check input errors before inserting in database
    if(empty($rollno_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO users (rollno, password, role) VALUES ('$rollno', '$password' , '$role' )";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $param_rollno, $param_password, $param_role);
            
            // Set parameters
            echo "$rollno,$role,$password";
            $param_rollno = $rollno;
            $param_role = $role;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: login.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Sign Up</h2>
        <p>Please fill this form to create an account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($rollno_err)) ? 'has-error' : ''; ?>">
                <label>rollno</label>
                <input type="text" name="rollno" class="form-control" value="<?php echo $rollno; ?>">
                <span class="help-block"><?php echo $rollno_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <label>Role</label>
                    <select name="role">
                      <option value="admin">Admin</option>
                      <option value="student">Student</option>
                    </select> 
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </form>
    </div>    
</body>
</html>