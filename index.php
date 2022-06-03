<?php

include 'config.php';

error_reporting(0);

session_start();

if (isset($_SESSION['name'])) {
    header("Location: login.php");
}
if (isset($_POST['submit']))
{
$name = $_POST['name'];
$email = $_POST['email'];
$pass = md5($_POST['password']);
$cpass = md5($_POST['cpassword']);
if ($pass == $cpass) {
$sql = "SELECT * FROM user_form WHERE email='$email'";
$result = mysqli_query($conn, $sql);
if (!$result->num_rows > 0) {
$sql = "INSERT INTO user_form (name, email, password)
VALUES ('$name', '$email', '$pass')";
$result = mysqli_query($conn, $sql);
if ($result) {
echo "<script>alert('User Registration Completed.')</script>";
$username = "";
$email = "";
$_POST['password'] = "";
$_POST['cpassword'] = "";
} else {
echo "<script>alert('Sorry! Something Wrong Went.')</script>";
}
} else {
echo "<script>alert('Sorry! Email Already Exists.')</script>";
}
} else {
echo "<script>alert('Password Not Matched.')</script>";
}
    $captcha=$_POST['captcha'];
if($captcha==$_SESSION['captcha']) {
echo "<script>alert('correct captcha')</script>";
}
else{
echo "<script>alert('captcha not matched')</script>";
}
}

?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
/* Style all input fields */
input {
  width: 100%;
  padding: 6px;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
  margin-top: 6px;
  margin-bottom: 16px;
}

/* Style the submit button */
input[type=submit] {
  background-color: #04AA6D;
  color: white;
}

/* Style the container for inputs */
.container {
  background-color: #f1f1f1;
  padding: 10px;
}

/* The message box is shown when the user clicks on the password field */
#message {
  display:none;
  background: #f1f1f1;
  color: #000;
  position: relative;
  padding: 20px;
  margin-top: 10px;
}

#message p {
  padding: 10px 35px;
  font-size: 18px;
}

/* Add a green text color and a checkmark when the requirements are right */
.valid {
  color: green;
}

.valid:before {
  position: relative;
  left: -35px;
  content: "✔";
}

/* Add a red text color and an "x" when the requirements are wrong */
.invalid {
  color: red;
}

.invalid:before {
  position: relative;
  left: -35px;
  content: "✖";
}
</style>
 <link rel="stylesheet" href="css/style.css">
</head>
<body>

 <title>Register</title>

<div class="container">
  <form action="" method="post" enctype="multipart/form-data">
     
      <h3>Register Now</h3>
      <?php
      if(isset($message)){
         foreach($message as $message){
            echo '<div class="message">'.$message.'</div>';
         }
      }
      ?>
    <label for="usrname">Username</label>
    <input type="text" name="name" placeholder="enter username" autocomplete="off" class="box" required>

    <label for="email">Email Address</label>
    <input type="email" name="email" placeholder="enter email" autocomplete="off" class="box" required>

    <label for="psw">Password</label>
    <input type="password" id="psw" name="password" minlength="8" placeholder="Password" class="box" autocomplete="off" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>

    <label for="cpassword">Confirm Password</label>
    <input type="password" id="cpassword" name="cpassword" minlength="8" placeholder="Confirm Password" class="box" autocomplete="off" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
    
    <div class="input-group">
<input type="text" placeholder="Enter Captcha" name="captcha" required>
</div>
<div class="input-group">
<img src="captcha.php"/>
</div>

    

   <button type="submit" name="submit" value="register now" onclick="validcap()" class="btn btn-lg btn-success btn-block">Submit</button>
      <p>already have an account?  <a href="login.php">Login Now</a></p>
  <div id="message">
  <h3>Password must contain the following:</h3>
  <p id="letter" class="invalid">A <b>lowercase</b> letter</p>
  <p id="capital" class="invalid">A <b>capital (uppercase)</b> letter</p>
  <p id="number" class="invalid">A <b>number</b></p>
  <p id="length" class="invalid">Minimum <b>8 characters</b></p>
</div>

  </form>
</div>


            
<script>
var myInput = document.getElementById("psw");
var letter = document.getElementById("letter");
var capital = document.getElementById("capital");
var number = document.getElementById("number");
var length = document.getElementById("length");

// When the user clicks on the password field, show the message box
myInput.onfocus = function() {
  document.getElementById("message").style.display = "block";
}

// When the user clicks outside of the password field, hide the message box
myInput.onblur = function() {
  document.getElementById("message").style.display = "none";
}

// When the user starts to type something inside the password field
myInput.onkeyup = function() {
  // Validate lowercase letters
  var lowerCaseLetters = /[a-z]/g;
  if(myInput.value.match(lowerCaseLetters)) {  
    letter.classList.remove("invalid");
    letter.classList.add("valid");
  } else {
    letter.classList.remove("valid");
    letter.classList.add("invalid");
  }
  
  // Validate capital letters
  var upperCaseLetters = /[A-Z]/g;
  if(myInput.value.match(upperCaseLetters)) {  
    capital.classList.remove("invalid");
    capital.classList.add("valid");
  } else {
    capital.classList.remove("valid");
    capital.classList.add("invalid");
  }

  // Validate numbers
  var numbers = /[0-9]/g;
  if(myInput.value.match(numbers)) {  
    number.classList.remove("invalid");
    number.classList.add("valid");
  } else {
    number.classList.remove("valid");
    number.classList.add("invalid");
  }
  
  // Validate length
  if(myInput.value.length >= 8) {
    length.classList.remove("invalid");
    length.classList.add("valid");
  } else {
    length.classList.remove("valid");
    length.classList.add("invalid");
  }
}
</script>

</body>
</html>
