<?php
session_start();
include 'server.php';
$errors = array();

if (isset($_POST['login_user'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    if (empty($username)) { // เช็คว่ารับค่าเข้ามาหรือยัง
        array_push($errors, "Username is required");
    }

    if (empty($password)) {
        array_push($errors, "Password is required");
    }

    if (count($errors) == 0) { // ถ้าไม่มี error
        $password = md5($password);
        $query = "SELECT * FROM user WHERE username = '$username' AND password = '$password'";
        $result = mysqli_query($conn, $query);
        
        if (mysqli_num_rows($result) == 1) { // ถ้าพบ username and password ใน db
            $_SESSION['username'] = $username;
            $_SESSION['success'] = "Your are now logged in";
            header("location: index.php");
        } else {
            array_push($errors, "Wrong username/password combination");
            $_SESSION['error'] = "Wrong username or password";
            header("location: index.php");
        }
    }
}
?>