<?php

$html =  file_get_contents('base-novel.html');

// タイトル
$title = $_POST['title'] ? : 'タイトルがありません';
$html = str_replace('[[TITLE]]',$title,$html);

// ユーザー名
$html = str_replace('[[USERNAME]]',$_POST['username'],$html);

// ハッシュタグ
$taglist ='';
if($_POST['hash-tag']){
    $tag = preg_split('/[\s|\x{3000}]+/u', $_POST['hash-tag']);
    $taglist = '<ul class="hashtag">';

    foreach($tag as $t){
       $taglist .= '<li><a>' . $t . '</a></li>';
    }

    $taglist .= '</ul>';
}
$html = str_replace('[[HASHTAG]]',$taglist,$html);

// キャプション
$caption = nl2br($_POST['caption']);
$html = str_replace('[[CAPTION]]',$caption,$html);

// 小説本文
$page_count = '1';
$length = 0;
$pages = $_POST['pages'];
$novel_body ='';
while($page_count <= $pages){
    if($page_count == 1){
        $novel_body .='<div id="1" class="current">';
    } else{
        $novel_body .='<div id="' . $page_count . '>';
    }

    $section = $_POST[$page_count];
    $str = preg_replace("/(\015\012)|(\015)|(\012)/", "", $section);
    $length += mb_strlen($str,'UTF-8');

    $novel_body .=nl2br($section);
    $novel_body .='</div>';

    $page_count++;
}
$html = str_replace('[[NOVEL-BODY]]',$novel_body,$html);

// 文字数
$html = str_replace('[[LENGTH]]',$length,$html);

// 読了時間
$readtime = '';
if($length >= 600){
    $min = round($length / 600);
    $hour = round($min / 60);
    if($hour >= 1){
        $min = $time - ($hour * 60);
        $readtime = $hour . '時間';
    }
    $readtime .= $min . '分';
}else{
    $readtime = 1 . '分';
}
$html = str_replace('[[READTIME]]',$readtime,$html);

// ページタブ

// 後書き
$afterword = nl2br($_POST['afterword']);
$html = str_replace('[[AFTERWORD]]',$afterword,$html);

echo $html.'\n';