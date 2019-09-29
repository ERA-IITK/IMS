<?php
// Include config file
require_once "config.php";

 session_start();

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    if($_POST["cont"] == '0')
    {

        $sql = "UPDATE inventory SET name=?, category=?,description=?,quan=? WHERE id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssis", $param_n, $param_c, $param_d, $param_q, $param_i);
            
            // Set parameters
            $param_n = $_POST["name"];
            $param_c = $_POST["category"];
            $param_d = $_POST["description"];
            $param_q = $_POST["quan"];
            $param_i = $_SESSION["id"];

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                header("location: admin.php");
            } 
        }
        // Close statement
        mysqli_stmt_close($stmt);
    }
    else
    {


    $id = $_POST["cont"];
    
        $sql = "SELECT * FROM inventory WHERE id = ?";
        
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
                    mysqli_stmt_bind_result($stmt, $id, $name, $category, $description, $quan);
                    if(mysqli_stmt_fetch($stmt)){
                        $_SESSION["name"] = $name;
                        $_SESSION["id"] = $id;
                        $_SESSION["category"] = $category;
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
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Update details</h2>
        <p>Please update the details for item no - <?php echo $id; ?></p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
              
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
            </div>
            <div class="form-group">
                <label>Category</label>
                <input type="text" name="category" class="form-control" value="<?php echo $category; ?>">
            </div>
            <div class="form-group">
                <label>Description</label>
                <input type="text" name="description" class="form-control" value="<?php echo $description; ?>">
            </div>
            <div class="form-group">
                <label>Quantity</label>
                <input type="text" name="quan" class="form-control" value="<?php echo $quan; ?>">
            </div>
            <input type="hidden" name="cont" value='0'>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Update">
            </div>
        </form>
    </div>    
</body>
</html>