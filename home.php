
<?php

session_start();

$con = mysqli_connect("localhost", "root", "@mitalee2003", "ONETOONECHATAPP");

$sender_id = $_SESSION['username'] ?? null;
$receiver_id = $_GET['receiver'] ?? null; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $message = $_POST['message'];
    mysqli_query($con, "INSERT INTO chat (Sender, Receiver, Message) VALUES ('$sender_id', '$receiver_id', '$message')");
}

$sql =  "SELECT * FROM chat
WHERE (Sender='$sender_id' AND Receiver='$receiver_id')
OR (Sender='$receiver_id' AND Receiver='$sender_id')
ORDER BY Msgid ASC";

$messages = mysqli_query($con, $sql);

if (!$messages) {
    die("SQL Error: " . mysqli_error($con));  // Debugging error
}
?>


<div id="chat-box">
    <?php while ($row = mysqli_fetch_assoc($messages)) { ?>
        <p>
            <strong><?php echo ($row['Sender'] == $sender_id) ? "You" : "User $receiver_id"; ?>:</strong>
            <?php echo htmlspecialchars($row['Message']); ?>
        </p>
    <?php } ?>
</div>



<!DOCTYPE html>
<html>
<head>
    <title>One To One Chat</title>
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
  $(document).ready(function(){
    $(".send_btn").click(function(){
    var m=$(".message1").val();
    var r=  $('.reciver').text();
    alert(m)
   // alert(m+" "+r);

         if (m.length ==0) {
        alert("Message can't be empty");
        return;
    }

      console.log("Receiver ID:", $("#receiver").val());

        $.post("send.php",{message:m,receiver:r},function(data){
               console.log("Server response:", data);
            alert(data);
            if (data.includes("Message sent")) {
            $("#messageInput").val("");  // Clear input on success
        }
        });
      
    });

    setInterval(function(){
        $.post("showonline.php",function(data){
            $(".online").html(data);
        });
       },1000);

       $('body').on('click','.onlinep',function(){  
        alert("c")
          $('.reciver').html($(this).text());
       });
  });


    function loadMessages() {

         let receiverId = $(".reciver").text().trim(); // Get receiver dynamically

    if (!receiverId || receiverId === "Receiver") { 
        console.error("Receiver ID is missing");
        return;
    }

       $.ajax({
                url: "fetch_message.php",
                method: "GET",
                data: { receiver_id: receiverId },
                success: function (data) {
                    $("#chat_box").html(data);
                    $("#chat_box").scrollTop($("#chat_box")[0].scrollHeight); // Auto-scroll
                }
            });
    }

    // Refresh chat every 1 second
    setInterval(loadMessages, 1000);




    $(document).ready(function () {
    $(".logout_btn").click(function () {
        $.ajax({
            url: "logout.php",  // Logout script call kar raha hai
            type: "POST",
            success: function (response) {
                window.location.href = "login.php";  // Logout hone ke baad redirect ho jao
            },
            error: function () {
                alert("Logout failed!");
            }
        });
    });
});

</script>

<style>
body{
    margin:0;
    padding:0;
    color:white;
    background-color: black;
}

    .container{
        width: 100%;
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        background-color: black;
    }

    
    .chat_box{
        width:500px;
        height: 70%;
        background-color: white;
        display: flex;
        border-radius: 20px;
        justify-content: center;
        align-items: center;
    }
    
    .message{
        width:300px;
        height: 30px;
        border-radius: 5px;
        border: none;
        outline: none;
        padding: 5px;
        margin-top: 10px;
    }

    .send_btn{
        width: 100px;
        height: 30px;
        border-radius: 5px;
        border: none;
        outline: none;
        padding: 5px;
        margin-top: 10px;
        background-color: green;
        color: white;
    }

    .logout_btn{
        width: 100px;
        height: 30px;
        border-radius: 5px;
        border: none;
        outline: none;
        padding: 5px;
        margin-top: 10px;
        background-color: red;
        color: white;
    }


    .chat_box {
    width: 50%;
    height: 400px;
    background-color: white;
    border-radius: 10px;
    padding: 10px;
    overflow-y: auto; /* Enable scrolling */
    display: flex;
    flex-direction: column;
    color: black;
}
.message1 {
    max-width: 70%;
    padding: 8px 12px;
    margin: 5px;
    border-radius: 5px;
    word-wrap: break-word;
}

.me {
    align-self: flex-end; /* Aligns your messages to the right */
    background-color:rgb(175, 189, 165);
}

.other {
    align-self: flex-start; /* Aligns receiver's messages to the left */
    background-color:rgb(105, 196, 106);
}

.online{
    color: white;
    font-size: 20px;
    align-self: flex-end;
    margin-left: 10px;
    margin-top: 10px;
    background-color: green;
    border-radius: 5px;
    width: 100px;
    height: 50px;
    text-align: center;


}
.online p{
    margin: 0;
     padding: 0;
     font-size: 20px;
     
}
    


</style>
</head>
<body>

<h2> Online Users<div class = "online">Online</div></h2>

<div class = "container">
<h1>Chat with: <span class='reciver'>Receiver</span></h1>


<div class = "chat_box" id = "chat_box">
    
</div>

<input type="text" class="message1" placeholder="Type your message here...">
<button class="send_btn">Send</button>
<button class="logout_btn">Logout</button>

</div>


<script>
console.log("Receiver ID:", $("#receiver").val());
console.log("Message:", $("#message").val());
</script>