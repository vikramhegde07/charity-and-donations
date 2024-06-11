<?php 

include './includes/config.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confPassword = $_POST['confPassword'];

    if($password == $confPassword){
        $password_hash = password_hash($password,PASSWORD_DEFAULT);
        
        $stmt = $conn->prepare("INSERT INTO users (username,email, password) VALUES (?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("sss", $username, $email, $password_hash);
            if ($stmt->execute()) {
                $sql = "SELECT id from users where email = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('s',$email);
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($id);
                $_SESSION['uid'] = $id;
                header("Location: ./index.php");
            } else {
                $signinError = "Error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Error preparing statement: " . $conn->error;
        }
    }else{
        echo "passwords do not match";
    }
}

echo "something";

?>