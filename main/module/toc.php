<?php
$lists = glob($data_path . '*.html');
foreach ($lists as $value) {
    $metatags =  get_meta_tags($value);
    echo '<li><a href="' . $value . '"</a>' . $metatags['title'] . '</a></li>';
}

// if($toc_novel){
//     foreach ($lists as $value) {
//         $metatags =  get_meta_tags($value);
//         echo '<li><a href="' . $value . '"</a>' . $metatags['title'] . '</a></li>';
//     }
// }else if($toc_illust){
//     foreach ($lists as $value) {
//         $metatags =  get_meta_tags($value);
//         echo '<li><a href="' . $value . '"</a>' . $metatags['title'] . '</a></li>';
//     }
// }else if($toc_session){
//     foreach ($lists as $value) {
//         $metatags =  get_meta_tags($value);
//         echo '<li><a href="' . $value . '"</a>' . $metatags['title'] . '</a></li>';
//     }
// } 
?>
<!--
    $data_path = 'novel';
    $toc_novel = fales;
    $toc_illust = false;
    $toc_session = false;
-->
