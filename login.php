<head>
<link rel="stylesheet" type="text/css" href="styles.css">
</head>
<?php
if ($_POST['btn1']){
$servername = '127.0.0.1';
$username = 'dbuser';
$password = 'dbpass';
$dbname = 'dbname';
$port = '3306';
//starting a session so that data can be shared between pages
session_start();

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$userCode = $_POST['userCode'];
$passWord = $_POST['password'];
$sql = "SELECT name, userID FROM Operator WHERE userCode = '$userCode'  AND password = '$passWord'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    #login is successful
    $row = $result->fetch_assoc();
    $name = $row['name'];
    $_SESSION['userID'] = $row['userID'];
    echo "<p style = 'color: #00ff00'>Hello WELCOME $name</p>";
    header('Location: index.php'); 
}
else
{
    #login fail
    echo "<p style = 'color: #ff0000'>GO AWAY!!</p>";
}
}
?>

<html><body class = 'loginBody'>
<p class = 'title'>Login</p>
<form action = 'login.php' method = 'POST'>
User Code: <input style = 'width: 50%' type = 'text' name = 'userCode'><br><br>
Password: <input style = 'width: 50%' type= 'password' name = 'password'><br><br>
<input type = 'submit' name = 'btn1' value = 'Login'>
</form>
</body></html>
