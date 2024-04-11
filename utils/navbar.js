

    navbar = `
        <li class="nav-item active">
            <a class="nav-link" href="index.html">Movies</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="Views/theater.php">Theater</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="service.html">Services</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="blog.html">About</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="contact.html">Contact</a>
        </li>
        <li class="nav-item">
            <a class="btn btn-primary ml-lg-2" onclick="Logout()" href="#">Log out</a>
        </li>
    `;

document.addEventListener("DOMContentLoaded", function() {
    let resp = document.getElementById("navbar");
    if (resp) {
        resp.innerHTML = navbar;
    } else {
        console.error("Not found.");
    }
});
