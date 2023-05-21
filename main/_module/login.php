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

if(isset($_POST["logout"])){
    logout();
    exit;
}

if(isset($_POST["login"])){
    //logout();
    $userid = $_POST["user"];
    $pass = $_POST["pass"];
    $passhash = hash("sha256", $pass);
    $config = parse_ini_file("../data/config.cgi");
    $success = false;
    if (array_key_exists($userid, $config)) {
        if($config[$userid] === $passhash){
            // 2038年問題対策
            if (int_overflow(time())) {
                setcookie("loginuserid", $userid);
                setcookie("loginpass", $pass);
                setcookie("loginhash", $passhash);
            } else {
                // 1ヶ月保存
                $time = time() + (60 * 60 * 24 * 30);
                setcookie("loginuserid", $userid, $time, "/");
                setcookie("loginpass",  $pass, $time, "/");
                setcookie("loginhash", $passhash, $time, "/");
            }
            $success = true;
        }else if($config["guest"]  === $passhash){
            // ゲストモード
            setcookie("loginuserid", "guest");
            $success = true;
        }
    }

    if($success){
        $array = ["result" => "success"];
        $array += ["next" => "top"];
        send_message_exit($array);
    } else {
        $array = ["result" => "fail"];
        send_message_exit($array);
    }
}

function logout(){
    setcookie("loginuserid", "", time() - 3600, "/");
    unset($_COOKIE["loginuserid"]);
    setcookie("loginpass", "", time() - 3600, "/");
    unset($_COOKIE["loginpass"]);
    setcookie("loginhash", "", time() - 3600, "/");
    unset($_COOKIE["loginhash"]);
}

function send_message_exit($array = null){
    if(!is_null($array)) echo json_encode($array);
    exit;
}

function int_overflow($v)
{
    return is_nan($v) || ($v === INF) || ($v === -INF) || (bccomp(PHP_INT_MAX, $v) === -1);
}