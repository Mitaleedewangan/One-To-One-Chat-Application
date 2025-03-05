<?php
session_start();

$con = mysqli_connect("localhost", "root", "@mitalee2003", "OneToOneChatApp");

if (!$con) {
    die("Database connection failed: " . mysqli_connect_error());
}

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $sql = "UPDATE users SET Status = 'offline' WHERE username = '$username'";
    mysqli_query($con, $sql);
}

// Session destroy aur redirect
session_destroy();
mysqli_close($con);
?>
