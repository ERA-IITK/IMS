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

    if(isset($_GET['edit'])){
        $rollno=$_GET['edit'];
    }

if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["val"] == "3")
{   
    if(isset($_GET['edit'])){
        $id=$_GET['edit'];
    }

    $sql = "DELETE FROM inventory WHERE id = $id";   
    if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $id);
            echo $id;
            $id = $_POST["id"];
            if(mysqli_stmt_execute($stmt)){
                header("location: admin.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }   
        mysqli_stmt_close($stmt);
        $_POST["val"]="0";
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


    mysqli_close($conn);


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

			<div class="admin">inventory</div>
			<!-- <div class="name">muskanag</div> -->
            <div class="identity"><?php echo $rollno; ?></div>
			<div class="btn-group">
            <form action="logout.php" method="post">
				<input class="login100-form-btn4" type="submit" value="LOGOUT">
				 <!-- <i class="fa fa-sign-out" aria-hidden="true"></i> -->
            </form>
			</div>
				
		</div>
<!-- 
    <form action="admin.php" method="post">
        <div class="form-group 
            <label>Search by id</label>
            <input type="text" name="idsearch" class="form-control">
            <span class="help-block"></span>
        </div>
        <input type="hidden" name="val" value="0">
        <input type="submit" class="btn btn-primary" value="Search">
    </form>       
    <table style="width:100%">
        <tr>
          <th>id</th>
          <th>Name</th>
          <th>Description</th>
          <th>Quantity</th>
        </tr> -->

    </table>
    <form action="admin.php" method="post">
    <h1 class="Add-a-Component"><center>Add Component</center></h1>
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
                                    #$query = "SELECT * FROM users";
                                    $sql = "SELECT * FROM inventory";
                                    if($stmt = mysqli_prepare($link, $sql)){
                                    
                                        if(mysqli_stmt_execute($stmt)){
                                            // Store result
                                            mysqli_stmt_store_result($stmt);
                                            
                                            mysqli_stmt_bind_result($stmt, $id, $name, $description, $quan);
                                            while(mysqli_stmt_fetch($stmt)){
                                                echo "<tr>";
                                                echo "<td>$id</td>";                        
                                                echo "<td>$name</td>";
                                                echo "<td>$description</td>";
                                                echo "<td>$quan</td>";
                                                echo "<form action='updatedet.php?edit=$id' method='get'>";
                                                echo '<td class="column5">
                                                    <input class="login100-form-btn" type="submit" value="Edit">
                                                </td>';
                                                echo "</form>";
                                                echo "<form action='admin.php?edit=$id' method='post'>";
                                                echo '<td class="column6">
                                                    <input class="login100-form-btn1" type="submit" value="Delete">
                                                    <input type="hidden" name="val" value="3">
                                                </td>';
                                                echo "</form>";
                                                echo "</tr>";
                                            }
                                        }
                                    }

                                    
                                    ?>
							</tbody>
					</table>
				</div>
			</div>
        </div>
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