<?php
echo '<style>';
echo '.seat {';
echo '    display: inline-block;';
echo '    background-color: green; ';
echo '    width: 30px;';
echo '    height: 30px;';
echo '    padding: 5px;';
echo '    margin: 5px; ';
echo '}';
echo '</style>';
if (isset($movieId)) {
    $id = $movieId;
    $url = "http://192.168.2.9:8083/cinema/detailMoviethreater?id=$id";
    $data = file_get_contents($url);
    if ($data !== false) {
        $result = json_decode($data, true);
        if ($result !== null) {
            echo '<div class="col-lg-4 py-3">';
            echo '<div class="card-blog">';
            echo '<div class="header">';
            echo '<div class="post-thumb" style="text-align: center;">';
            echo '<h2>' . $result['film']['name'] . '</h2>';
            echo '</div>';
            echo '</div>';
            echo '<div class="body">';
            echo '<h5 class="post-title">';
            echo '<a href="blog-details.html">Theater Number: ' . $result['numberThreater'] . '</a>';
            echo '</h5>';
            echo '<div class="post-date">';
            echo '<h6> Show time: <a href="#">' . $result['time'] . '</a></h6>';
            echo '</div>';
            echo '<div class="post-date">';

            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            foreach ($result['seat'] as $rowIndex => $row) {
                echo '<div class="seat-row">';
                foreach ($row as $colIndex => $seat) {
                    $colLabel = chr(65 + $colIndex);
                    $seatLabel = $colLabel . $rowIndex;
                    $color = ($seat == 0) ? 'green' : 'red';
                    echo '<div class="seat" style="background-color: ' . $color . ';">' . $seatLabel . '</div>';
                }
                echo '</div>';
            }
        } else {
            echo "Failed to decode JSON data.";
        }
    } else {
        echo "Failed to fetch data from the API.";
    }
}
?>