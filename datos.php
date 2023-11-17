<?php
$servername = "localhost";
$nombre = "nombre";
$username = "email";
$password = "contrasena";
$dbname = "tienda_online";

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
 $user = $_POST["email"];
 $pass = $_POST["contrasena"];

 if (!empty($user) && !empty($pass)) {
    $dbname = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT id FROM users WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $user, $pass);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
      $_SESSION["loggedin"] = true;
      $_SESSION["user"] = $user;
      header("location: bienvenido.php");
    } else {
      echo "Invalid username or password";
    }

    $stmt->close();
    $conn->close();
 } else {
    echo "Please fill out both fields";
 }
}
?>