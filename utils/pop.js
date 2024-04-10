window.addEventListener('popstate', function(event) {
    sessionStorage.removeItem("token");
    sessionStorage.removeItem("authenticated");
    sessionStorage.removeItem("role");
    sessionStorage.removeItem("username");
    sessionStorage.clear();
    window.location.href = "Views/login.php";
    

});
