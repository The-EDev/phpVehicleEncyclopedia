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
$userID = $_SESSION['userID'];
if (isset($_POST['view']))
{
    $_SESSION['view'] = $_POST['id'];
    header('Location: vehicle.php');
}
if ($userID){
$sql = "SELECT name FROM Operator WHERE userID = '$userID'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    #success
    $row = $result->fetch_assoc();
    $name = $row['name'];
    echo "<p class = 'title'>Farook's Vehicle Encyclopedia</p><form action = '' method = 'POST'><p>Hello WELCOME $name</p>
<input type = 'submit' name = 'btn1' value = 'Create New Vehicle Record'><input type = 'submit' name = 'logout' value = 'Logout'>
</form>";

if (isset($_POST['btn1']))
{
    header('Location: new_vehicle.php');
}
else if (isset($_POST['btn2']))
{
    $_SESSION['vehicleID'] = $_POST['id'];
    header('Location: info_editor.php');
}
else if (isset($_POST['logout']))
{
    $_SESSION['userID'] = null;
    header('Location: index.php');
}}}
else {
    if (isset($_POST['login'])){
        header('Location: login.php');
    }
    echo "<form action = '' method = 'POST'><p class = 'title'>Farook's Vehicle Encyclopedia</p>
<input class = 'loginButton' type = 'submit' name = 'login' value = 'Login'>
</form>";
}

echo "<form action = '' method = 'POST'><input type = 'text' name = 'searchText' placeholder='Search..'><input type = 'hidden' name = 'search' value = 'Search'></form>";

$sql = "SELECT * FROM Vehicle";
if (isset ($_POST['search']))
{
    $searchText = $_POST['searchText'];
    $sql = "SELECT * FROM Vehicle WHERE name LIKE '%$searchText%' OR brand LIKE '%$searchText%'";
}
$result = $conn->query($sql);


while ($row = $result->fetch_assoc()){
    $brand = $row['brand'];
    $name = $row['name'];
    $image = $row['image'];
    $id = $row['id'];
    echo isset($userID) ? "<div><div class = 'imageContainer' style = 'float: left;'><img src='$image' alt='$name' height='100px'></div><h1 float='right'>$brand $name</h1><form action='' method='POST'><input type='hidden' name = 'id' value='$id'><input type = 'submit' name = 'view' value = 'View'>
<input type = 'submit' name = 'btn2' value = 'Edit'></form></div><br><hr><br>" : "<div><div class = 'imageContainer' style = 'float: left;'><img src='$image' alt='$name' height='100px'></div><h1 float='right'>$brand $name</h1><form action='' method='POST'><input type='hidden' name = 'id' value='$id'><input type = 'submit' name = 'view' value = 'View'>
</form></div><br><hr><br>";
}
?>

</body></html>
