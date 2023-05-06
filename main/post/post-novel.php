<?php

// プレビューモードかどうか
$preview = $_POST['preview'];
if ($preview === 'true') {
    echo Novel_Replace();
} else {
    if(isset($_POST['draft'])) NovelSave();
    else if(isset($_POST['post'])) NovelPost();
}

// データ保存
function NovelSave(){
    $result = 'success';
    
    form_result('draft',$result);
}

// 投稿
function NovelPost(){
    $file_dir = '../novel/';
    $extension = '.html';
    $post_id = CreateFileName($file_dir, $extension);
    $file_name = $file_dir . $post_id . $extension;

    $html = Novel_Replace();
    $fp = fopen($file_name,'w');
    fwrite($fp,$html);
    fclose($fp);

    //$result = 'success';
    
    //form_result('post',$result);
    $url = $_SERVER['HTTP_REFERER'];
    $url = strtok($url, '?');
    header("Location:" . $url . '?post=success&postid=' . $post_id);
    die;
}

function Form_Result($param1,$param2){
    $url = $_SERVER['HTTP_REFERER'];
    $url = strtok($url, '?');
    header("Location:" . $url . "?" . $param1 . '=' . $param2);
    die;
}

// ファイル名前作成
function CreateFileName($dir,$extension){
    $user = $_POST['username'];
    $min_id = 10000;
    $max_id = 99999;
    $post_id = rand($min_id,$max_id);
    $file_name = $user . $post_id . $extension;

    while(file_exists($dir . $file_name)){
        $post_id = rand($min_id,$max_id);
        $file_name = $user . $post_id . $extension;
    }

    return $user . $post_id;
}


// ベースから置き換え処理
function Novel_Replace(){
    $html =  file_get_contents('base-novel.html');

    // タイトル
    $title = $_POST['title'] ?: 'タイトルがありません';
    $html = str_replace('[[TITLE]]', $title, $html);

    // ユーザー名
    $html = str_replace('[[USERNAME]]', $_POST['username'], $html);

    // ハッシュタグ
    $taglist = '';
    if ($_POST['hash-tag']) {
        $tag = preg_split('/[\s|\x{3000}]+/u', $_POST['hash-tag']);
        $taglist = '<ul class="hashtag">';

        foreach ($tag as $t) {
            $taglist .= '<li><a>' . $t . '</a></li>';
        }

        $taglist .= '</ul>';
    }
    $html = str_replace('[[HASHTAG]]', $taglist, $html);

    // キャプション
    $caption = nl2br($_POST['caption']);
    $html = str_replace('[[CAPTION]]', $caption, $html);

    // 小説本文とページボタン
    $page_count = '1';
    $length = 0;
    $pages = $_POST['pages'];
    $novel_body = '';
    $page_button ='';
    while ($page_count <= $pages) {
        if ($page_count == 1) {
            $novel_body .= '<div id="1" class="current">';
            $page_button .='<button type="button" class="current">1</button>';
        } else {
            $novel_body .= '<div id="' . $page_count . '">';
            $page_button .='<button type="button">' . $page_count . '</button>';
        }

        $section = $_POST[$page_count];
        $str = preg_replace("/(\015\012)|(\015)|(\012)/", "", $section);
        $length += mb_strlen($str, 'UTF-8');

        $novel_body .= nl2br($section);
        $novel_body .= '</div>';

        $page_count++;
    }
    $html = str_replace('[[NOVEL-BODY]]', $novel_body, $html);
    $html = str_replace('[[PAGE-TAB]]', $page_button, $html);

    // 文字数
    $html = str_replace('[[LENGTH]]', $length, $html);

    // 読了時間
    $readtime = '';
    if ($length >= 600) {
        $min = round($length / 600);
        if ($min >= 60) {
            $hour = round($min / 60);
            $min = $min - ($hour * 60);
            $readtime = $hour . '時間';
        }
        $readtime .= $min . '分';
    } else {
        $readtime = 1 . '分';
    }
    $html = str_replace('[[READTIME]]', $readtime, $html);

    // 後書き
    $afterword = nl2br($_POST['afterword']);
    $html = str_replace('[[AFTERWORD]]', $afterword, $html);

    return $html;
}
