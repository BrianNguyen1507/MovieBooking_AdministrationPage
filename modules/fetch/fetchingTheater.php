<?php
try {
  $url = 'http://192.168.2.9:8083/cinema/getAllMovieThreater';
  $data = file_get_contents($url);
  if ($data !== false) {
    $result = json_decode($data, true);
  }

  // Sắp xếp các rạp chiếu phim theo số thứ tự từ nhỏ đến lớn
  usort($result, function ($a, $b) {
    return $a['numberThreater'] - $b['numberThreater'];
  });

  // Tính tổng số trang
  $totalItems = count($result);
  $itemsPerPage = 15;
  $totalPages = ceil($totalItems / $itemsPerPage);

  // Lấy trang hiện tại
  $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
  $offset = ($currentPage - 1) * $itemsPerPage;
  $paginatedResults = array_slice($result, $offset, $itemsPerPage);
} catch (PDOException $err) {
  echo "<script>console.log('FAILED. Error: $err' );</script><br><br>";
}
?>

<div>Total Theater: <?php echo $totalItems; ?></div>
</br>
<div class="row">
  <?php
  foreach ($result as $ele) {

    $filmId = $ele['film']['id'];
    $filmName = $ele['film']['name'];

    echo '
    <div class="col-lg-4 py-3 d-flex justify-content-center">
      <div class="card-blog">
        <div class="header">
          <div class="post-thumb" style="text-align: center;">
            <h1> ' . $ele['numberThreater'] . '</h1>
          </div>
        </div>
        <div class="body">
          <h5 class="post-title">
            <a href="blog-details.html">Theater Number: ' . $ele['numberThreater'] . '</a>
          </h5>
          <div class="post-date">
            <h6> Show time: <a href="#">' . $ele['time'] . '</a></h6>
          </div>
          <div class="post-date">
            <h6> Movie name: <a href="#">' . $filmName . '</a></h6>
          </div>
          <a href="theater-detail?id='. $ele['id'] .'" class="btn btn-info">View More</a>
        </div>
      </div>
      
    </div>';
  }
  ?>
  <nav aria-label="Page Navigation">
    <ul class="pagination justify-content-center">
      <li class="page-item <?php echo $currentPage == 1 ? 'disabled' : ''; ?>">
        <a class="page-link" href="?page=<?php echo $currentPage - 1; ?>" tabindex="-1"
          aria-disabled="true">Previous</a>
      </li>
      <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <li class="page-item <?php echo $i == $currentPage ? 'active' : ''; ?>">
          <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
        </li>
      <?php endfor; ?>
      <li class="page-item <?php echo $currentPage == $totalPages ? 'disabled' : ''; ?>">
        <a class="page-link" href="?page=<?php echo $currentPage + 1; ?>">Next</a>
      </li>
    </ul>
  </nav>