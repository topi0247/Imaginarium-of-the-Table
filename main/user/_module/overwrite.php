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
    $error_text += ["error_text" => $text];
    send_discord("異世界から終端をもたらすか",$text);
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

// Discordへ通知
function send_discord($name,$text){
    $msg = array(
        "username" => $name,
        "content" => $text,
    );

    $webhook = "https://discord.com/api/webhooks/1106954437462867998/ZPW9uhNvmFdsioI3MMKQ5-2Z8Aw09xJwHBOnxGE-6v5VbXA4I3LpfRuXlBiS8ASzLIL7";
    $options = array(
        "http" => array(
            "method" => "POST",
            "header" => "Content-type: application/json",
            "content" => json_encode($msg),
        ));
    file_get_contents($webhook, false, stream_context_create($options));
}

// 文字列をhtmlエンティティ置き換え
function html_replace($text,$list = false){
    $result = $text;
    // ルビ
    $ruby = "/\[RB:(.*?)>(.*?)\]/";
    $replace = "<ruby><rb>$1</rb><rp>（</rp><rt>$2</rt><rp>）</rp></ruby>";
    $result = preg_replace($ruby, $replace, $result);
    // 文字小
    $small ="/\[S:(.*?)\]/";
    $replace = $list ? "$1" : "<span class='small'>$1</span>";
    $result = preg_replace($small, $replace, $result);
    // 文字大
    $large ="/\[L:(.*?)\]/";
    $replace = $list ? "$1" : "<span class='large'>$1</span>";
    $result = preg_replace($large, $replace, $result);
    // 文字中央
    $center ="/\[C:(.*?)\]/";
    $replace = $list ? "$1" : "<span class='block center'>$1</span>";
    $result = preg_replace($center, $replace, $result);
    // 文字右
    $right ="/\[R:(.*?)\]/";
    $replace = $list ? "$1" : "<span class='block right'>$1</span>";
    $result = preg_replace($right, $replace, $result);
    // 改行
    $break = "/\r\n|\r|\n/";
    $replace =  $list ? "　" : "<br>";
    $result = preg_replace($break, $replace, $result);

    return $result;
}

/* ============================================== */
/*                 データ読み込み                 */
/* ============================================== */
parse_str(json_decode($_POST["form_data"]), $jsonData);

// 投稿Type
$type = $jsonData["type"];
// 投稿番号
$postid = $jsonData["postid"];
// 匿名フラグ
$anonymous = isset($jsonData["anonymous"]) ? "true" : "false";
// タイトル
$title = html_replace($jsonData["title"]);
// 表紙
$img = $jsonData["novel-cover"];
// カテゴリー
$category = $jsonData["category"];
// ハッシュタグ
$taglist;
if(!empty($jsonData["hash-tag"])){
    $tmp = preg_split("/[\s|\x{3000}]+/u", $jsonData["hash-tag"]);
    foreach($tmp as $t){
        $taglist[] = $t;
    }
}
// キャプション
$caption = !empty($jsonData["caption"]) ? html_replace($jsonData["caption"]):"";
// リスト用キャプション
$list_caption = !empty($jsonData["caption"]) ? html_replace($jsonData["caption"],true):"";
// 文字数
$length = $jsonData["length"];
// 読了時間（600文字/m計算）
$readtime="";
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
$afterword = !empty($jsonData["afterword"]) ? html_replace($jsonData["afterword"]):"";
// 小説本文
$page_count = $jsonData["pages"];
$pages;
for ($i = 1; $i < $page_count + 1; $i++) {
    $pages[]= html_replace($jsonData[$i]);
}

/******************************/
/*         データ設定         */
/******************************/
// ユーザーid
$userid = $_COOKIE["loginuserid"] === "develop" ? "0000" : $_COOKIE["loginuserid"];
// 更新日時
$datetime = new DateTime();
$datetime->setTimeZone(new DateTimeZone("Asia/Tokyo"));
$updateday = $datetime->format("Y/m/d G:i");
// 成功フラグ
$succes;

/****************************************/
/*         各種パス・ファイル名         */
/****************************************/
$data_path = "../../data";
// 個人データまでのパス
$userdata_path = "{$data_path}/{$userid}/{$type}";
// データファイル
$data_file = "{$userdata_path}/{$postid}.xml";
// 個人データリストファイル
$private_list_file = "{$userdata_path}/lists.xml";


/* =========================================== */
/*                 xml読み込み                 */
/* =========================================== */
$data_root = simplexml_load_file($data_file);
$data_info = $data_root->info;
$private_root = simplexml_load_file($private_list_file);

/**********************************/
/*         個人リスト検索         */
/**********************************/
$count = 0;
foreach($private_root->novel as $novel){
    if((string)$novel->postid === $postid){
        break;
    }
    $count++;
}
$private_data = $private_root->novel[$count];

/* ========================================== */
/*                 上書き操作                 */
/* ========================================== */
/**********************************************/
/*         小説データ・個人リスト共通         */
/**********************************************/
// 匿名
$data_root["anonymous"] = $anonymous;
$private_data["anonymous"] = $anonymous;

// タイトル
$data_info->title = $title;
$private_data->title = $title;

// 表紙
$data_info->img = $img;
$private_data->img = $img;

// カテゴリー
$data_info->category = $category;
$private_data->category = $category;

// ハッシュタグ
$data_tags = $data_info->tags;
$private_tags = $private_data->tags;
if ($data_tags->count() > 0) {
    // 一度全部消す
    unset($data_tags->tag);
}
if ($private_tags->count() > 0) {
    // 一度全部消す
    unset($private_tags->tag);
}
if(!empty($taglist)){
    foreach($taglist as $tag){
        $data_tags->addChild("tag",$tag);
        $private_tags->addChild("tag",$tag);
    }
}

// キャプション
$data_info->caption = $caption;
$private_data->caption = $list_caption;

// 文字数
$data_info->length = $length;
$private_data->length = $length;

// 読了時間
$data_info->readtime = $readtime;
$private_data->readtime = $readtime;

// 更新日
$data_info->updateday = $updateday;
$private_data->updateday = $updateday;

/******************************/
/*         小説データ         */
/******************************/
// 後書き
$data_info->afterword = $afterword;

// 本文
unset($data_root->body);
$novel_body = $data_root->addChild("body");
foreach($pages as $p){
    $novel_body->addChild("page",$p);
}

/* ==================================================== */
/*                      上書き保存                      */
/* ==================================================== */
/******************************/
/*         小説データ         */
/******************************/
$novel_dom = new DOMDocument('1.0');
$novel_dom->formatOutput = true;
$novel_dom->preserveWhiteSpace = false;
$novel_dom->loadXML($data_root->asXML());
$novel_dom->save($data_file);

/******************************/
/*         個人リスト         */
/******************************/
$private_dom = new DOMDocument('1.0');
$private_dom->formatOutput = true;
$private_dom->preserveWhiteSpace = false;
$private_dom->loadXML($private_root->asXML());
$private_dom->save($private_list_file);

/********************************************/
/*         公開されてるかどうか確認         */
/********************************************/
$public_list_file = "../../data/{$type}_lists.xml";
$public_root = simplexml_load_file($public_list_file);
if($type === "novel") $public_datas = $public_root->novel;
$public_exist = false;
$index = 0;
foreach($public_datas as $data){
    if($userid === (string)$data->userid && $postid === (string)$data->postid){
        $public_exist = true;
        break;
    }
    $index++;
}

// 非公開ならここで終了
if(!$public_exist){
    $message = ["result" => "success"];
    $message += ["type" => "novel"];
    $message += ["userid" => $userid];
    $message += ["postid" => $postid];
    send_message_exit($message);
}


/* ============================================== */
/*                 公開リスト                     */
/* ============================================== */
$public_data = $public_datas[$index];
// 匿名
$public_data["anonymous"] = $anonymous;
// タイトル
$public_data->title = $title;
// 表紙
$public_data->img = $img;
// カテゴリー
$public_data->category = $category;
// ハッシュタグ
$public_tags = $public_data->tags;
if ($public_tags->count() > 0) {
    // 一度全部消す
    unset($public_tags->tag);
}
if(!empty($taglist)){
    foreach($taglist as $tag){
        $public_tags->addChild("tag",$tag);
    }
}
// キャプション
$public_data->caption = $list_caption;
// 文字数
$public_data->length = $length;
// 読了時間
$public_data->readtime = $readtime;
// 更新日
$public_data->updateday = $updateday;
// 出力
$public_dom = new DOMDocument("1.0");
$public_dom->formatOutput = true;
$public_dom->preserveWhiteSpace = false;
$public_dom->loadXML($public_root->asXML());
$public_dom->save($public_list_file);

/* ======================================== */
/*                 終了                     */
/* ======================================== */
$message = ["result" => "success"];
$message += ["type" => "novel"];
$message += ["userid" => $userid];
$message += ["postid" => $postid];
send_message_exit($message);