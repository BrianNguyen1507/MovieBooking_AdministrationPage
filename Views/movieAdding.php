<!DOCTYPE html>
<html lang="en">

<head>
    <title>ADMIN</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="..\assets\css\add.css">
    <link rel="icon" type="image/png" href="../assets/img/logo.png">
    <script src="../utils/checkin.js"></script>
</head>

<body>
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

            <div>
                <h3>ENTER NEW MOVIE INFORMATION</h3><br>
            </div>
            <form action="" id="add-form" class="form" method="POST" enctype="multipart/form-data">
                <label for="movieName">Name:</label><br>
                <input type="text" id="movieName" name="movieName"><br>
                <label for="movieDuration">Movie Duration (HH:mm:ss):</label><br>
                <input type="text" id="movieDuration" name="movieDuration"
                    pattern="([01]?[0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]"
                    title="Please enter a valid duration format (HH:mm:ss)" required><br>
                <label for="movieReleaseDate">Date Release:</label><br>
                <input type="date" id="movieReleaseDate" name="movieReleaseDate"
                    title="Please enter a valid date"><br /><br />
                <label for="movieActors">Actors:</label><br>
                <textarea id="movieActors" name="movieActors" rows="2"></textarea><br>
                <label for="movieDirectors">Directors:</label><br>
                <textarea id="movieDirectors" name="movieDirectors" rows="2"></textarea><br>
                <label for="moviePrice">Basic Price:</label><br>
                <input type="number" id="moviePrice" name="moviePrice" min="0"><br><br>
                <label for="moviePoster">Product Images:</label><br>
                <input type="file" id="moviePoster" name="moviePoster[]" accept="image/*" multiple><br><br>
                <div class="hiddenCB">
                    <h3>Choose categories of movie:</h3>
                    <div>
                        <?php include ('../modules/fetch/fetchingCategories.php'); ?>
                    </div>
                </div><br />
                <label for="movieDescribe">Describe:</label><br>
                <textarea id="movieDescribe" name="movieDescribe" rows="6"></textarea><br><br>
                <div class="col-md-12">
                    <button class="btn btn-primary" type="submit">ADD</button>
                </div><br><br>
                <div class="col-sm-8">
                    <div id="add-response"></div>
                </div>
            </form>
        </div>
    </div>


    <script>
        function handleSubmitAdd(event) {
            event.preventDefault();
            let movieReleaseDate = document.getElementById("movieReleaseDate").value;
            let formattedDate = formatDate(movieReleaseDate);
            let movieDescribe = document.getElementById("movieDescribe").value;
            let movieName = document.getElementById("movieName").value;
            let movieDuration = document.getElementById("movieDuration").value;
            let movieActors = document.getElementById("movieActors").value;
            let movieDirectors = document.getElementById("movieDirectors").value;
            let moviePrice = document.getElementById("moviePrice").value;
            let moviePoster = document.getElementById("moviePoster").files[0];
            let selectedCategories = Array.from(document.querySelectorAll('input[name="category[]"]:checked'))
                .map(checkbox => {
                    return {
                        id: parseInt(checkbox.value),
                        name: checkbox.nextElementSibling.textContent.trim()
                    };
                });
            if (!movieName || !formattedDate || !movieDuration || !movieActors || !movieDirectors || !moviePrice || !moviePoster || selectedCategories.length === 0) {
                console.error("Error: All fields are required");
                return;
            }
            if (moviePoster && moviePoster.type && moviePoster.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function () {
                    let token = sessionStorage.getItem("token");
                    const base64Description = btoa(unescape(encodeURIComponent(movieDescribe)));
                    const base64Poster = reader.result.split(',')[1];
                    let movieData = {
                        title: movieName,
                        length: movieDuration,
                        releaseDate: formattedDate,
                        actor: movieActors,
                        director: movieDirectors,
                        describe: base64Description,
                        posters: base64Poster,
                        price: parseFloat(moviePrice),
                        categories: selectedCategories
                    };
                    let combinedData = {
                        movieData: movieData,
                        token: token
                    };
                    sendMovieData(combinedData);

                };
                reader.onerror = function (error) {
                    console.error("Error reading poster:", error);
                };
                reader.readAsDataURL(moviePoster);
            } else {
                console.error("Error: Selected file is not an image");
            }
        }
        function sendMovieData(movieData) {
            var xhr = new XMLHttpRequest();
            var url = '../modules/func/addMovie.php';
            xhr.open("POST", url, true);
            xhr.setRequestHeader("Content-Type", "application/json");
            xhr.onload = function () {
                if (xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    var updateResponseElement = document.getElementById("add-response");
                    updateResponseElement.innerHTML = "Add movie successful";
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
                console.error("Request add failed");
            };

            var jsonData = JSON.stringify(movieData);
            xhr.send(jsonData);
        }
        document.getElementById("add-form").addEventListener("submit", handleSubmitAdd);



        function formatDate(dateString) {
            const parts = dateString.split("-");
            return `${parts[2]}-${parts[1]}-${parts[0]}`;
        }
    </script>
</body>

</html>