<head>
<link rel="stylesheet" type="text/css" href="styles.css">
</head>

<html><body>

<?php
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
$vehicleID = $_SESSION['view'];
$_SESSION['view'] = null;
$sql = "SELECT * FROM Vehicle WHERE id = '$vehicleID'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    #success
    $userID = $_SESSION['userID'];
    if (!isset($userID))
    {
        echo "<form action = '' method = 'POST'><input class = 'loginButton' type = 'submit' name = 'login' value = 'Login'></form>";
    }
    $row = $result->fetch_assoc();
    $brand = $row['brand'];
    $name = $row['name'];
    $category = $row['category'];
    $description = $row['description'];
    $image = $row['image'];
    echo "<p class = 'title'>$brand $name</p><br><p>$category Vehicle</p><div class = 'imageContainer large'><img src='$image' alt='$name' style='width:100%'></div><p>$description</p><form action='' method='POST'></form>";
    
}

else
{
if (isset($_POST['login'])){
    header('Location: login.php');
}
else{
    header('Location: index.php');
}}

?>
</body></html>
