<?php

// ユーザーID取得
if (isset($_GET["userid"])) {
    $userid = $_GET["userid"];
}

// 投稿番号取得
if (isset($_GET["postid"])) {
    $postid = $_GET["postid"];
}

$novel_path = "../data/{$userid}/novel/{$postid}.xml";
$xml = simplexml_load_file($novel_path);

$novel_info = $xml->info;
$novel_body = $xml->body;
$title = $novel_info->title;
$is_novel = true;
include("../parts/head.php");

$member = parse_ini_file("../data/member.cgi", true);
$user = (string)$xml["anonymous"] === "false" ? $member[$userid]["name"] : "匿名";
foreach ($novel_info->tags->tag as $t) {
    $tags[] = (string)$t;
}
$page_count = count($novel_body->page);
$caption = $novel_info->caption;
$caption = str_replace("&#13;","<br>",$caption);
?>

<body id="NOVEL">
    <?php include_once("../parts/header.php"); ?>

    <main>
        <article id="novel-header">
            <h2><span><?php echo $title; ?></span></h2>
            <div class="novel-caption">
                <div class="novel-cover">
                    <img src="../img/novel-cover/<?php echo (string)$novel_info->img; ?>">
                </div>
                <div class="caption">
                    <div class="user"><a><?php echo $user; ?></a></div>
                    <?php if (!empty($tags)) {?>
                    <ul class="hashtag">
                        <?php foreach ($tags as $tag) {?>
                            <li><a><?php echo $tag; ?></a></li>
                        <?php } // foreach ?>
                    </ul>
                    <?php } // if (!empty($tags)) ?>
                    <p><?php echo (string)$novel_info->caption; ?></p>
                    <div class="post-data">
                        <span class="length"><?php echo $novel_info->length; ?>文字</span>
                        <span class="readtime"><?php echo (string)$novel_info->readtime; ?></span>
                        <span class="post-day"><?php echo $novel_info->postday; ?></span>
                        <span class="update-day"><?php echo $novel_info->updateday; ?></span>
                    </div>
                </div>
            </div>
        </article>

        <article id="novel-body">
            <?php for ($i = 0; $i < $page_count; $i++) { 
                $page = $novel_body->page[$i] ;?>
                <div id="<?php echo $i + 1; ?>" class="<?php echo $i!==0 ? "" : "current"?>">
                    <p><?php echo $page; ?></p>
                </div>
            <?php } ?>
        </article>

        <article id="novel-footer">
            <section class="page-tab">
                <nav>
                    <button type="button" class="prev"></button>
                    <?php
                    for ($i = 0; $i < $page_count; $i++) { ?>
                        <button type="button" class="<?php echo $i!==0 ? "": "current"?>"><?php echo $i+1; ?></button>
                    <?php } // for ?>
                    <button type="button" class="next"></button>
                </nav>
            </section>
            <section class="afterword">
                <div class="caption">
                    <h4><?php echo $title; ?></h4>
                    <div class="user"><a><?php echo $user; ?></a></div>
                    <?php if (!empty($tags)) {?>
                    <ul class="hashtag">
                        <?php foreach ($tags as $tag) {?>
                            <li><a><?php echo $tag; ?></a></li>
                        <?php } // foreach ?>
                    </ul>
                    <?php } // if (!empty($tags)) ?>
                    <p><?php echo (string)$novel_info->afterword; ?></p>
                    <div class="post-data">
                        <span class="length"><?php echo $novel_info->length; ?>文字</span>
                        <span class="readtime"><?php echo (string)$novel_info->readtime; ?></span>
                        <span class="post-day"><?php echo $novel_info->postday; ?></span>
                        <span class="update-day"><?php echo $novel_info->updateday; ?></span>
                    </div>
                </div>
            </section>
        </article>
    </main>

    <?php include_once("../parts/footer.php"); ?>
    <script src="/js/novel.js"></script>
</body>

</html>