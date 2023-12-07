<?php
































include 'config.php';

if (isset($_POST['submit'])) {

    try {
            $pdo = new PDO("mysql:host=localhost;dbname=user_db", 'root', '');

           
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = md5($_POST['password']);
        $cpassword = md5($_POST['cpassword']);
        $image = $_FILES['image']['name'];
        $image_size = $_FILES['image']['size'];
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_folder = 'uploaded_img/' . $image;

        $stmt = $pdo->prepare("SELECT * FROM `user_form` WHERE email = :email AND password = :password");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $message[] = 'User already exists';
        } else {
            if ($password != $cpassword) {
                $message[] = 'Confirm password not matched!';
            } elseif ($image_size > 2000000) {
                $message[] = 'Image size is too large!';
            } else {
                $stmt = $pdo->prepare("INSERT INTO `user_form`(name, email, password, image) VALUES(:name, :email, :password, :image)");
                $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->bindParam(':password', $password, PDO::PARAM_STR);
                $stmt->bindParam(':image', $image, PDO::PARAM_STR);

                if ($stmt->execute()) {
                    move_uploaded_file($image_tmp_name, $image_folder);
                    $message[] = 'Registered successfully!';
                    header('location:login.php');
                    exit(); // Ensure to stop script execution after redirection
                } else {
                    $message[] = 'Registration failed!';
                }
            }
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    } finally {
        $pdo = null;
    }
}

?>





<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>register</title>

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">

</head>

<body>

    <div class="logo">
        <br>
        <img src="lllllllllllllllll.png" width="250px" alt="Votre Logo" >
    </div>

<style>
  .box {
    margin-bottom: 10px;
  }

  .error {
    color: red;
  }
  .errorText {
    color: red;
  }
</style>
<div class="form-container">

   <form action="" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
      <h3>register now</h3>
      <?php
      if (isset($message)) {
         foreach ($message as $message) {
            echo '<div class="message">' . $message . '</div>';
         }
      }
      ?>
       <p id="errorText" class="error" ></p>
      <input type="text" name="name" placeholder="enter username" class="box" required>
      <input type="email" name="email" placeholder="enter email" class="box" required>
      <input type="password" name="password" placeholder="enter password" class="box" required>
      <input type="password" name="cpassword" placeholder="confirm password" class="box" required>
     
      <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png">
      <input type="submit" name="submit" value="register now" class="btn">
      <p>already have an account? <a href="login.php">login now</a>  </p> 
   </form>

</div>
<script>
    function validateForm() {
      var name = document.getElementsByName('name')[0].value;
      var email = document.getElementsByName('email')[0].value;
      var password = document.getElementsByName('password')[0].value;
      var cpassword = document.getElementsByName('cpassword')[0].value;

      // Validation de la longueur minimale du nom
      if (name.length < 4) {
        document.getElementById('errorText').textContent = 'Le nom doit avoir au moins 4 caractères.';
        return false; // Empêcher la soumission du formulaire
      }

      // Validation de la longueur minimale du mot de passe
      if (password.length < 8) {
        document.getElementById('errorText').textContent = 'Le mot de passe doit avoir au moins 8 caractères.';
        return false; // Empêcher la soumission du formulaire
      }

      // Validation du format de l'email (une validation de base)
      var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailRegex.test(email)) {
        document.getElementById('errorText').textContent = 'Format d\'email non valide.';
        return false; // Empêcher la soumission du formulaire
      }

      // Validation du mot de passe : vérifier si les mots de passe correspondent
      if (password !== cpassword) {
        document.getElementById('errorText').textContent = 'Les mots de passe ne correspondent pas.';
        return false; // Empêcher la soumission du formulaire
      }

      // Autres validations peuvent être ajoutées ici selon les besoins

      // Si toutes les validations passent, le formulaire est soumis
      return true;
    }
    
  </script>
</body>
</html>
