<!DOCTYPE html>
<html>

<head>
  <link rel="stylesheet" href="stylesheet.css">
</head>

<body>
<div class="login-page">
  <div class="form">
    <form class="create-form" action ="new_account.php" method="post">
      <input type="text" name="username" placeholder="first name"/>
      <input type="text" name="lastname" placeholder="last name"/>
      <input type="password" name="pwd1" placeholder="password"/>
      <input type="password" name="pwd2" placeholder="repeat password"/>
      <button>Create Account</button>
      <p id="message">Already registered? <a href="index.php">Sing in</a></p>
    </form>
  </div>
</div>


</body>
</html>