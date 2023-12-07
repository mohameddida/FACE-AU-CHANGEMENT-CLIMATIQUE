<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Tooplate's Little Fashion - Contact Page</title>

    <!-- CSS FILES -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;300;400;700;900&display=swap" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="css/slick.css"/>
    <link href="css/tooplate-little-fashion.css" rel="stylesheet">
 <script src="https://www.google.com/recaptcha/api.js"></script>
</head>

<body>

<header>
    <div class="logo">
        <br>
        <img src="lllllllllllllllll.png" width="250px" alt="Votre Logo">
    </div>
</header>

<main>
    <?php
    include 'config.php';
    session_start();
    if (isset($_POST['submit'])) {
        try {
            $pdo = new PDO("mysql:host=localhost;dbname=user_db", 'root', '');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $email = $_POST['email'];
            $password = md5($_POST['password']);
            $stmt = $pdo->prepare("SELECT * FROM `user_form` WHERE email = :email AND password = :password");
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':password', $password, PDO::PARAM_STR);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $_SESSION['user_id'] = $row['id'];
                header('location:home.php');
                exit(); // Ensure to stop script execution after redirection
            } else {
                $message[] = 'Incorrect email or password!';
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        } finally {
            $pdo = null;
        }
    }
    ?>

    <header class="site-header section-padding-img site-header-image" style="margin-top: 0;">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 col-12 header-info">
                    
                    <form action="" method="post" enctype="multipart/form-data">
                
                        <h2>Login Now</h2>
                        <?php
                        if (isset($message)) {
                            foreach ($message as $message) {
                                echo '<div class="message">' . $message . '</div>';
                            }
                        }
                        ?>
                        <input type="email" name="email" placeholder="Enter email" class="box" required>
                        <input type="password" name="password" placeholder="Enter password" class="box" required>
                        
                        <input type="submit" name="submit" value="Login Now" class="btn">
                        <p>Don't have an account? <a href="register.php">Register Now</a> <a href="new.php">forget password</a</p> 

                        <div class="g-recaptcha" data-sitekey="6LfdeSQpAAAAAON_U780InOW2Q16Vei6c9KRrbIU"></div>
      <br/>
                        
                    </form>
                </div>
            </div>
            <img src="images/header/positive-european-woman-has-break-after-work.jpg" class="header-image img-fluid" alt="">
        </div>
    </header>

</main>

<footer class="site-footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-10 me-auto mb-4">
                <h4 class="text-white mb-3"><a href="index.html">Little</a> Fashion</h4>
                <p class="copyright-text text-muted mt-lg-5 mb-4 mb-lg-0">Copyright © 2022 <strong>Little Fashion</strong></p>
                <br>
                <p class="copyright-text">Designed by <a href="https://www.tooplate.com/" target="_blank">Tooplate</a></p>
            </div>
            <div class="col-lg-5 col-8">
                <h5 class="text-white mb-3">Sitemap</h5>
                <ul class="footer-menu d-flex flex-wrap">
                    <li class="footer-menu-item"><a href="about.html" class="footer-menu-link">Story</a></li>
                    <li class="footer-menu-item"><a href="#" class="footer-menu-link">Products</a></li>
                    <li class="footer-menu-item"><a href="#" class="footer-menu-link">Privacy policy</a></li>
                    <li class="footer-menu-item"><a href="#" class="footer-menu-link">FAQs</a></li>
                    <li class="footer-menu-item"><a href="#" class="footer-menu-link">Contact</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-4">
                <h5 class="text-white mb-3">Social</h5>
                <ul class="social-icon">
                    <li><a href="#" class="social-icon-link bi-youtube"></a></li>
                    <li><a href="#" class="social-icon-link bi-whatsapp"></a></li>
                    <li><a href="#" class="social-icon-link bi-instagram"></a></li>
                    <li><a href="#" class="social-icon-link bi-skype"></a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>

<!-- JAVASCRIPT FILES -->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/Headroom.js"></script>
<script src="js/jQuery.headroom.js"></script>
<script src="js/slick.min.js"></script>
<script src="js/custom.js"></script>
<script>
      function onsubmit() {
        grecaptcha.ready(function() {
          grecaptcha.execute('6LfdeSQpAAAAAON_U780InOW2Q16Vei6c9KRrbIU', { action: 'submit' }).then(function(token) {
              document.getElementById('demo-form').submit();
          });
        });
      }
</script>
</body>
</html>
