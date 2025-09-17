<?php
    include "../db_connect.php";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $username = $_POST['username'];
        $password = $_POST['password'];

        $hash = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO admins_backup (username, password, role) VALUES (?,?, 'admin')"; //inserting values
        $stmt = $conn -> prepare($sql);

        $stmt -> bind_param ("ss", $username, $hash);

        if($stmt -> execute()){
            echo "Success";
        }else{
            echo "Di ka register";
        }
        
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
    <div class="form-container">
        <div class="container-inside">
            <h2>Register</h2>
            <form action="register2.php" method="POST">
                <input type="text" name="username" placeholder="Username"> <br>    
                
                <input type="password" name="password" id="" placeholder="Password"> <br>
            
                <input type="submit" value="Register">
                <p>Already have an Account? <a href="index.php">Log In</a></p>
            </form>
        </div>
    </div>
</body>
</html>