<?php
// Include config file
require_once "config.php";

 session_start();

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    

    if(isset($_GET['edit']))
    {
        $id=$_GET['edit'];
        // echo "HII";

        // $sql = "UPDATE inventory SET name='$name',description='$description',quan='$quan' WHERE id = $id";
        // echo $id;
        $sql = "SELECT * FROM inventory WHERE id = $id"; 
        if($stmt = mysqli_prepare($link, $sql)){
            echo "HII";
            // Bind variables to the prepared statement as parameters
            $id=$_POST["id"];
            $name=$_POST["name"];
            $description=$_POST["description"];
            $quantity=$_POST["quan"];
            $cont=$_POST["cont"];
            mysqli_stmt_bind_param($stmt, "ssss", $param_i, $param_n, $param_d, $param_q);
            // echo "HII";
            // Set parameters
            // $param_n = $name;
            // $param_d = $description;
            // $param_q = $quan;
            // $param_i = $id;
            echo $param_i;
            $name=$_POST['name'];
            $description=$_POST['description'];
            $quan=$_POST['quan'];   
            if(!empty($name)){
                $sql = "UPDATE inventory SET name='$name',description='$description',quan='$quan' WHERE id = $id";
                $stmt = mysqli_prepare($link, $sql);
                echo $name;
                if(mysqli_stmt_execute($stmt)){
                    header("location: admin.php");
                    // echo "HII";
                } 
            }

            // Attempt to execute the prepared statement
            // if(mysqli_stmt_execute($stmt)){
            //     header("location: admin.php");
            //     // echo "HII";
            // } 
        }
        // Close statement
        mysqli_stmt_close($stmt);
    }
    else
    {


    $id = $_GET["edit"];
    echo $id;
        $sql = "SELECT * FROM inventory WHERE id = $id";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_id);
            
            // Set parameters
            $param_id = trim($id);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    mysqli_stmt_bind_result($stmt, $id, $name, $description, $quan);
                    if(mysqli_stmt_fetch($stmt)){
                        $_SESSION["name"] = $name;
                        $_SESSION["id"] = $id;
                        $_SESSION["description"] = $description;
                        $_SESSION["quan"] = $quan;
                    }
                } else{
                echo "Oops! Something went wrong. Please try again later.";
                }
            }
         
            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
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
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
<div class="limiter">
		<div class="Top">
			<div class="ERA-logo js-tilt" data-tilt>
				<img src="images/img.png" alt="IMG">
			</div>

			<div class="admin">Update details</div>
			<!-- <div class="name">muskanag</div> -->
            <div class="identity"><?php echo $rollno; ?></div>
			<div class="btn-group">
            <form action="logout.php" method="post">
				<input class="login100-form-btn4" type="submit" value="LOGOUT">
				 <!-- <i class="fa fa-sign-out" aria-hidden="true"></i> -->
            </form>
			</div>
				
		</div>
    <div class="wrapper">
        <!-- <h2>Update details</h2> -->
        <?php $id = $_GET["edit"]; ?>
        <p>Please update the details for item no - <?php echo $id; ?></p>
        <form action="updatedet.php" method="post">
            
        </table>
    <form action="admin.php" method="post">
    <h1 class="Add-a-Component1"><center>Upadte</center></h1>
		<div class="container-table1002">
			<div class="wrap-table1002">
				<div class="table1002">
					<table>
						<thead>
							<tr class="table100-head2">
								<th class="column1">Code</th>
								<th class="column2">Name</th>
								<th class="column3">Description</th>
								<th class="column4">Quantity</th>
								<th class="column5">Update</th>
							</tr>
						</thead>
                        <tbody>
						<tr>
						    <form action="updatedet.php" method="post">
								<td class="column1"><input type="text" name="id" placeholder="<?php echo $id; ?>"></td>
								<td class="column2"><input type="text" name="name" placeholder="Name" value="<?php echo $name; ?>"></td>
								<td class="column3"><input type="text" name="description" placeholder="Description" value="<?php echo $description; ?>"></td>
								<td class="column4"><input type="text" name="quan" placeholder="Quantity" value="<?php echo $quan; ?>"></td>
                                <input type="hidden" name="cont" value='0'>
								<td class="column5"><input action='admin.php' class="login100-form-btn" type="submit" value="Add"></td>
							</form>
							</tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
</body>
</html>