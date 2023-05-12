<?php

// ユーザーID取得
if (isset($_GET['userid'])) {
    $userid = $_GET['userid'];
}

// 投稿番号取得
if (isset($_GET['postid'])) {
    $postid = $_GET['postid'];
}

$novel_path = '../data/' . $userid . '/novel/' . $postid . '.xml';
$xml = simplexml_load_file($novel_path);

$novel_info = $xml->info;
$novel_body = $xml->body;
$title = (string)$novel_info->title;
$is_novel = true;
include('../_module/head.php');

$member = parse_ini_file('../data/member.ini', true);
$user = $xml['anonymous'] == 'false' ? $member[(string)$userid]['name'] : '匿名';
$tags = [];
if ($novel_info->tags->children('tag') > 0) {
    foreach ($novel_info->tags as $t) {
        $tags[] = (string)$t->tag;
    }
}
$page_count = count($novel_body->page);

function showTags(){
    if (!empty($tags)) {
        echo '<ul class="hashtag">';
        foreach ($tags as $tag) {
            echo '<li><a>' . $tag . '</a></li>';
        }
        echo '</ul>';
    }
}
?>

<body id="NOVEL">
    <?php
    $is_novel = true;
    include_once('../_module/header.php');
    ?>

    <main>
        <article id="novel-header">
            <h2><span><?php echo $title; ?></span></h2>
            <div class="novel-caption">
                <div class="novel-cover">
                    <img src="../img/novel-cover/<?php echo (string)$novel_info->img; ?>">
                </div>
                <div class="caption">
                    <div class="user"><a><?php echo $user; ?></a></div>
                    <?php showTags();?>
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
            <?php
            $result = '';
            for ($i = 0; $i < $page_count; $i++) {
                $c = $i + 1;
                if ($c === 1) {
                    $result .= '<div id = "' . $c . '" class = "current "';
                } else {
                    $result .= '<div id = "' . $c . '">';
                }
                $result .= '<p>'.(string)$novel_body->page[$i] . '</p></div>';
            }
            echo $result;
            ?>
        </article>

        <article id="novel-footer">
            <section class="page-tab">
                <nav>
                    <button type="button" class="prev"></button>
                    <?php
                    for ($i = 0; $i < $page_count; $i++) {
                        $c = $i + 1;
                        if ($c === 1) {
                            echo '<button type="button" class="current">1</button>';
                        } else {
                            echo '<button type="button"">' . $c . '</button>';
                        }
                    }
                    ?>
                    <button type="button" class="next"></button>
                </nav>
            </section>
            <section class="afterword">
                <div class="caption">
                    <h4><?php echo $title; ?></h4>
                    <div class="user"><a><?php echo $user; ?></a></div>
                    <?php showTags();?>
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

    <?php include_once('../_module/footer.php'); ?>
</body>

</html>