<?php

include 'config.php';
session_start();

function authenticateUser($email, $password, $conn) {
    $email = mysqli_real_escape_string($conn, $email);
    $pass = mysqli_real_escape_string($conn, md5($password));

    $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'") or die('query failed');

    if (mysqli_num_rows($select_users) > 0) {
        return mysqli_fetch_assoc($select_users);
    }
    
    return null;
}

if (isset($_POST['submit'])) {
    $user = authenticateUser($_POST['email'], $_POST['password'], $conn);
    
    if ($user) {
        if ($user['user_type'] == 'admin') {
            $_SESSION['admin_name'] = $user['name'];
            $_SESSION['admin_email'] = $user['email'];
            $_SESSION['admin_id'] = $user['id'];
            header('location:admin_page.php');
        } elseif ($user['user_type'] == 'user') {
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_id'] = $user['id'];
            header('location:home.php');
        }
    } else {
        $message[] = 'incorrect email or password!';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login</title>
   <link rel="icon" id="png" href="images/icon2.png">

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>
   
<div class="form-container">

   <form action="" method="post">
      <h3>ingresa</h3>
      <input type="email" name="email" placeholder="ingresa tu email" required class="box">
      <input type="password" name="password" placeholder="ingresa tu contraseña" required class="box">
      <input type="submit" name="submit" value="Ingresar" class="btn">
      <p>no tienes cuenta? <a href="register.php">registrate ahora</a></p>
   </form>

</div>

</body>
</html>
