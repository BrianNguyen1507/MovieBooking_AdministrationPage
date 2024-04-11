<?php

if (isset($movieId)) {
    $id = $movieId;
    $url = "http://192.168.2.9:8083/cinema/detailFilm?id=$id";
    $data = file_get_contents($url);
    if ($data !== false) {
        $result = json_decode($data, true);
    }
    $selectedCategories = array_column($result['categories'], 'name');
    $imageData = base64_decode($result['posters']);
    $imageResource = imagecreatefromstring($imageData);
    if ($imageResource !== false) {
        ob_start();
        imagejpeg($imageResource, null, 75);
        $imageData = ob_get_clean();
        $imageData = base64_encode($imageData);
        $imageSrc = 'data:image/jpeg;base64,' . $imageData;
        echo '<div><h2>' . $result['title'] . '</h2></div>';
        echo '<div class="products" style="margin-top:50px">
                <div class="container"> 
                    <div class="row">
                        <div class="col-md-4 col-xs-12">
                            <div>
                                <img id="movieImage" src="' . $imageSrc . '" alt="" class="img-fluid wc-image">
                            </div>
                            <br>
                            <!-- Add the file input here -->
                            <input type="file" id="fileInput" style="display: none;" accept="image/*" onchange="previewImage(event)">
                            <button class="btn btn-info" type="button" onclick="openFileInput()">Change Poster</button>
                        </div>
                        <div class="col-md-8 col-xs-12">
                            <form action="" id="detail-form" class="form"  method="post" enctype="multipart/form-data" onsubmit="return handleUpdateSubmit(event);">
                           
                                <label>Name</label><br/>
                                <input type="text" name="title"  value="' . $result['title'] . '"></input><br/>
                                <br>
                                <label>Price</label><br/>
                                <input  type="text" name="price" min="0" value="' . $result['price'] . '"></input> <br/><br/>
                                <label>Length</label><br/>
                                <input  type="text" name="length" min="0" value="' . $result['length'] . '"></input> <br/><br/>
                                <label>Date release</label><br/>
                                <input  type="text" name="releaseDate" min="0" value="' . $result['releaseDate'] . '"></input> <br/><br/>
                                <label>Director</label><br/>   
                                <input  type="text" name="director" min="0" value="' . $result['director'] . '"></input> <br/><br/>
                                <label>Actor</label><br/>   
                                <input  type="text" name="actor" min="0" value="' . $result['actor'] . '"></input> <br/><br/>
                                <label>Describe</label><br/>                                     
                                <textarea name="describe" name="movieActor"  rows="6" class="form-control" id="description">' . $result['describe'] . '</textarea>
                                                                   
                                <input type="hidden" name="posters" name="posters"  rows="6" class="form-control" id="posters" value="' . $result['posters'] . '"</input>
                                
                                <br> <label>Categories</label><br/>';
        $allCategories = include ('fetchingUpdateCategories.php');
        foreach ($allCategories as $category) {
            $checked = in_array($category['name'], $selectedCategories) ? 'checked' : '';
            echo '<input type="checkbox" name="category[' . $category['id'] . ']" value="' . $category['name'] . '" ' . $checked . '> ' . $category['name'] . '<br>';
        }

        echo '<br>
                              
                                <br>
                                <div id="update-response"></div>
                                <div id="remove-response"></div>
                                <div>
                                    <div class="clearfix">
                                    <button class="btn btn-primary float-left" type="submit" onclick="handleUpdateSubmit(event)">Apply</button>
                                    <button class="btn btn-secondary float-right" type="button" onclick="handleRemoveSubmit(event)" id="deleteBtn">Delete</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>';
    }
}
