<?php
try {
  $url = 'http://192.168.2.9:8083/cinema/showAllFilm';
  $movieCount = 0;
  $data = file_get_contents($url);
  if ($data !== false) {
    $result = json_decode($data, true);
  }
  $movieCount = count($result);
} catch (PDOException $err) {
  echo "<script>console.log('FAILED. Error: $err' );</script><br><br>";
}
?>


<div>Total movies: <?php echo $movieCount; ?></div>
</br>
<div class="row">
  <?php
  foreach ($result as $ele) {
    $imageData = base64_decode($ele['posters']);
    $imageResource = imagecreatefromstring($imageData);
    if ($imageResource !== false) {
      ob_start();
      imagejpeg($imageResource, null, 75);
      $imageData = ob_get_clean();
      $imageData = base64_encode($imageData);
      $imageSrc = 'data:image/jpeg;base64,' . $imageData;
      echo '
        <div class="col-lg-3">
          <div class="card-service wow fadeInUp">
            <div class="header">
              <img src="' . $imageSrc . '" alt="">
            </div>
            <div class="body">
              <h5 class="text-secondary">' . $ele["title"] . '</h5>
              <div style="font-size: 1.2em; color: grey; font-weight: bold; margin-bottom: 10px;"> <span> <sup>$</sup>' . $ele["price"] . ' </span> </div>
              <div style="margin-bottom:10px;">
              </div>
              <a href="Views/movieDetail?id=' . $ele["id"] . '" class="btn btn-info">View More</a>
            </div>
          </div>
        </div>';
      imagedestroy($imageResource);
    } else {
      echo 'Failed to create image resource for ID: ' . $ele['id'];
    }
  }
  ?>
</div>