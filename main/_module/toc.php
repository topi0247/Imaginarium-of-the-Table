<?php
$lists = glob($data_path . '*.html');
foreach ($lists as $value) {
    $metatags =  get_meta_tags($value);
    echo '<li><a href="' . $value . '"</a>' . $metatags['title'] . '</a></li>';
}
?>