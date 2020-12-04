<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="Description" content="Enter your description here" />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/sign-up-style.php" type="text/css" media="screen">

    <!-- website icon -->
    <link rel="icon" href="./images/Intrain.png">
    
    <title>Sign Up</title>
</head>

<body>
    <?php include('./includes/tools.php') ?>
    
    <div class="container-sm fadeInDown" id="signup-form">
        <form action="signup.php" method="post" id="customer-signup">
            <h1>Sign Up</h1>
            <button type="button" onclick="goBack()" id="go-back-btn"><i class="fa fa-arrow-left"></i></button>
            <div class="form-group">
                <input type="text" name="first_name" id="first_name" class="form-control fadeIn first" placeholder="Enter your first name" pattern="^[A-Za-z]+$" required>
            </div>
            <div class="form-group">
                <input type="text" name="last_name" id="last_name" class="form-control fadeIn first" placeholder="Enter your last name" pattern="^[A-Za-z]+$" required>
            </div>
            <div class="form-group">
                <input type="email" name="email" id="email" class="form-control fadeIn second" placeholder="Enter your email" pattern="^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$" required>
            </div>
            <div class="form-group">
                <input type="phone_number" name="phone_number" id="phone_number" class="form-control fadeIn second" placeholder="Enter your phone number" pattern="^\+?\d{0,13}" required>
            </div>
            <div class="form-group">
                <input type="username" name="username" id="username" class="form-control fadeIn second" placeholder="Enter username" pattern="^(?=.{4,20}$)(?:[a-zA-Z\d]+(?:(?:\.|-|_)[a-zA-Z\d])*)+$" required>
            </div>
            <div class="form-group">
                <input type="password" class="form-control fadeIn third" id="password" name="password" placeholder="Enter password" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" required>
            </div>
            <input onclick="" type="submit" class="btn fadeIn fourth" id="sign-up-btn" value="Sign Up"></input>
        </form>
    </div>
    <?php include('./includes/javascript.php'); ?>
</body>
</html>