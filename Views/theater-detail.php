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
                <a href="theater.php"
                    style="position: fixed; top: 20px; left: 20px; font-size: 24px; color: black;font-weight:bold ;text-decoration: none;">&#8592;
                </a>
            </div>
        </div>
    </div>
    <div class="services">
        <?php

        if (isset($_GET['id'])) {
            $movieId = $_GET['id'];
            include "../modules/fetch/fetchingTheater-detail.php";
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
</body>

</html>