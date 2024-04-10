<?php

function fetchAllCategories()
{
    $url = "http://192.168.2.10:8083/cinema/categories";
    $data = file_get_contents($url);

    if ($data !== false) {
        $categories = [];
        $result = json_decode($data, true);

        if ($result !== null) {
            foreach ($result as $category) {
                if (isset($category['id']) && isset($category['name'])) {
                    $categoryId = (int) $category['id'];
                    $categories[] = ['id' => $categoryId, 'name' => $category['name']];
                }
            }
            return $categories;
        } else {
            echo "Failed to decode JSON.";
            return [];
        }
    } else {
        echo "Failed to fetch data from the URL.";
        return [];
    }
}

$allCategories = fetchAllCategories();

$selectedCategoryIds = $_GET['category'] ?? [];

echo '<div class="row">';
foreach ($allCategories as $category) {
    $id = str_replace(' ', '_', strtolower($category['name']));
    $checked = in_array($category['id'], $selectedCategoryIds) ? 'checked' : '';
    echo '<div class="col-md-3" style="padding: 10px">';
    echo '<input type="checkbox" name="category[]" id="' . $id . '" value="' . $category['id'] . '" class="outline-checkbox" ' . $checked . ' />';
    echo '<label for="' . $id . '" class="outline-label">' . $category['name'] . '</label>';
    echo '</div>';
}
echo '</div>';
?>