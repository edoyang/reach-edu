<?php

session_start();

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header('Location: account.php');
    exit;
}


include('util/db.php');

$fname = $lname = $message = $email = $password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "INSERT INTO user (fname, lname, email, password) VALUES (?, ?, ?, ?)";

    if($stmt = $conn->prepare($sql)){
        $stmt->bind_param("ssss", $fname, $lname, $email, $password);
        if($stmt->execute()){
            $message = "Registration Success";
        } else{
            $message = "Registration Failed" . $stmt->error;
        }

        $stmt->close();
    }
    
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
    <header></header>

    <form action="register.php" method="post">
        <label for="fname">First Name:</label>
        <input type="text" id="fname" name="fname" required><br><br>

        <label for="lname">Last Name:</label>
        <input type="text" id="lname" name="lname" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>

        <input type="submit" value="Register">
    </form>

    <div class="message-overlay">
        <p> <?=$message?> </p>
    </div>

    <footer></footer>
    <script src="script/header.js"></script>
</body>
</html>