<!DOCTYPE html>
<html lang="en">

<head>
    <title>ADMIN</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="..\assets\css\add.css">
    <link rel="icon" type="image/png" href="../assets/img/logo.png">
</head>
<script src="../utils/checkin.js"></script>

<body>
    <!-- ***** Preloader Start ***** -->
    <div id="preloader">
        <div class="jumper">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
    <!-- Page Content -->
    <div class="page-heading header-text">
        <div class="container">
            <div class="row">
                <a href=".."
                    style="position: fixed; top: 20px; left: 20px; font-size: 24px; color: black;font-weight:bold ;text-decoration: none;">&#8592;
                </a>

            </div>
        </div>
    </div>
    <div class="services">
        <div class="container">
            <?php

            if (isset($_GET['id'])) {
                $movieId = $_GET['id'];
                include "../modules/fetch/fetchingDetail.php";
            } else {
                echo "Movie ID is not provided.";
            }
            ?>
            <!-- Bootstrap core JavaScript -->
            <script language="text/Javascript">
                cleared[0] = cleared[1] = cleared[2] = 0;
                function clearField(t) {
                    if (!cleared[t.id]) {
                        cleared[t.id] = 1;
                        t.value = '';
                        t.style.color = '#fff';
                    }
                }
            </script>
            <!-- Update  -->
            <script>
                function handleUpdateSubmit(event) {
                    event.preventDefault();
                    let urlParams = new URLSearchParams(window.location.search);
                    let id = urlParams.get('id');
                    var formData = new FormData(document.getElementById("detail-form"));
                    formData.append('id', parseInt(id));
                    var categories = [];
                    formData.forEach(function (value, key) {
                        if (key.startsWith("category[")) {
                            var categoryId = key.match(/\d+/)[0];
                            var categoryName = value;
                            categories.push({ id: parseInt(categoryId), name: categoryName });
                        }
                    });
                    var jsonObject = {};
                    jsonObject['categories'] = categories;

                    formData.forEach(function (value, key) {
                        if (!key.startsWith("category[")) {
                            jsonObject[key] = value;
                        }
                    });
                    let token = sessionStorage.getItem("token");

                    var combinedData = {
                        jsonData: jsonObject,
                        token: token,
                        id: id
                    };

                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", "../modules/func/updateMovie.php", true);
                    xhr.setRequestHeader("Content-Type", "application/json");

                    xhr.onload = function () {
                        if (xhr.status === 200) {
                            var response = JSON.parse(xhr.responseText);
                            var updateResponseElement = document.getElementById("update-response");
                            updateResponseElement.innerHTML = "Update successful";
                            updateResponseElement.style.color = "green";
                            setTimeout(function () {
                                window.location.reload();
                            }, 2000);
                            console.log("Update successful:", response);
                        } else {
                            console.error("Error occurred while updating:", xhr.statusText);
                        }
                    };
                    xhr.onerror = function () {
                        console.error("Request failed");
                    };


                    xhr.send(JSON.stringify(combinedData));
                }

            </script>
            <!-- Remove  -->
            <script>
                function handleRemoveSubmit(event) {
                    event.preventDefault();
                    let urlParams = new URLSearchParams(window.location.search);
                    let id = urlParams.get('id');
                    let token = sessionStorage.getItem("token");

                    var combinedData = {
                        token: token,
                        id: id
                    };

                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", "../modules/func/removeMovie.php", true);
                    xhr.setRequestHeader("Content-Type", "application/json");

                    xhr.onload = function () {
                        if (xhr.status === 200) {
                            var response = JSON.parse(xhr.responseText);
                            var updateResponseElement = document.getElementById("remove-response");
                            updateResponseElement.innerHTML = "Remove movie successful";
                            updateResponseElement.style.color = "red";
                            setTimeout(function () {
                                window.location.href = '../index.php';
                            }, 2000);
                            console.log("Remove successful:", response);
                        } else {
                            console.error("Error occurred while removing:", xhr.statusText);
                        }
                    };
                    xhr.onerror = function () {
                        console.error("Request failed");
                    };

                    xhr.send(JSON.stringify(combinedData));
                }
            </script>



</body>

</html>