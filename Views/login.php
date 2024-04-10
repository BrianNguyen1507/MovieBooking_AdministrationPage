<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>Login Site</title>
  <link rel="icon" type="image/png" href="../assets/img/logo.png">
  <link rel="stylesheet" href="../assets/css/login.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
  <script>
    if (window.history.replaceState) {
      window.history.replaceState(null, null, window.location.href);
    }
    document.addEventListener('DOMContentLoaded', function () {

      let loginForm = document.getElementById('login-form');

      loginForm.addEventListener('submit', function (event) {
        event.preventDefault();

      });
    });
  </script>
  <script src="../utils/clear.js"></script>

</head>

<body>
  <div class="center">
    <input type="checkbox" id="show" style="display: none;">
    <div class="container">
      <label for="show" class="close-btn fas fa-times" title="close"></label>
      <div class="text">
        Login Form
      </div>
      <form action="" id="login-form" onclick="return handleSubmitLogin(event)">
        <div class="data">
          <label>User name</label>
          <input type="text" required id="username" name="username" placeholder="Username">
        </div>
        <div class="data">
          <label>Password</label>
          <input type="password" required id="password" name="password" placeholder="Password">
        </div>
        <div class="forgot-pass">
          <a href="#">Forgot Password?</a>
        </div></br>
        <div id="status"></div>
        <div class="btn">
          <div class="inner"></div>
          <button type="submit">login</button>
        </div>
        <div class="signup-link">
          Not a member? <a href="#">Signup now</a>
        </div>
      </form>
    </div>
  </div>
  <script>
    function handleSubmitLogin(event) {
      event.preventDefault();
      let username = document.getElementById("username").value;
      let password = document.getElementById("password").value;

      if (!username || !password) {
        console.error("Error: Both username and password are required");
        return;
      }
      let loginData = {
        username: username,
        password: password
      };
      sendLoginData(loginData);
      console.log("Data:", loginData);
    }
    function sendLoginData(loginData) {
      var xhr = new XMLHttpRequest();
      var url = '../modules/login/handleLogin.php';
      xhr.open("POST", url, true);
      xhr.setRequestHeader("Content-Type", "application/json");
      xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
          if (xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.authenticated && response.token && response.role === "ADMIN") {
              sessionStorage.setItem("token", response.token);
              sessionStorage.setItem("authenticated", response.token);
              sessionStorage.setItem("role", response.token);
              window.location.href = "index.php";
              document.getElementById("status").innerText = "Login successful";
              document.getElementById("status").style.color = "green";
            } else {
              document.getElementById("status").innerText = "Login failed";
              document.getElementById("status").style.color = "red";

            }
            if (response.authenticated && response.token && response.role == "ADMIN") {
              sessionStorage.setItem("token", response.token);
              sessionStorage.setItem("authenticated", response.authenticated);
              sessionStorage.setItem("role", response.role);
              sessionStorage.setItem("username", username);
              window.location.href = "../index.php";

            }
          } else {
            console.error("Error:", xhr.statusText);
            document.getElementById("status").innerText = "Sever Error";
          }
        }
      };

      var jsonData = JSON.stringify(loginData);
      console.log(jsonData);
      xhr.send(jsonData);
    }



    document.getElementById("login-form").addEventListener("submit", handleSubmitLogin);
  </script>

  <script>
    window.onload = function () {
      document.getElementById('show').checked = true;
    };
  </script>
</body>

</html>