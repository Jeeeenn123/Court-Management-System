<?php
    include "../db_connect.php";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $username = $_POST['username'];
        $fullname = $_POST['fullname'];
        $email = $_POST['email'];
        $phonenumber = $_POST['phonenumber'];
        $password_raw = $_POST['password'];
        $confirmPassword = $_POST['confirmPassword'];

        if($password_raw !== $confirmPassword){ //password confirmation
            
            echo "Password does not match";

            exit();
        }
        $password = password_hash($password_raw, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (username, fullname, email, phonenumber, password, role) VALUES (?,?,?,?,?,'user')"; //inserting values
        $stmt = $conn -> prepare($sql);

        $stmt -> bind_param ("sssss", $username, $fullname,  $email, $phonenumber, $password);

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
    <link rel="stylesheet" href="assets/css/register.css">
    <title>Document</title>
</head>
<body>
    
    <div class="form-container">
        <div class="container-inside">
            <h2>Register</h2>
            <form action="register.php" method="POST">
                <input type="text" name="username" placeholder="Username"> <br>    
                <input type="text" name="fullname" placeholder="Fullname"> <br>     
                <input type="text" name="email" id="" placeholder="Email"> <br>                
                <input type="text" name="phonenumber" id="" placeholder="Phonenumber"> <br>              
                <input type="password" name="password" id="" placeholder="Password"> <br>              
                <input type="password" name="confirmPassword" id="" placeholder="Confirm Password"> <br>        
                <input type="submit" value="Register">
                <p>Already have an Account? <a href="../index.php">Log In</a></p>
            </form>
        </div>
    </div>
</body>
</html>