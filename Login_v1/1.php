<?php
    $con=mysqli_connect('localhost','muskan','12345678');

    if(!$con){
        echo 'Not Connected to database server';
    }

    if(!mysqli_select_db($con,'ims')){
        echo 'Data base not selected';
    }

    $Name=$_POST('rollno');
    $Password=$_POST('password');

    $sql="INSERT INTO users (rollno, password) VALUES ('$Name', '$Password')";
    if(!mysqli_query($con, $sql)){
        echo "not inserted";
    }
    else{
        echo "Inserted";
    }
?>


<html>
<head>
<title>Insert Form Data</title>
</head>
<body>
    <form action="1.php" method="post">
        Name: <input type="text" name="rollno" ><br/>
        Passwrd: <input type="password" name="password">   
        <input type="submit" value="Insert"> 
    </form>
</body>
</html>