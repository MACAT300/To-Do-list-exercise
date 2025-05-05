<?php
    // start session  (we want to use $SESSION in this page)
    session_start();
$host = "127.0.0.1";
$database_name = "TODO";
$database_user = "root";
$database_password = "";
// 2. Connect PHP with the Mysql database
// PDO (PHP Database Object)
$db = new PDO(
    "mysql:host=$host;dbname=$database_name",
    $database_user,
    $database_password
);
$email = $_POST["email"];
$password = $_POST["password"];
//check for errir (make sure all the fields are filled)
if(empty($email) || empty($password)) {
    echo"All fields are required";
} else {
    // get the user date by email
    $sql = "SELECT * FROM user WHERE email = :email";
    $query = $db->prepare( $sql );
    $query -> execute([
        "email" => $email
    ]);
    $user = $query->fetch();
    if( $user) {
            // check if the password is correct or not
            if ( password_verify($password, $user["password"])) {
                // store the user session storage to login the user
                $_SESSION["user"] = $user;
                header("Location: exercise.php");
                exit;
            } else {
                echo "The password provided is incorrect";
            }
        } else {
            echo "The email provided does not exist";
        };
}