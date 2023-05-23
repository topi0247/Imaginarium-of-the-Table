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
    send_discord("異世界から終端をもたらすか",$text);
    send_error($error_text);
}


/* ==================================== */
/*                 関数                 */
/* ==================================== */
// 成功
function send_success($text)
{
    $array = ["status" => $text];
    echo json_encode($array);
    exit;
}

// エラー
function send_error($text){
    $array = ["status" => "error"];
    $array += ["error_text" => $text];
    echo json_encode($array);
    exit;
}

// オーバーフロー
function int_overflow($v)
{
    return is_nan($v) || ($v === INF) || ($v === -INF) || (bccomp(PHP_INT_MAX, $v) === -1);
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

/* ========================================== */
/*                 グローバル                 */
/* ========================================== */
$userid = $_COOKIE["loginuserid"];

/* ============================================== */
/*                 パスワード変更                 */
/* ============================================== */
if(isset($_POST["pswd"])){
    $pass = $_POST["pswd"];
    $passhash = hash("sha256", $pass);
    // 2038年問題対策
    if (int_overflow(time())) {
        setcookie("loginpass", $pass);
        setcookie("loginhash", $passhash);
    }else {
        // 1ヶ月保存
        $time = time() + (60 * 60 * 24 * 30);
        setcookie("loginpass", $pass,$time,"/");
        setcookie("loginhash", $passhash,$time,"/");
    }
    setcookie("loginpass", $pass);
    setcookie("loginhash", $passhash);
    $config = parse_ini_file("../../data/config.cgi");
    $config[$userid] = $passhash;
    $fp = fopen("../../data/config.cgi", "w");
    foreach ($config as $k => $i) fputs($fp, "$k=$i\n");
    fclose($fp);
    send_success("success");
}


/* ========================================== */
/*                 データ取得                 */
/* ========================================== */
// 作品タイプ
$type = $_POST["type"];
// 作品をどうするか
$mod = $_POST["mod"];
// 投稿id
$postid = $_POST["postid"];
// ユーザーid
$userid = $_COOKIE["loginuserid"] === "develop" ? "0000" : $_COOKIE["loginuserid"];


/* ========================================== */
/*                 リスト操作                 */
/* ========================================== */
$public_list_file = "../../data/{$type}_lists.xml";
if (!file_exists($public_list_file)){
    $text = "{$public_list_file}が存在しません";
    send_discord("空想世界で揃う星辰",$text);
    send_error($text);
}
$public_lists_root = simplexml_load_file($public_list_file);
if($type === "novel") $public_data = $public_lists_root->novel;
//else if($type === "illust") $public_data = $public_lists_root->illust;

// 非公開or削除なら公開リストから削除
if($mod === "private" || $mod === "delete"){
    $index = 0;
    foreach($public_data as $data){
        if($userid === (string)$data->userid && $postid === (string)$data->postid) break;
        $index++;
    }
    unset($public_data[$index]);
}

// 公開or削除なら個人リストを取得
if($mod === "public" || $mod === "delete"){
    $private_list_file = "../../data/{$userid}/{$type}/lists.xml";
    if (!file_exists($private_list_file)){
        $text = "{$private_list_file}が存在しません";
        send_discord("空想世界で揃う星辰",$text);
        send_error($text);
    }

    $private_lists_root = simplexml_load_file($private_list_file);
    if($type === "novel") $private_data = $private_lists_root->novel;
    //else if($type === "illust") $private_data = $private_lists_root->illust;
    
    $index = 0;
    foreach ($private_data as $data) {
        if ($postid === (string)$data->postid) break;
        $index++;
    }

    // 公開なら個人リストから挿入
    if($mod === "public"){
        $addData = $private_data[$index];

        if($type === "novel"){
            $node = $public_lists_root->addChild("novel");
            $node["anonymous"] = $addData["anonymous"];
            $node->addChild("title", $addData->title);
            $node->addChild("img", $addData->img);
            $node->addChild("category", $addData->category);
            $tags = $node->addChild("tags");
            if (!empty($addData->$tags)) {
                foreach ($addData->$tags as $tag) {
                    $tags->addChild("tag", $tag);
                }
            }
            $node->addChild("caption", $addData->caption);
            $node->addChild("length", $addData->length);
            $node->addChild("readtime", $addData->readtime);
            $node->addChild("postday", $addData->postday);
            $node->addChild("updateday", $addData->updateday);
            $node->addChild("userid", $userid);
            $node->addChild("postid", $postid);
        }
    }

    // 削除なら個人リストから削除
    if($mod === "delete"){
        unset($private_data[$index]);
    }
}

// 公開リストを上書き保存
$public_dom = new DOMDocument("1.0");
$public_dom->formatOutput = true;
$public_dom->preserveWhiteSpace = false;
$public_dom->loadXML($public_lists_root->asXML());
$public_dom->save($public_list_file);

// 公開・非公開ならここで終わり
if($mod === "private" || $mod === "public") send_success($mod);

// 削除処理 - 非公開リスト上書き保存
$private_dom = new DOMDocument("1.0");
$private_dom->formatOutput = true;
$private_dom->preserveWhiteSpace = false;
$private_dom->loadXML($private_lists_root->asXML());
$private_dom->save($private_list_file);

// 削除-ファイル削除
$file = "../../data/{$userid}/{$type}/{$postid}.xml";
$result = unlink($file);
if ($result) {
    send_success($mod);
} else {
    $text = "{$file}の削除に失敗しました";
    send_discord("空想世界で揃う星辰",$text);
    send_error($text);
}
