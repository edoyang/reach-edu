<?php
session_start();

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header('Location: account.php');
    exit;
}

include('util/db.php');

$email = $password = "";
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT fname FROM user WHERE email = ? AND password = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ss", $email, $password);
        if ($stmt->execute()) {
            $stmt->store_result();

            if ($stmt->num_rows == 1) {
                $stmt->bind_result($fname);
                $stmt->fetch();
                $_SESSION['logged_in'] = true;
                $_SESSION['fname'] = $fname;

                header('Location: account.php');
                exit;
            } else {
                $message = "No account found with that email and password.";
            }
        } else {
            $message = "Oops! Something went wrong. Please try again later.";
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
    <title>Login</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
    <header></header>

    <h1>Login to Your Account</h1>

    <?php
    if (!empty($message)) {
        echo '<div>' . $message . '</div>';
    }
    ?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required><br><br>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required><br><br>

        <input type="submit" value="Login">
    </form>

    <footer></footer>
    <script src="script/header.js.php"></script>
</body>
</html>
