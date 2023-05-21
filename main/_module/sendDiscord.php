<?php
header("Content-type: application/json; charset=utf-8");
/* ============================================================== */
/*                 自サイト以外からの受け入れ拒否                 */
/* ============================================================== */
// $referrer = $_SERVER["HTTP_REFERER"];
// $domain = parse_url($referrer);
// if (!stristr($domain["host"], "localhost-iott") && !stristr($domain["host"], "imaginarium-of-the-table.wew.jp")) {
//     $error_text = ["result" => "error"];
//     $text = "不正なアクセスを検知しました：" . $referrer;
//     $error_text = $error_text + array("error_text" => $text);
//     send_message_exit($error_text);
// }

$name = "星辰の冀求か、あるいは決裂か"; // $_POST[""];
$text = $_POST["msg"];

// 要望・不具合報告
//send_discord("星辰の冀求か、あるいは決裂か",$text);

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
$res = file_get_contents($webhook, false, stream_context_create($options));

$arr = ["res" => $res];

echo json_encode($arr);
exit;