<?php
session_start();

if (!isset($_SESSION['username'])) {
    die("Error: User not logged in.");
}

$con = mysqli_connect("localhost", "root", "@mitalee2003", "OneToOneChatApp");

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

$sender_id = $_SESSION['username'];
$receiver_id = $_GET['receiver_id'] ?? null;

if (!$receiver_id) {
    die("Error: Receiver ID missing.");
}

$sql = "SELECT * FROM chat 
        WHERE (Sender='$sender_id' AND Receiver='$receiver_id') 
        OR (Sender='$receiver_id' AND Receiver='$sender_id') 
        ORDER BY Msgid ASC";
        
$messages = mysqli_query($con, $sql);

if (!$messages) {
    die("SQL Error: " . mysqli_error($con));
}

// Display messages in chat bubble format
while ($row = mysqli_fetch_assoc($messages)) {
    $isMe = ($row['Sender'] == $sender_id) ? "me" : "other";
    echo "<div class='message $isMe'><strong>" . (($isMe == "me") ? "You" : $row['Sender']) . ":</strong> " . htmlspecialchars($row['Message']) . "</div>";
}

mysqli_close($con);
?>
