<head>
<link rel="stylesheet" type="text/css" href="styles.css">
</head>

<html><body>
<p class = 'title'>Vehicle Editor</p>
<?php 
session_start();
if ($_SESSION['userID'] != null)
{


$servername = '127.0.0.1';
$username = 'dbuser';
$password = 'dbpass';
$dbname = 'dbname';
$port = '3306';




// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$vehicleID = $_SESSION['vehicleID'];
$sql = "SELECT * FROM Vehicle WHERE id = '$vehicleID'";
$result = $conn->query($sql);
$categories = getCategories($conn);

if ($result->num_rows > 0) {
    #success
    $row = $result->fetch_assoc();
    $eid = $row['id'];
    $ename = $row['name'];
    $ebrand = $row['brand'];
    $ecategory = $row['category'];
    $edescription = $row['description'];
    $body = "<p>ID: $eid</p><br>
<form action = '' method = 'POST' enctype='multipart/form-data'>
<input type = 'hidden' name = 'id'>
name: <input type = 'text' name = 'name' value = '$ename'><br><br>
brand: <input type = 'text' name = 'brand' value = '$ebrand'><br><br>
<label>description:</label><br>
<textarea rows='12' name='description'>$edescription</textarea><br><br>
category: <select name = 'category'>$categories</select><br><br>
image: <input type='file' name='image'><br><br>
<input type = 'submit' name = 'btn1' value = 'Submit'>&nbsp;&nbsp;
<input type = 'submit' name = 'delete' value = 'Delete Record'>
</form>";
    echo $body; 

if (isset($_POST['btn1'])){
    #image upload code
    $target_dir = 'images/';
    $uploadOk = true;
    $imageFileType = strtolower(end(explode('.',$_FILES['image']['name'])));

    $targetFile = getFileName(1, $target_dir, $imageFileType);
    
    // Allow certain file formats
    if($imageFileType != 'jpg' && $imageFileType != 'png' && $imageFileType != 'jpeg') {
    echo 'Sorry, only JPEG and PNG files are allowed.';
    $uploadOk = false;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == false) {
    echo 'Sorry, your file was not uploaded.';
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            //echo "The file ". basename( $_FILES['image']['name']). " has been uploaded.";
        } else {
            echo "<p>Sorry, there was an error uploading your file.</p><br>";
    }}
    #image upload code
    
    $subname = $_POST['name'];
    $subbrand = $_POST['brand'];
    $subcategory = $_POST['category'];
    $subdescription = $_POST['description'];
    $subuserID = $_SESSION['userID'];
    $subimage = $targetFile;
    $sqlquery ="";
    if ($uploadOk == true){
        $sqlquery ="UPDATE Vehicle SET  name = '$subname', brand = '$subbrand', category = '$subcategory', description = '$subdescription', operatorID = '$subuserID', image = '$subimage' WHERE id = '$eid'";
    }
    else
    {
        $sqlquery ="UPDATE Vehicle SET  name = '$subname', brand = '$subbrand', category = '$subcategory', description = '$subdescription', operatorID = '$subuserID' WHERE id = '$eid'";
    }
    if ($conn->query($sqlquery) === TRUE) {
    header('Location: index.php');
} else {
    echo "Error: " . $sqlquery . "<br>" . $conn->error;
}
}
if (isset($_POST['delete'])){
    $_SESSION['vehicleID'] = NULL;
    $deleteSQL = "DELETE FROM Vehicle WHERE id = '$eid'";
    $result = $conn->query($deleteSQL);
    if (isset ($result))
    {
        header('Location:index.php');
    }
}
}}
else
{
    echo "ERROR, please log in";
}

function getFileName($id = 1, $target_dir, $imageFileType){
    $finalPath = $target_dir . "image" . $id;
    if (file_exists($finalPath))
    {
        return getFileName($id+1, $target_dir, $imageFileType);
    }
    else
    return $finalPath . '.' . $imageFileType;
}

function getCategories ($conn){
    $sqll = "SELECT name FROM Category";
    $resultt = $conn->query($sqll);
    $finalVal = "";
    while ($row = $resultt->fetch_assoc())
    {
        $name = $row['name'];
        $finalVal .= "<option value = '$name'>$name</option>";
    }
    return $finalVal;
}
?>
</body></html>
