<?php
include "db.php";
if(isset($_POST['register'])){
    $username = trim($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $password);
    
    if($stmt->execute()) {
        header("Location: login.php?msg=Registration Successful");
    } else {
        $error = "Error: Username might be taken.";
    }
}
?>
<!DOCTYPE html>
<html>
<head><link rel="stylesheet" href="style.css"></head>
<body>
    <div class="container">
        <h2>Register</h2>
        <?php if(isset($error)) echo "<p style='color:#ef4444'>$error</p>"; ?>
        <form method="POST">
            <input type="text" name="username" placeholder="Choose Username" required>
            <input type="password" name="password" placeholder="Choose Password" required>
            <button name="register">Sign Up</button>
        </form>
    </div>
</body>
</html>