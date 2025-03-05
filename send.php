<?php 
session_start();


if (!isset($_SESSION['username'])) {
    die("Error: User not logged in.");
}

$con = mysqli_connect("localhost", "root", "@mitalee2003","OneToOneChatApp");

$Sender= $_SESSION['username'];

if (!isset($_POST['receiver']) || !isset($_POST['message'])) {
    die("Error: Receiver or message not provided.");
   
    exit;
}

$Receiver = trim($_POST['receiver']);
$Message = trim($_POST['message']);

if(trim($Message) == ""){
    echo "Message cant't be empty";
    exit;
}

$sql = "insert into chat(Sender,Receiver,Message) values('$Sender','$Receiver', '$Message')";

 if(mysqli_query($con, $sql)){
    echo "Message sent";
 }
 else{
    echo "Error:".mysqli_error($con);
 }

 mysqli_close($con);

 ?>


