<!DOCTYPE html>
<html>

<head>
  <link rel="stylesheet" href="stylesheet.css">
</head>

<body>
<div class="login-page">
  <div class="form">
    <form class="login-form" action="process.php" method="post">
      <input type="text" name="username" placeholder="username"/>
      <input type="password" name="password" placeholder="password"/>
      <button>login</button>
      <p id="message">Not registered? <a href="create.php">Create an account</a></p>
    </form>
  </div>
</div>


</body>
</html>