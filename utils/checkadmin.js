let token = sessionStorage.getItem("token");
let authenticated = sessionStorage.getItem("authenticated");
let role = sessionStorage.getItem("role");

if (!token || !authenticated || role !== "ADMIN") {
    window.location.href = "Views/login.php";
} else {
    document.getElementById("username");
}
