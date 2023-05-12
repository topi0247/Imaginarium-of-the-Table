<?php
/* ============================================== */
/*               エラー発生時の対処               */
/* ============================================== */
// set_error_handler(function($error_no, $error_msg, $error_file, $error_line, $error_vars) {
//     if (error_reporting() === 0) {
//         return;
//     }
//     throw new ErrorException($error_msg, 0, $error_no, $error_file, $error_line);
// });

// set_exception_handler(function($throwable) {
//     $development = $_SERVER['HTTP_HOST'] == 'localhost-iott' ? true : false;
//     if ($development === true) {
//         echo $throwable;
//     }
//     send_error_log($throwable);
// });

// register_shutdown_function(function() {
//     $error = error_get_last();
//     if ($error === null) {
//         return;
//     }
//     send_error_log(new ErrorException($error['message'], 0, 0, $error['file'], $error['line']));
// });

// ini_set('display_errors', 'Off');

// function send_error_log($throwable) {
//     $development = $_SERVER['HTTP_HOST'] == 'localhost-iott' ? true : false;
//     if($development === false){
//         error_log($throwable->__toString(),1 , 'admin@imaginarium-of-the-table.wew.jp');
//     }
// }

/* ============================================== */
/*                      出力                      */
/* ============================================== */

// テンプレートを読み込み
$novel_xml = simplexml_load_file('../../data/0000/novel/0000.xml');

// 匿名フラグ
$anonymous = isset($_POST['anonymous']) ? 'true' :'false';
$novel_xml['anonymous'] = $anonymous;

// 情報
$info = $novel_xml->info;

// ファイル作成日時
$datetime = new DateTime();
$info->createday = $datetime->format('Y/m/d G:i');

// 投稿日時
$postday = $datetime->format('Y/m/d G:i');
$info->postday = $postday;

// タイトル
$title = $_POST['title'];
$info->title = $title;

// 表紙
$img = $_POST['novel-cover'];
$info->img = $img;

// カテゴリー
$category = $_POST['category'];
$info->category = $category;

// ハッシュタグ
$taglist = [];
unset($info->tags->tag);
if($_POST['hash-tag']){
    $tmp = preg_split('/[\s|\x{3000}]+/u', $_POST['hash-tag']);
    foreach($tmp as $t){
        $taglist[] = $t;
        $info->tags->addChild('tag', $t);
    }
}

// キャプション
$caption = isset($_POST['caption']) ? nl2br($_POST['caption']) : '';
$info->caption = str_replace('<br>', '&#60;br&#62;', $caption);

// 文字数
$length = $_POST['length'];
$info->length = $length;

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
$info->readtime = $readtime;

// 後書き
$afterword = isset($_POST['afterword']) ? nl2br($_POST['afterword']) : '';
$info->afterword = str_replace('<br>', '&#60;br&#62;', $afterword);


// 小説本文
$body = $novel_xml->body;
$pages = $_POST['pages'];
unset($body ->page);
for ($i = 1; $i < $pages + 1; $i++) {
    $tmp =  nl2br($_POST[$i]);
    $tmp = str_replace('<br>', '&#60;br&#62;', $tmp);
    $body->addChild('page', $tmp);
}

// ユーザーid
$userid = isset($_COOKIE['develop']) ? '0000' : $_COOKIE['loginuserid'];

// データ格納場所
$dir = '../../data/'. $userid .'\/novel\/';
if(!file_exists($dir.'0000.xml')){
    $postid = '0000';
}else{
    $novels = glob($dir.'[0-9]'.'.xml');
    $postid = basename(end($novels), '.xml') + 1;
}
$postid = sprintf('%04d',$postid);
$file_name = $postid . '.xml';

// 別名で保存
$novel_xml->asXml($dir.$file_name);

// ユーザー執筆リストに登録
$list_path = '../../data/'. $userid .'/novel/lists.xml';
if(file_exists($list_path)){
    $list_xml = simplexml_load_file($list_path);
}
else {
    $list_xml = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><novels></novels>');
}
$novel = $list_xml->addChild('novel');
$novel['anonymous'] = $anonymous;
$novel->addChild('title',$title);
$novel->addChild('img',$img);
$novel->addChild('userid',$userid);
$novel->addChild('postid',$postid);
$novel->addChild('category',$category);
$tags = $novel->addChild('tags');
if (!empty($taglist)) {
    foreach($taglist as $tag){
        $tags->addChild('tag', $tag);
    }
}
$novel->addChild('caption',$caption);
$novel->addChild('length',$length);
$novel->addChild('readtime',$readtime);
$novel->addChild('postday',$postday);
$novel->addChild('updateday','');
// 保存
$dom = new DOMDocument('1.0','utf-8');
$dom->preserveWhiteSpace = true;
$dom->formatOutput = true;
$dom->loadXML( $list_xml->asXML() );
$dom->save($list_path);


// 公開用リストに登録
$op_list_path = '../../data/novel_lists.xml';
$op_list_xml = simplexml_load_file($op_list_path);
$op_novel = $op_list_xml->addChild('novel');
$op_novel['anonymous'] = $anonymous;
$op_novel->addChild('title',$title);
$op_novel->addChild('img',$img);
$op_novel->addChild('userid',$userid);
$op_novel->addChild('postid',$postid);
$op_novel->addChild('category',$category);
$op_tags = $op_novel->addChild('tags');
if (!empty($taglist)) {
    foreach($taglist as $tag){
        $op_tags->addChild('tag', $tag);
    }
}
$op_novel->addChild('caption',$caption);
$op_novel->addChild('length',$length);
$op_novel->addChild('readtime',$readtime);
$op_novel->addChild('postday',$postday);
$op_novel->addChild('updateday','');
// 保存
$op_dom = new DOMDocument('1.0','utf-8');
$op_dom->preserveWhiteSpace = true;
$op_dom->formatOutput = true;
$op_dom->loadXML( $op_list_xml->asXML() );
$op_dom->save($op_list_path);


$url = $_SERVER['HTTP_REFERER'];
$url = strtok($url, '?');
header("Location:" . $url . "?post=success&posttype=novel&userid=" . $userid . '&postid=' . $postid);
exit;
