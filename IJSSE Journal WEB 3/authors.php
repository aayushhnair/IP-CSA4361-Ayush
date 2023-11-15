<?php
// Database Connection
$servername = "localhost";
$username = "root"; // Change this if you have a different MySQL username
$password = ""; // Change this if you have set a MySQL password
$database = "editorial";
$conn = new mysqli($servername, $username, $password, $database);
$sqlrst = 0;
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize a variable to store the login status
$loginStatus = "";

// Handle editor registration
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["editor_registration"])) {
    $editor_username = $_POST["editor_username"];
    $editor_password = $_POST["editor_password"];

    $sql = "INSERT INTO authors (username, password) VALUES ('$editor_username', '$editor_password')";
    if ($conn->query($sql) === TRUE) {
        $sqlrst = 1;
        echo "Editor registered successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Handle editor login
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["editor_login"])) {
    $editor_login_username = $_POST["editor_login_username"];
    $editor_login_password = $_POST["editor_login_password"];

    $sql = "SELECT * FROM authors WHERE username = '$editor_login_username' AND password = '$editor_login_password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Set login status to success
        $loginStatus = "success";
    } else {
        // Set login status to failure
        $loginStatus = "failure";
    }
}

$conn->close();

// Redirect to index.html if login is successful
if ($loginStatus === "success") {
    header("Location: author.html");
    exit();
}elseif($sqlrst == 1){
    header("Location: author.html");
    exit();
}
else{
    header("Location: invalid.html");
    exit();
}
?>