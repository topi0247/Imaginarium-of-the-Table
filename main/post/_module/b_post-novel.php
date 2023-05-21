<?php
header("Content-type: application/json; charset=utf-8");

/* ============================================================== */
/*                 自サイト以外からの受け入れ拒否                 */
/* ============================================================== */
$referrer = $_SERVER["HTTP_REFERER"];
$domain = parse_url($referrer);
if (!stristr($domain["host"], "localhost-iott") && !stristr($domain["host"], "imaginarium-of-the-table.wew.jp")) {
    $error_text = ["result" => "error"];
    $text = "不正なアクセスを検知しました：" . $referrer;
    $error_text = $error_text + array("error_text" => $text);
    send_message_exit($error_text);
}

/* ======================================== */
/*                 多用関数                 */
/* ======================================== */
// 結果返却
function send_message_exit($array){
    echo json_encode($array);
    exit;
}

/* ============================================== */
/*                 データ読み込み                 */
/* ============================================== */
parse_str(json_decode($_POST["form_data"]), $jsonData);

// 匿名フラグ
$anonymous = isset($jsonData["anonymous"]) ? "true" : "false";
// タイトル
$title = $jsonData["title"];
// 表紙
$img = $jsonData["novel-cover"];
// カテゴリー
$category = $jsonData["category"];
// ハッシュタグ
$taglist = [];
if(!empty($jsonData["hash-tag"])){
    $tmp = preg_split("/[\s|\x{3000}]+/u", $jsonData["hash-tag"]);
    foreach($tmp as $t){
        $taglist[] = $t;
    }
}
// キャプション
$caption = empty($jsonData["caption"]) ? htmlspecialchars(str_replace(array("\r\n", "\r", "\n"), "", $jsonData["caption"])) : "";
// 文字数
$length = $jsonData["length"];
// 読了時間（600文字/m計算）
$readtime = "";
if ($length >= 600) {
    $min = round($length / 600);
    if ($min >= 60) {
        $hour = round($min / 60);
        $min = $min - ($hour * 60);
        $readtime = $hour . "時間";
    }
    $readtime .= $min . "分";
} else {
    $readtime = 1 . "分";
}
// 後書き
$afterword = empty($jsonData["afterword"]) ? htmlspecialchars(str_replace(array("\r\n", "\r", "\n"), "", $jsonData["afterword"])) : "";
// 小説本文
$page_count = $jsonData["pages"];
$pages = [];
for ($i = 1; $i < $page_count + 1; $i++) {
    $pages[]= htmlspecialchars(str_replace(array("\r\n", "\r", "\n"), "", $jsonData[$i]));
}
// 非公開設定
$post_private = empty($jsonData["is_private"]) ? false : true;

/******************************/
/*         データ設定         */
/******************************/
// ユーザーid
$userid = $_COOKIE["loginuserid"] === "develop" ? "0000" : $_COOKIE["loginuserid"];
// ファイル作成日時
$datetime = new DateTime();
$datetime->setTimeZone(new DateTimeZone("Asia/Tokyo"));
$createday = $datetime->format("Y/m/d G:i");
// 投稿日時
$postday = $datetime->format("Y/m/d G:i");
// 投稿id
$postid;
// 個人リストの存在有無
$private_list_exists = true;
// 成功フラグ
$succes;

/****************************/
/*         各種パス         */
/****************************/
$data_path = "../../data";
// 個人データまでのパス
$userdata_path = "{$data_path}/{$userid}";
// 小説データまでのパス
$noveldata_path = "{$userdata_path}/novel";
// 個人データリスト
$private_list_file = "{$noveldata_path}/lists.xml";


/* ========================================================== */
/*                    個人データリストから                    */
/*                   投稿id（postid）を決定                   */
/*                 ディレクトリがなければ作成                 */
/* ========================================================== */
if(!file_exists($userdata_path)){
    $private_list_exists = false;
    // ユーザーデータフォルダ作成
    $succes = mkdir($userdata_path, 0777,true) ? chmod($userdata_path, 0777) : false;
    if(!$succes){
        $error_text = ["result" => "error"];
        $text = "ユーザーフォルダ作成に失敗しました：post-novel / userid = {$userid} path : {$userdata_path}";
        $error_text += ["error_text" => $text];
        send_message_exit($error_text);
    }
}
if(!file_exists($noveldata_path)){
    $private_list_exists = false;
    // 小説データフォルダを作成
    $succes = mkdir($noveldata_path, 0777,true) ? chmod($noveldata_path, 0777) : false;
    if(!$succes){
        $message = ["result" => "error"];
        $text = "小説フォルダ作成に失敗しました：post-novel / userid = {$userid} path : {$noveldata_path}";
        $message += ["error_text" => $text];
        send_message_exit($message);
    }
}
// リストだけない場合
if(!file_exists($private_list_file)){
    $private_list_exists = false;
}

if($private_list_exists){
    $private_xml = simplexml_load_file($private_list_file);
    if ($private_xml->count() > 0) {
        $tmp = [];
        foreach($private_xml as $data){
            $tmp[] = (int)$data->postid;
        }
        $postid = max($tmp) + 1;
    }
    else {
        $postid = 0;
    }
}
$postid = sprintf("%04d",$postid);


/* =================================== */
/*                 DOM                 */
/* =================================== */
// 小説用
$novel_dom = new DOMDocument("1.0");
$novel_dom->encoding = "utf-8";
$novel_dom->formatOutput = true;
$novel_dom->preserveWhiteSpace = false;
$novel_root = $novel_dom->createElement("novel");
$novel_info = $novel_dom->createElement("info");
$novel_body = $novel_dom->createElement("body");

// 個人リスト
$private_dom = new DOMDocument("1.0");
$private_dom->encoding = "utf-8";
$private_dom->formatOutput = true;
$private_dom->preserveWhiteSpace = false;
if($private_list_exists){
    $private_dom->load($private_list_file);
    $private_root = $private_dom->documentElement;
}
else{
    $private_root = $private_dom->createElement("novels");
}
$private_novel = $private_dom->createElement("novel");

/**********************************************/
/*         小説データ・個人リスト共通         */
/**********************************************/
// 匿名
$novel_root->setAttribute("anonymous",$anonymous);
$private_novel->setAttribute("anonymous",$anonymous);
// タイトル
$novel_title = $novel_dom->createElement("title");
$novel_title->appendChild($novel_dom->createTextNode($title));
$novel_info->appendChild($novel_title);
$private_title = $private_dom->createElement("title");
$private_title->appendChild($private_dom->createTextNode($title));
$private_novel->appendChild($private_title);
// 表紙
$novel_img = $novel_dom->createElement("img");
$novel_img->appendChild($novel_dom->createTextNode($img));
$novel_info->appendChild($novel_img);
$private_img = $private_dom->createElement("img");
$private_img->appendChild($private_dom->createTextNode($img));
$private_novel->appendChild($private_img);
// カテゴリー
$novel_category = $novel_dom->createElement("category");
$novel_category->appendChild($novel_dom->createTextNode($category));
$novel_info->appendChild($novel_category);
$private_category = $private_dom->createElement("category");
$private_category->appendChild($private_dom->createTextNode($category));
$private_novel->appendChild($private_category);
// ハッシュタグ
$novel_tags = $novel_dom->createElement("tags");
$private_tags = $private_dom->createElement("tags");
if(!empty($taglist)){
    foreach($taglist as $tag){
        $novel_tag = $novel_dom->createElement("tag");
        $novel_tag->appendChild($novel_dom->createTextNode($tag));
        $novel_tags->appendChild($novel_tag);

        $private_tag = $private_dom->createElement("tag");
        $private_tag->appendChild($private_dom->createTextNode($tag));
        $private_tags->appendChild($private_tag);
    }
}
$novel_info->appendChild($novel_tags);
$private_novel->appendChild($private_tags);
// キャプション
$novel_caption = $novel_dom->createElement("caption");
$novel_caption->appendChild($novel_dom->createTextNode($caption));
$novel_info->appendChild($novel_caption);
$private_caption = $private_dom->createElement("caption");
$private_caption->appendChild($private_dom->createTextNode($caption));
$private_novel->appendChild($private_caption);
// 文字数
$novel_length = $novel_dom->createElement("length");
$novel_length->appendChild($novel_dom->createTextNode($length));
$novel_info->appendChild($novel_length);
$private_length = $private_dom->createElement("length");
$private_length->appendChild($private_dom->createTextNode($length));
$private_novel->appendChild($private_length);
// 読了時間
$novel_readtime = $novel_dom->createElement("readtime");
$novel_readtime->appendChild($novel_dom->createTextNode($readtime));
$novel_info->appendChild($novel_readtime);
$private_readtime = $private_dom->createElement("readtime");
$private_readtime->appendChild($private_dom->createTextNode($readtime));
$private_novel->appendChild($private_readtime);
// 投稿日
$novel_postday = $novel_dom->createElement("postday");
$novel_postday->appendChild($novel_dom->createTextNode($postday));
$novel_info->appendChild($novel_postday);
$private_postday = $private_dom->createElement("postday");
$private_postday->appendChild($private_dom->createTextNode($postday));
$private_novel->appendChild($private_postday);
// 更新日
$novel_updateday = $novel_dom->createElement("updateday");
$novel_info->appendChild($novel_updateday);
$private_updateday = $private_dom->createElement("updateday");
$private_novel->appendChild($private_updateday);

/******************************/
/*         小説データ         */
/******************************/
// 作成日
$novel_createday = $novel_dom->createElement("createday");
$novel_createday->appendChild($novel_dom->createTextNode($createday));
$novel_info->appendChild($novel_createday);
// 後書き
$novel_afterword = $novel_dom->createElement("afterword");
$novel_afterword->appendChild($novel_dom->createTextNode($afterword));
$novel_info->appendChild($novel_afterword);
// 本文
foreach($pages as $p){
    $novel_page = $novel_dom->createElement("page");
    $novel_page->appendChild($novel_dom->createTextNode($p));
    $novel_body->appendChild($novel_page);
}

/******************************/
/*         個人リスト         */
/******************************/
// ユーザーid
$private_userid = $private_dom->createElement("userid");
$private_userid->appendChild($private_dom->createTextNode($userid));
$private_novel->appendChild($private_userid);
// 投稿id
$private_postid = $private_dom->createElement("postid");
$private_postid->appendChild($private_dom->createTextNode($postid));
$private_novel->appendChild($private_postid);


/* ============================================== */
/*                      出力                      */
/* ============================================== */
/******************************/
/*         小説データ         */
/******************************/
// ルートに突っ込む
$novel_root->appendChild($novel_info);
$novel_root->appendChild($novel_body);
$novel_dom->appendChild($novel_root);
// 書き出し
$file_path = "{$noveldata_path}/{$postid}.xml";
$novel_dom->save($file_path);

/******************************/
/*         個人リスト         */
/******************************/
// ルートに突っ込む
$private_root->appendChild($private_novel);
$private_dom->appendChild($private_root);
// 書き出し
$private_dom->save($private_list_file);

// 非公開投稿であればここで終了
if($post_private){
    $message = ["result" => "success"];
    $message += ["type" => "novel"];
    $message += ["userid" => $userid];
    $message += ["postid" => $postid];
    send_message_exit($message);
}


/* ============================================== */
/*                 公開リスト                     */
/* ============================================== */
$public_dom = new DOMDocument("1.0");
$public_dom->encoding = "utf-8";
$public_dom->formatOutput = true;
$public_dom->preserveWhiteSpace = false;
$public_list_path = "{$data_path}/novel_lists.xml";
$public_dom->load($public_list_path);
$public_root = $public_dom->documentElement;
$public_novel = $public_dom->createElement("novel");
// 匿名
$public_novel->setAttribute("anonymous",$anonymous);
// タイトル
$public_title = $public_dom->createElement("title");
$public_title->appendChild($public_dom->createTextNode($title));
$public_novel->appendChild($public_title);
// 表紙
$public_img = $public_dom->createElement("img");
$public_img->appendChild($public_dom->createTextNode($img));
$public_novel->appendChild($public_img);
// カテゴリー
$public_category = $public_dom->createElement("category");
$public_category->appendChild($public_dom->createTextNode($category));
$public_novel->appendChild($public_category);
// ハッシュタグ
$public_tags = $public_dom->createElement("tags");
if(!empty($taglist)){
    foreach($taglist as $tag){
        $public_tag = $public_dom->createElement("tag");
        $public_tag->appendChild($public_dom->createTextNode($tag));
        $public_tags->appendChild($public_tag);
    }
}
$public_novel->appendChild($public_tags);
// キャプション
$public_caption = $public_dom->createElement("caption");
$public_caption->appendChild($public_dom->createTextNode($caption));
$public_novel->appendChild($public_caption);
// 文字数
$public_length = $public_dom->createElement("length");
$public_length->appendChild($public_dom->createTextNode($length));
$public_novel->appendChild($public_length);
// 読了時間
$public_readtime = $public_dom->createElement("readtime");
$public_readtime->appendChild($public_dom->createTextNode($readtime));
$public_novel->appendChild($public_readtime);
// 投稿日
$public_postday = $public_dom->createElement("postday");
$public_postday->appendChild($public_dom->createTextNode($postday));
$public_novel->appendChild($public_postday);
// 更新日
$public_updateday = $public_dom->createElement("updateday");
$public_novel->appendChild($public_updateday);
// ユーザーid
$public_userid = $public_dom->createElement("userid");
$public_userid->appendChild($public_dom->createTextNode($userid));
$public_novel->appendChild($public_userid);
// 投稿id
$public_postid = $public_dom->createElement("postid");
$public_postid->appendChild($public_dom->createTextNode($postid));
$public_novel->appendChild($public_postid);

/************************/
/*         出力         */
/************************/
$public_root->appendChild($public_novel);
// 書き出し
$public_dom->save($public_list_path);

// レス
$message = ["result" => "success"];
$message += ["type" => "novel"];
$message += ["userid" => $userid];
$message += ["postid" => $postid];
send_message_exit($message);