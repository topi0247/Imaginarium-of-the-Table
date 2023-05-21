<?php
// ユーザー名
$userid = $_COOKIE["loginuserid"] !== "develop" ? $_COOKIE["loginuserid"] : "0000";
$member = parse_ini_file("../data/member.cgi", true);
$user_name = isset($_POST["anonymous"]) ? "匿名" : $member[$userid]["name"];

// タイトル
$novel_title = empty($_POST["title"]) ? "no title" : $_POST["title"];

// 表紙
$novel_cover_dir = isset($_POST["novel-cover"]) ? "../img/novel-cover/" : "../img/";
$novel_cover = $_POST["novel-cover"] ?? "notnovelcover.jpg";

// カテゴリー
$category = $_POST["category"] ?? "none";

// ハッシュタグ
$taglist = [];
if(isset($_POST["hash-tag"]) && !empty($_POST["hash-tag"])){
    $tmp = preg_split("/[\s|\x{3000}]+/u", $_POST["hash-tag"]);
    foreach($tmp as $t){
        $taglist[] = $t;
    }
}

// キャプション
$caption = isset($_POST["caption"]) ? str_replace(array("\r\n", "\r", "\n"), "<br>", $_POST["caption"]) : "";

// ページ数
$pages = $_POST["pages"] ?? 0;

// 文字数
$length = $_POST["length"] ?? 0;

// 読了時間
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

$novel_body = [];
for ($i = 1; $i < $pages + 1; $i++) {
    $novel_body[] = str_replace(array("\r\n", "\r", "\n"), "<br>", $_POST[$i]);
}

// 後書き
$afterword = isset($_POST["afterword"]) ? str_replace(array("\r\n", "\r", "\n"), "<br>", $_POST["afterword"]) : "";

// 投稿日
if(isset($_POST["postday"])){
    $postday = $_POST["postday"];
}
else{
    $datetime = new DateTime();
    $datetime->setTimeZone(new DateTimeZone("Asia/Tokyo"));
    $postday = $datetime->format("Y/m/d G:i");
}

// 更新日
if(isset($_POST["updateday"])){
    $datetime = new DateTime();
    $datetime->setTimeZone(new DateTimeZone("Asia/Tokyo"));
    $updateday = $datetime->format("Y/m/d G:i");
}

// タイトル
$title = "preview";
$is_preview = true;
include_once("../parts/head.php");

?>

<body id="NOVEL">
    <?php include_once("../parts/header.php"); ?>
    <main>
        <article id="novel-header">
            <h2><span><?php echo $novel_title; ?></span></h2>
            <div class="novel-caption">
                <div class="novel-cover">
                    <img src="<?php echo $novel_cover_dir.$novel_cover; ?>">
                </div>
                <div class="caption">
                    <div class="user"><a><?php echo $user_name; ?></a></div>
                    <?php
                    if (!empty($taglist)) { ?>
                    <ul class="hashtag">
                        <?php foreach ($taglist as $tag) { ?>
                            <li><a><?php echo $tag; ?></a></li>
                        <?php } ?>
                    </ul>
                    <?php } ?>
                    <p><?php echo $caption; ?></p>
                    <div class="post-data">
                        <span class="length"><?php echo $length; ?>文字</span>
                        <span class="readtime"><?php echo $readtime; ?></span>
                        <span class="post-day"><?php echo $postday; ?></span>
                        <span class="update-day"><?php echo $updateday ?? "" ; ?></span>
                    </div>
                </div>
            </div>
        </article>

        <article id="novel-body">
            <?php
            for ($i = 0; $i < $pages; $i++) {
                if (!empty($novel_body[$i])) {?>
                    <div id = "<?php echo $i+1; ?>" class =<?php echo $i === 0 ? "current":"";?>>
                    <p><?php echo $novel_body[$i]; ?></p></div>
                <?php } // if(!empty
            } // for ?>
        </article>

        <article id="novel-footer">
            <section class="page-tab">
                <nav>
                    <button type="button" class="prev"></button>
                    <?php
                    if ($pages > 1) {
                        for ($i = 0; $i < $pages; $i++) { ?>
                        <button type="button" class=<?php echo $i === 0 ? "current":""; ?>><?php echo $i+1;?></button>
                        <?php } 
                    } ?>
                    <button type="button" class="next"></button>
                </nav>
            </section>
            <section class="afterword">
                <div class="caption">
                    <h4><?php echo $novel_title; ?></h4>
                    <div class="user"><a><?php echo $user_name; ?></a></div>
                    <?php
                    if (!empty($taglist)) { ?>
                        <ul class="hashtag">
                            <?php foreach ($taglist as $tag) { ?>
                                <li><a><?php echo $tag; ?></a></li>
                            <?php } // foreach ?>
                        </ul>
                    <?php } // if(!empty ?>
                    <p><?php echo $afterword;?></p>
                    <div class="post-data">
                        <span class="length"><?php echo $length; ?>文字</span>
                        <span class="readtime"><?php echo $readtime; ?></span>
                        <span class="post-day"><?php echo $postday; ?></span>
                        <span class="update-day"><?php echo $updateday ?? "" ; ?></span>
                    </div>
                </div>
            </section>
        </article>
    </main>

    <?php include_once("../parts/footer.php"); ?>
    <script src="/js/novel.js"></script>
</body>

</html>