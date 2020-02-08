<head>
<link rel="stylesheet" type="text/css" href="styles.css">
</head>
<html><body>
<p class = 'title'>Vehicle Creator</p>
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
$sql = "SELECT id FROM Vehicle";
$result = $conn->query($sql);
$categories = getCategories($conn);

if ($result->num_rows > 0) {
    #success
    $row = $result->fetch_assoc();
    $id = ($result->num_rows)+1;
    $body = "<p>ID: $id</p><br>
<form action = 'new_vehicle.php' method = 'POST' enctype='multipart/form-data'>
name: <input type = 'text' name = 'name'><br><br>
brand: <input type = 'text' name = 'brand'><br><br>
<label>description:</label><br>
<textarea cols='35' rows='12' name='description'></textarea><br><br>
category: <select name = 'category'>$categories</select><br><br>
image: <input type='file' name='image'><br><br>
<input type = 'submit' name = 'btn1' value = 'Submit'>
</form>";
    echo $body; 
}
else
{
    #fail
    $id = 1;
    $body = "<p>ID: $id</p><br><br>
<form action = 'new_vehicle.php' method = 'POST' enctype='multipart/form-data'>
name: <input type = 'text' name = 'name'><br><br>
brand: <input type = 'text' name = 'brand'><br><br>
<label>description:</label><br>
<textarea cols='35' rows='12' name='description'></textarea><br><br>
category: <select name = 'category'>$categories</select><br><br>
image: <input type='file' name='image'><br><br>
<input type = 'submit' name = 'btn1' value = 'Submit'>
</form>";
    echo $body;
}

if (isset($_POST['btn1'])){
    #image upload code
    $target_dir = 'images/';
    $uploadOk = 1;
    $imageFileType = strtolower(end(explode('.',$_FILES['image']['name'])));

    $targetFile = getFileName(1, $target_dir, $imageFileType);
    
    // Allow certain file formats
    if($imageFileType != 'jpg' && $imageFileType != 'png' && $imageFileType != 'jpeg') {
    echo 'Sorry, only JPEG and PNG files are allowed.';
    $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
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
    $sqlquery ="INSERT INTO Vehicle (name, brand, category, description, id, operatorID, image) VALUES ('$subname', '$subbrand', '$subcategory', '$subdescription', $id, $subuserID, '$subimage')";
    if ($conn->query($sqlquery) === TRUE) {
    echo "New record for the $subcategory Vehicle $subbrand $subname has been created successfully";
    header('Location:index.php');
} else {
    echo "Error: " . $sqlquery . "<br>" . $conn->error;
}
}

}
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
    return $finalPath . $imageFileType;
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
</html></body>
