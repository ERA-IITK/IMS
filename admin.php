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

    if($_SESSION["role"] == "student")
    {
        echo "Sorry! This page is only accessible to admins";
        exit;
    }

if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["val"] == "3")
{
    $sql = "DELETE FROM login WHERE rollno = ?";   
    if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_rollno);
            $param_rollno = $_POST["rno"];
            if(mysqli_stmt_execute($stmt)){
                header("location: admin.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }   
        mysqli_stmt_close($stmt);
}
if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["val"] == "2")
{
    $rno = trim($_POST["rollno"]);
    $role = $_POST["role"];
    $sql = "INSERT INTO login (rollno, password, role) VALUES (?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $param_rollno, $param_password, $param_role);
            
            // Set parameters
            echo "$rollno,$role,$password";
            $param_rollno = $rno;
            $param_role = $role;
            $param_password = password_hash($rno, PASSWORD_DEFAULT); // Creates a password hash
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: admin.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);

}

if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["val"] == "1"){
 
    if(empty(trim($_POST["id"]))){
        $id_err = "Please enter id.";
        echo $id_err;
    } else{
        $id = trim($_POST["id"]);
        echo $id;
    }

    if(empty(trim($_POST["name"]))){
        $name_err = "Please enter name.";
        echo $name_err;
    } else{
        $name = trim($_POST["name"]);
        echo $name;
    }

    if(empty(trim($_POST["description"]))){
        $description_err = "Please enter description.";
        echo $description_err;
    } else{
        $description = trim($_POST["description"]);
        echo $description;
    }
    
    if(empty(trim($_POST["quan"]))){
        $quan_err = "Please enter your quan.";
        echo $quan_err;
    } else{
        $quan = trim($_POST["quan"]);
        echo $quan;
    }
    
    if(empty($id_err) && empty($name_err) && empty($description_err) && empty($quan_err)){
        $sql = "INSERT INTO inventory (id, name, description, quan) VALUES ('$id', '$name', '$description', '$quan')";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssi", $param_id, $param_name, $param_desp, $param_quan);
            
            // Set parameters
            $param_id = $id;
            $param_name = $name;
            $param_desp = $description;
            // $param_cat = $cat;
            $param_quan = $quan;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: admin.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
        else
        {
            echo "Err";
        } 
        // Close statement
        mysqli_stmt_close($stmt);
        
    }
    else
    {
        echo 'error here!';
    }
}

	$rollno = $_SESSION["rollno"];
	// echo "Hi ".$rollno."<br>"."Items in Inventory: <br>";

	// echo "Your grade details are: <br>";

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
<title>ERA IMS</title>
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

			<div class="admin">Admin Page</div>
			<!-- <div class="name">muskanag</div> -->

			<div class="btn-group">
            <form action="logout.php" method="post">
				<button class="login100-form-btn2">
				 <i class="fa fa-sign-out" aria-hidden="true"></i>
				</button>
            </form>
			</div>
				
		</div>

    <!-- <form action="admin.php" method="post"> -->
        <div class="form-group <?php echo (!empty($rollno_err)) ? 'has-error' : ''; ?>">
            <label>Search by id</label>
            <input type="text" name="idsearch" class="form-control">
            <span class="help-block"><?php echo $id_err; ?></span>
        </div>
        <input type="hidden" name="val" value="0">
        <input type="submit" class="btn btn-primary" value="Search">
    <!-- </form>        -->
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
                        echo "<tr>
                            <td>$id</td>                        
                            <td>$name</td>
                            <td>$category</td>
                            <td>$description</td>
                            <td>$quan</td>
                            <td><form action='updatedet.php' method='post'>
                                    <input type='hidden' name='cont' value='$id'/>
                                    <input type='submit' name='btn' id='$id' value='Update'></form></td>
                            </tr>";
                    }
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
        
        // Close statement
        mysqli_stmt_close($stmt);
        ?>


    </table>
    <form action="admin.php" method="post">
    <h1><center>Add Component</center></h1>
		<div class="container-table1001">
			<div class="wrap-table1001">
				<div class="table1001">
					<table>
						<thead>
							<tr class="table100-head1">
								<th class="column1">Code</th>
								<th class="column2">Name</th>
								<th class="column3">Description</th>
								<th class="column4">Quantity</th>
								<th class="column5">Update</th>
							</tr>
						</thead>
                        <tbody>
								<tr>
									<form action="admin.php" method="post">
										<td class="column1"><input type="text" name="id" placeholder="###"></td>
										<td class="column2"><input type="text" name="name" placeholder="Name"></td>
										<td class="column3"><input type="text" name="description" placeholder="Description"></td>
										<td class="column4"><input type="text" name="quan" placeholder="Quantity"></td>
                                        <input type="hidden" name="val" value="1">
										<td class="column5"><input class="login100-form-btn" type="submit" value="Add"></td>
									</form>
								</tr>
								
							</tbody>
					</table>
				</div>
			</div>
		</div>

        <div class="container-table100">
			<div class="wrap-table100">
				<div class="table100">
					<table>
						<thead>
							<tr class="table100-head">
								<th class="column1">Code</th>
								<th class="column2">Name</th>
								<th class="column3">Description</th>
								<th class="column4">Quantity</th>
								<th class="column5">Edit</th>
								<th class="column6">Delete</th>
							</tr>
						</thead>
						<tbody>
								<!-- <tr> -->
                                <?php
                                    //$query = $mysqli->query("SELECT * FROM inventory");
                                    $query = "SELECT * FROM users";
                                    // echo $link;
                                    // $result = mysqli_prepare($link, $query);
                                    if($result = mysqli_prepare($link, $query)){
                                        // echo "1";
                                        /* fetch associative array */
                                        while ($row = $result->fetch_assoc()) {
                                            echo "1";
                                            echo '<tr>';
                                            // echo "1";
                                            echo '<form action="admin.php" method="post">';
                                                echo '<td class="column1">'.$row["rollno"].'</td>';
                                                echo '<td class="column2">'.$row["password"].'</td>';
                                                echo '<td class="column3">'.$row["role"].'</td>';
                                                // echo '<td class="column4">'.$row["quan"].'</td>';
                                                echo '<td class="column5">
                                                    <input class="login100-form-btn" type="submit" value="Edit">
                                                    <input type="hidden" name="val" value="3">
                                                </td>';
                                                echo '<td class="column6">
                                                    <input class="login100-form-btn" type="submit" value="Delete">
                                                    <input type="hidden" name="val" value="3">
                                                </td>';
                                            echo '</form>';
                                            echo '</tr>';
                                        }
                                    
                                        /* free result set */
                                        $result->free();
                                    }
                                    ?>
							</tbody>
					</table>
				</div>
			</div>
        </div>

        <!-- <h2> Add a person</h2>
        <form action="admin.php" method="post">
            <input type="text" name="rno">
            <div class="form-group">
                <label>Role</label>
                    <select name="role">
                      <option value="admin">Admin</option>
                      <option value="student">Student</option>
                    </select> 
            </div>
            <input type="hidden" name="val" value="2">
            <input type="submit" name="ad" value="Add">
        </form>

        <form action="admin.php" method="post">
            <input type="text" name="rno">
            <input type="hidden" name="val" value="3">
            <input type="submit" name="del" value="Delete">
        </form> -->
    </div>    

    <script src="vendor/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="js/main1.js"></script>

</body>
</html>