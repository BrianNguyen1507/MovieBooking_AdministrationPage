function Logout() {
    sessionStorage.removeItem("token");
    sessionStorage.removeItem("authenticated");
    sessionStorage.removeItem("role");
    sessionStorage.removeItem("username");
   
    window.location.href = "Views/login.php";
  
}

