<?php
$current = $_SERVER["PHP_SELF"];
$search = "/\/(.*?)\//";
$dir = preg_replace($search, "/../", $current);
$dir =  substr_replace($dir, "./", 0, 1);
$start = mb_strrpos($dir, "/") + 1;
$dir =  substr_replace($dir, "", $start);

// ログインチェック
if(!isset($is_index)){
  if(!isset($_COOKIE["loginuserid"])){
    header("Location:{$dir}");
    exit;
  }
}

if (isset($_COOKIE["loginuserid"])) {
  // 開発モード
  $develop_mode = $_COOKIE["loginuserid"] === "develop" ? true : false;

  // ゲストモード 
  $guest_mode = isset($_COOKIE["loginuserid"]) ? $_COOKIE["loginuserid"] === "guest" : false;
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="robots" content="noindex,noarchive,noimageindex">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Cache-Control" content="no-cache">
    <meta name="title" content="<?php echo $title; ?>">
    <title><?php echo isset($is_index) ? $title : "{$title} | Imaginarium of the Table"; ?></title>
    <!-- css -->
    <link rel="stylesheet" href="/css/style.css" type="text/css" id="style">
    <?php echo isset($is_index_post) || isset($is_edit) ? "<link rel='stylesheet' href='/css/post.css' type='text/css' id='style'>" : "" ;?>
    <?php echo isset($is_setting) ? "<link rel='stylesheet' href='/css/usersetting.css' type='text/css' id='style'>" : "";?>
    <?php echo isset($is_edit) ? "<link rel='stylesheet' href='/css/edit.css' type='text/css' id='style'>" : "";?>
    <!-- font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@500&family=Klee+One:wght@400;600&family=Shippori+Mincho:wght@400;700&family=Zen+Kaku+Gothic+New:wght@400;700&family=Zen+Old+Mincho:wght@400;700&display=swap" rel="stylesheet">
    <!-- icon -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- fabicon -->
    <link rel="apple-touch-icon" type="image/png" href="/img/icon.png">
    <link rel="icon" type="image/png" href="/img/icon.png">
    <!-- darkmode -->
    <script src="/js/darkmode.js"></script>
</head>
