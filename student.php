<?php 
require_once "config.php";

/*$dbhost = 'localhost';
         $dbuser = 'student';
         $dbpass = 'Student$1';
         $dbname = 'academics';
         $link = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
   
         if(! $link ){
            die('Could not connect: ' . mysqli_error());
         }
         echo 'Connected successfully';*/
	session_start();

function exm($input)
{
    echo "$input[0]";
}


if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["val"] == "1"){
 
    if(empty(trim($_POST["id"]))){
        $id_err = "Please enter id.";
    } else{
        $id = trim($_POST["id"]);
    }

    if(empty(trim($_POST["quan"]))){
        $quan_err = "Please enter your quan.";
    } else{
        $quan = trim($_POST["quan"]);
    }
    
    if(empty($id_err) && empty($quan_err)){
        $sql = "SELECT * FROM inventory WHERE id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_s);
            
            // Set parameters
            $param_s = $id;
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if rollno exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $name, $category, $description, $quantable);
                    if(mysqli_stmt_fetch($stmt)){
                        echo "Quantable = ".$quan;
                        if($quantable < $quan)
                        {
                            echo "Only $quantable of $id are available currently";
                        }
                        else
                        {
                            $sql = "UPDATE inventory SET quan = ? WHERE id = ?";
                            echo "$quan - $quantable";
                            if($stmt = mysqli_prepare($link, $sql)){
                                mysqli_stmt_bind_param($stmt, "is", $param_q, $param_s);
                                $param_s = $id;
                                $param_q = $quantable - $quan;
                                mysqli_stmt_execute($stmt);
                            }

                        }
                    }
                    else
                    {
                        echo "Databasing error occured";
                    }

                } else{
                    // Display an error message if rollno doesn't exist
                    echo "This item is not present in the inventory presently";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        // Close statement
        mysqli_stmt_close($stmt);
    }
}

	$rollno = $_SESSION["rollno"];
	//echo "Hi ".$rollno."<br>"."Items in Inventory: <br>";

	//echo "Your grade details are: <br>";

	/*$sql = "SELECT rollno,course,grade FROM inventory WHERE rollno = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_rollno);
            
            // Set parameters
            $param_rollno = $rollno;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if rollno exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) >= 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $rollno, $course, $grade);
                    while(mysqli_stmt_fetch($stmt)){
                        echo "COURSE: ".$course." GRADE: ".$grade."<br>";
                    }
                
                } else{
                    // Display an error message if rollno doesn't exist
                    $rollno_err = "No account found with that rollno.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);

*/        mysqli_close($conn);


 ?>

 <!DOCTYPE html>
<html lang="en">
<head>
<title>User Page</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/vendor/animate/animate.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/vendor/perfect-scrollbar/perfect-scrollbar.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util1.css">
	<link rel="stylesheet" type="text/css" href="css/main1.css">
</head>
<body>
    <div class="limiter">
		<div class="Top">
			<div class="ERA-logo js-tilt" data-tilt>
				<img src="images/img.png" alt="IMG">
			</div>

			<div class="usr">User Page</div>
			<!-- <div class="name">muskanag</div> -->
            <div class="identity"><?php echo $rollno; ?></div>
			<div class="btn-group">
                <form action="logout.php" method="post">
				<button class="login100-form-btn2">
				 <i class="fa fa-sign-out" aria-hidden="true"></i>
				</button>
            </form>
			</div>
				
        </div>
        <!-- here is the search function -->
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group <?php echo (!empty($rollno_err)) ? 'has-error' : ''; ?>">
            <label>ID</label>
            <input type="text" name="idsearch" class="form-control">
            <span class="help-block"><?php echo $id_err; ?></span>
        </div>
        <input type="hidden" name="val" value="0">
        <input type="submit" class="btn btn-primary" value="Search">
    </form>       
    <table style="width:100%">
        <!-- <tr>
          <th>id</th>
          <th>Name</th>
          <th>Category</th>
          <th>Description</th>
          <th>Quantity</th>
        </tr> -->

        <?php 

            if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["val"] == "0"){
 
            if(empty(trim($_POST["idsearch"]))){
                $id_err = "Please enter id.";
            } else{
                $idsearch = trim($_POST["idsearch"]);
            }
            $sql = "SELECT * FROM inventory WHERE MATCH(id, name, category) AGAINST(?)";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_s);
            
            // Set parameters
            $param_s = $idsearch;
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if rollno exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) >= 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $name, $category, $description, $quan);
                    while(mysqli_stmt_fetch($stmt)){
                        echo"<tr>
                            <td>$id</td>                        
                            <td>$name</td>
                            <td>$category</td>
                            <td>$description</td>
                            <td>$quan</td></tr>";
                        //echo "NAME: ".$name." DEsp ".$description."Quan".$quan."<br>";
                    }
                    /*else
                        echo "OOPS";*/
                } else{
                    // Display an error message if rollno doesn't exist
                    $rollno_err = "No account found with that rollno.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        }
        // Close statement
        mysqli_stmt_close($stmt);
        ?>
    </table>

    <div class="wrapper">
        <h2>Login</h2>
        <p>Please fill in entries to issue an item.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($rollno_err)) ? 'has-error' : ''; ?>">
                <label>ID</label>
                <input type="text" name="id" class="form-control">
                <span class="help-block"><?php echo $id_err; ?></span>
            </div>

            <div class="form-group <?php echo (!empty($rollno_err)) ? 'has-error' : ''; ?>">
                <label>Quantity</label>
                <input type="number" name="quan" class="form-control">
                <span class="help-block"><?php echo $quan_err; ?></span>
            </div>    
            <input type="hidden" name="val" value="1">
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Issue">
            </div>

        </form>
    </div>    
</body>
</html>