let token = sessionStorage.getItem("token");
let authenticated = sessionStorage.getItem("authenticated");
let role = sessionStorage.getItem("role");

if (!token || !authenticated || role !="EMPLOYEE") {
    window.location.href = "login.php";
} else {
    document.getElementById("username");
}