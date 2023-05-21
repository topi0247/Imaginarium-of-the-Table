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
$taglist;
if(!empty($jsonData["hash-tag"])){
    $tmp = preg_split("/[\s|\x{3000}]+/u", $jsonData["hash-tag"]);
    foreach($tmp as $t){
        $taglist[] = $t;
    }
}
// キャプション
$caption = !empty($jsonData["caption"]) ? htmlspecialchars(str_replace(array("\r\n", "\r", "\n"), "<br>", $jsonData["caption"])) : "";
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
$afterword = !empty($jsonData["afterword"]) ? htmlspecialchars(str_replace(array("\r\n", "\r", "\n"), "<br>", $jsonData["afterword"])) : "";
// 小説本文
$page_count = $jsonData["pages"];
$pages;
for ($i = 1; $i < $page_count + 1; $i++) {
    $pages[]= htmlspecialchars(str_replace(array("\r\n", "\r", "\n"), "<br>", $jsonData[$i]));
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

/****************************************/
/*         各種パス・ファイル名         */
/****************************************/
$data_path = "../../data";
// 個人データまでのパス
$userdata_path = "{$data_path}/{$userid}";
// 小説データまでのパス
$noveldata_path = "{$userdata_path}/novel";
// 個人データファイル
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
        send_discord("空想世界で揃う星辰",$text);
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
        send_discord("空想世界で揃う星辰",$text);
        send_message_exit($message);
    }
}
// リストだけない場合
if(!file_exists($private_list_file)){
    $private_list_exists = false;
}

if($private_list_exists){
    $private_root = simplexml_load_file($private_list_file);
    if ($private_root->count() > 0) {
        $tmp = [];
        foreach($private_root as $data){
            $tmp[] = (int)$data->postid;
        }
        $postid = max($tmp) + 1;
    }
    else {
        $postid = 0;
    }
}
$postid = sprintf("%04d",$postid);

// ファイル名
$novel_file = "{$noveldata_path}/{$postid}.xml";

/* ======================================= */
/*                 xml作成                 */
/* ======================================= */
// 小説
$novel_xml = <<<EOM
<?xml version="1.0" encoding="utf-8"?>
<novel>
</novel>
EOM;
$novel_root = new SimpleXMLElement($novel_xml);
$novel_info = $novel_root->addChild("info");

// 個人リスト
if(!$private_list_exists){
    $private_xml = <<<EOM
    <?xml version="1.0" encoding="utf-8"?>
    <novels>
    </novels>
    EOM;
    $private_root = new SimpleXMLElement($private_xml);
}
$private_novel = $private_root->addChild("novel");

/**********************************************/
/*         小説データ・個人リスト共通         */
/**********************************************/
// 匿名
$novel_root->addAttribute("anonymous",$anonymous);
$private_novel->addAttribute("anonymous",$anonymous);

// タイトル
$novel_info->addChild("title",$title);
$private_novel->addChild("title",$title);

// 表紙
$novel_info->addChild("img",$img);
$private_novel->addChild("img",$img);

// カテゴリー
$novel_info->addChild("category",$category);
$private_novel->addChild("category",$category);

// ハッシュタグ
$novel_tags = $novel_info->addChild("tags");
$private_tags = $private_novel->addChild("tags");
if(!empty($taglist)){
    foreach($taglist as $tag){
        $novel_tags->addChild("tag",$tag);
        $private_tags->addChild("tag",$tag);
    }
}

// キャプション
$novel_info->addChild("caption",$caption);
$private_novel->addChild("caption",$caption);

// 文字数
$novel_info->addChild("length",$length);
$private_novel->addChild("length",$length);

// 読了時間
$novel_info->addChild("readtime",$readtime);
$private_novel->addChild("readtime",$readtime);

// 投稿日
$novel_info->addChild("postday",$postday);
$private_novel->addChild("postday",$postday);

// 更新日
$novel_info->addChild("updateday");
$private_novel->addChild("updateday");

/******************************/
/*         小説データ         */
/******************************/
// 作成日
$novel_info->addChild("createday",$createday);

// 後書き
$novel_info->addChild("afterword",$afterword);

// 本文
$novel_body = $novel_root->addChild("body");
foreach($pages as $p){
    $novel_body->addChild("page",$p);
}

/******************************/
/*         個人リスト         */
/******************************/
// ユーザーid
$private_novel->addChild("userid",$userid);

// 投稿id
$private_novel->addChild("postid",$postid);


/* ============================================== */
/*                      出力                      */
/* ============================================== */
/******************************/
/*         小説データ         */
/******************************/
$novel_dom = new DOMDocument('1.0');
$novel_dom->formatOutput = true;
$novel_dom->preserveWhiteSpace = false;
$novel_dom->loadXML($novel_root->asXML());
$novel_dom->save($novel_file);

/******************************/
/*         個人リスト         */
/******************************/
$private_dom = new DOMDocument('1.0');
$private_dom->formatOutput = true;
$private_dom->preserveWhiteSpace = false;
$private_dom->loadXML($private_root->asXML());
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
$public_list_file = "{$data_path}/novel_lists.xml";
$public_root = simplexml_load_file($public_list_file);
$public_novel = $public_root->addChild("novel");
// 匿名
$public_novel->addAttribute("anonymous",$anonymous);
// タイトル
$public_novel->addChild("title",$title);
// 表紙
$public_novel->addChild("img",$img);
// カテゴリー
$public_novel->addChild("category",$category);
// ハッシュタグ
$public_tags = $public_novel->addChild("tags");
if(!empty($taglist)){
    foreach($taglist as $tag){
        $public_tags->addChild("tag",$tag);
    }
}
// キャプション
$public_novel->addChild("caption",$caption);
// 文字数
$public_novel->addChild("length",$length);
// 読了時間
$public_novel->addChild("readtime",$readtime);
// 投稿日
$public_novel->addChild("postday",$postday);
// 更新日
$public_novel->addChild("updateday");
// ユーザーid
$public_novel->addChild("userid",$userid);
// 投稿id
$public_novel->addChild("postid",$postid);
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