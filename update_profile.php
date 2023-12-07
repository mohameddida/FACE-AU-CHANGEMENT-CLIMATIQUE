<?php

include 'config.php';
session_start();
$user_id = $_SESSION['user_id'];

if(isset($_POST['update_profile'])){
   try {
      $pdo = new PDO("mysql:host=localhost;dbname=user_db", 'root', '');
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $update_name = $_POST['update_name'];
      $update_email = $_POST['update_email'];

      $updateStmt = $pdo->prepare("UPDATE `user_form` SET name = :name, email = :email WHERE id = :user_id");
      $updateStmt->bindParam(':name', $update_name, PDO::PARAM_STR);
      $updateStmt->bindParam(':email', $update_email, PDO::PARAM_STR);
      $updateStmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
      $updateStmt->execute();

      $old_pass = $_POST['old_pass'];
      $update_pass = md5($_POST['update_pass']);
      $new_pass = md5($_POST['new_pass']);
      $confirm_pass = md5($_POST['confirm_pass']);

      if(!empty($update_pass) || !empty($new_pass) || !empty($confirm_pass)){
         if($update_pass != $old_pass){
            //$message[] = 'old password not matched!';
         }elseif($new_pass != $confirm_pass){
            //$message[] = 'confirm password not matched!';
         }else{
            $updatePassStmt = $pdo->prepare("UPDATE `user_form` SET password = :password WHERE id = :user_id");
            $updatePassStmt->bindParam(':password', $confirm_pass, PDO::PARAM_STR);
            $updatePassStmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $updatePassStmt->execute();
            //$message[] = 'password updated successfully!';
         }
      }

      $update_image = $_FILES['update_image']['name'];
      $update_image_size = $_FILES['update_image']['size'];
      $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
      $update_image_folder = 'uploaded_img/' . $update_image;

      if(!empty($update_image)){
         if($update_image_size > 2000000){
            $message[] = 'image is too large';
         }else{
            $image_update_query = $pdo->prepare("UPDATE `user_form` SET image = :image WHERE id = :user_id");
            $image_update_query->bindParam(':image', $update_image, PDO::PARAM_STR);
            $image_update_query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $image_update_query->execute();

            if ($image_update_query) {
               move_uploaded_file($update_image_tmp_name, $update_image_folder);
            }
            //$message[] = 'image updated successfully!';
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
   <title>update profile</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<div class="update-profile">

   <?php
      try {
        $pdo = new PDO("mysql:host=localhost;dbname=user_db", 'root', '');
         $selectStmt = $pdo->prepare("SELECT * FROM user_form WHERE id = :user_id");
         $selectStmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
         $selectStmt->execute();
         $fetch = $selectStmt->fetch(PDO::FETCH_ASSOC);

         if ($fetch['image'] == '') {
            echo '<img src="images/default-avatar.png" width="50%" height="50%">';
         } else {
            echo '<img src="uploaded_img/' . $fetch['image'] . '" width="50%" height="50%">';
         }

         if (isset($message)) {
            foreach ($message as $message) {
               echo '<div class="message">' . $message . '</div>';
            }
         }
      } catch (PDOException $e) {
         echo "Error: " . $e->getMessage();
      }
   ?>

   <form action="" method="post" enctype="multipart/form-data">
      <div class="flex">
         <div class="inputBox">
            <span>username :</span>
            <input type="text" name="update_name" value="<?php echo $fetch['name']; ?>" class="box">
            <span>your email :</span>
            <input type="email" name="update_email" value="<?php echo $fetch['email']; ?>" class="box">
            <span>update your pic :</span>
            <input type="file" name="update_image" accept="image/jpg, image/jpeg, image/png" class="box">
         </div>
         <div class="inputBox">
            <input type="hidden" name="old_pass" value="<?php echo $fetch['password']; ?>">
            <span>old password :</span>
            <input type="password" name="update_pass" placeholder="enter previous password" class="box">
            <span>new password :</span>
            <input type="password" name="new_pass" placeholder="enter new password" class="box">
            <span>confirm password :</span>
            <input type="password" name="confirm_pass" placeholder="confirm new password" class="box">
         </div>
      </div>
      <input type="submit" value="update profile" name="update_profile" class="btn">
      <a href="home.php" class="delete-btn">go back</a>
   </form>

</div>

</body>
</html>
