<?php
session_start();

$con = mysqli_connect("localhost", "root","@mitalee2003","OneToOneChatApp");

$username = $_SESSION['username'];

$sql = "select  Username from users Where Status ='Online' AND username != '$username' ";
$result = mysqli_query($con,$sql);
while($row = mysqli_fetch_array($result)){

echo "<p class='onlinep' style='color:white'> " . $row['Username'] . "</p>";

}

?>