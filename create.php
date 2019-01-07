
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Create An Account</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
  <link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="css/util.css">
  <link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>


  <div class="container-contact100" style="background-image: url('images/bg-01.jpg');">
    <div class="wrap-contact100">
      <form class="contact100-form validate-form" action="new_account.php" method="post">
        <span class="contact100-form-title">
          Create an Account
        </span>

        <div class="wrap-input100 rs1-wrap-input100 validate-input" data-validate="Name is required">
          <span class="label-input100">First Name</span>
          <input class="input100" type="text" name="firstname" placeholder="Enter your first name">
        </div>

        <div class="wrap-input100 rs1-wrap-input100 validate-input" data-validate = "Valid name is required">
          <span class="label-input100">Last Name</span>
          <input class="input100" type="text" name="lastname" placeholder="Enter your last name">
        </div>

        <div class="wrap-input100">
          <span class="label-input100">Username</span>
          <input class="input100" type="text" name="username" placeholder="eg . MattyBRaps">
        </div>

        <div class="wrap-input100">
          <span class="label-input100">Password</span>
          <input class="input100" type="password" name="pwd1" placeholder="Enter a Password with at least eight characters and one digit">
        </div>

        <div class="wrap-input100">
          <span class="label-input100">Confirm Password</span>
          <input class="input100" type="password" name="pwd2" placeholder="Confirm Password">
        </div>

        <div class="container-contact100-form-btn">
          <div class="wrap-contact100-form-btn">
            <div class="contact100-form-bgbtn"></div>
            <button class="contact100-form-btn">
              Create
            </button>
          </div>
        </div>
      </form>
    </div>

    <span class="contact100-more">
      Already registered? 
      <a class="contact100-more" href="login.php">Sign in</a>
    </span>
  </div>



  <div id="dropDownSelect1"></div>

<!--===============================================================================================-->
  <script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
  <script src="vendor/bootstrap/js/popper.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
  <script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
  <script src="js/main.js"></script>

</body>
</html>
