<html>
<head>
<title>Login</title>
<style>

body{
    margin:0;
    padding:0;
    background-color: black;
    display: flex;
    align-items: center;
    justify-content: center;
}

form{
    width: 400px;
    height: 300px;
    background-color: white;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    font-size: 20px;
    border-radius: 15px;
    
}
input{
    width: 300px;
    height: 30px;
    border-radius: 5px;
    border:black
    outline: none;
    padding: 5px;
    margin-top: 10px;
    background-color: white;
    
}

button{
    width: 150px;
    height: 40px;
    border-radius: 5px;
    border: none;
    outline: none;
    padding: 5px;
    margin-top: 10px;
    background-color: green;
    color: white;
    font-size: 20px;
}

</style>
</head>
<body>
<Form action="" method="post">
UserId:<input type="text" name="name" placeholder="Enter UserId"><br>
Password:<input type="password" name="password" placeholder="Enter your Password"><br>

<button type="submit" name="login">Login</button>
</form>

</body>
</html>




<?php 

session_start();
$con = mysqli_connect("localhost","root", "@mitalee2003","OneToOneChatApp");

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $username = $_POST['name'];
    $password = $_POST['password'];

   echo $sql = "select * from users where Username = '$username' and Password='$password'";
    $result = mysqli_query($con,$sql);
    $user = mysqli_fetch_assoc($result);

    if($user){
      
        $_SESSION['username'] = $username;

        mysqli_query($con, "update users set status= 'online' where Username ='$username'");
        header("location: home.php");
        exit();
   
    }
    else{
        echo "Invalid Username or Password";
    }
}

?>