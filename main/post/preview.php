<?php

// タイトル
$title = isset($_POST['title']) ? $_POST['title']: 'タイトルがありません';
include('../_module/head.php');

// ユーザー名
$userid = $_COOKIE['loginuserid'];
$member = parse_ini_file('../data/member.ini', true);
$user_name = $member[$userid]['name'];
if(isset($_POST['anonymous'])){
    $user_name = '匿名';
}

// 表紙
$novel_cover = isset($_POST['novel-cover']) ? $_POST['novel-cover'] :'notnovelcover.jpg';

// カテゴリー
$category = isset($_POST['category']) ? $_POST['category']:'none';

// ハッシュタグ
$taglist = [];
if(isset($_POST['hash-tag']) && !empty($_POST['hash-tag'])){
    $tmp = preg_split('/[\s|\x{3000}]+/u', $_POST['hash-tag']);
    foreach($tmp as $t){
        $taglist[] = $t;
    }
}

// キャプション
$caption = isset($_POST['caption']) ? nl2br($_POST['caption']) : '';

// ページ数
$pages = isset($_POST['pages']) ? $_POST['pages'] : 0;

// 文字数
$length = isset($_POST['length']) ? $_POST['length'] : 0;

// 読了時間
$readtime = '';
if ($length >= 600) {
    $min = round($length / 600);
    if ($min >= 60) {
        $hour = round($min / 60);
        $min = $min - ($hour * 60);
        $readtime = $hour . '時間';
    }
    $readtime .= $min . '分';
} else {
    $readtime = 1 . '分';
}

$novel_body = [];
for ($i = 1; $i < $pages + 1; $i++) {
    $novel_body[] = nl2br($_POST[$i]);
}

// 後書き
$afterword = isset($_POST['afterword']) ? nl2br($_POST['afterword']) : '';

// 投稿日
$datetime = new DateTime();
$postday = $datetime->format('Y/m/d G:i');

// 更新日
$updateday = '';

?>

<body id="NOVEL">
    <?php
    $is_preview = true;
    include_once('../_module/header.php');
    ?>

    <main>
        <article id="novel-header">
            <h2><span><?php echo $title; ?></span></h2>
            <div class="novel-caption">
                <div class="novel-cover">
                    <img src="../img/novel-cover/<?php echo $novel_cover; ?>">
                </div>
                <div class="caption">
                    <div class="user"><a><?php echo $user_name; ?></a></div>
                    <?php
                    if (!empty($taglist)) {
                        echo '<ul class="hashtag">';
                        foreach ($taglist as $tag) {
                            echo '<li><a>' . $tag . '</a></li>';
                        }
                        echo '</ul>';
                    }
                     ?>
                    <p><?php echo $caption; ?></p>
                    <div class="post-data">
                        <span class="length"><?php echo $length; ?>文字</span>
                        <span class="readtime"><?php echo $readtime; ?></span>
                        <span class="post-day"><?php echo $postday; ?></span>
                        <span class="update-day"><?php echo $updateday; ?></span>
                    </div>
                </div>
            </div>
        </article>

        <article id="novel-body">
            <?php
            for ($i = 0; $i < $pages; $i++) {
                if (!empty($novel_body[$i])) {
                    if ($i === 0) {
                        echo '<div id = "' . (string)($i+1) . '" class = "current">';
                    } else {
                        echo '<div id = "' . (string)($i+1) . '">';
                    }
                    echo '<p>' . $novel_body[$i] . '</p></div>';
                }
            }
            ?>
        </article>

        <article id="novel-footer">
            <section class="page-tab">
                <nav>
                    <button type="button" class="prev"></button>
                    <?php
                    if ($pages > 1) {
                        for ($i = 1; $i < $pages + 1; $i++) {
                            if ($i === 1) {
                                echo '<button type="button" class="current">1</button>';
                            } else {
                                echo '<button type="button"">' . $i . '</button>';
                            }
                        }
                    }
                    ?>
                    <button type="button" class="next"></button>
                </nav>
            </section>
            <section class="afterword">
                <div class="caption">
                    <h4><?php echo $title; ?></h4>
                    <div class="user"><a><?php echo $user_name; ?></a></div>
                    <?php
                    if (!empty($taglist)) {
                        echo '<ul class="hashtag">';
                        foreach ($taglist as $tag) {
                            echo '<li><a>' . $tag . '</a></li>';
                        }
                        echo '</ul>';
                    }
                    ?>
                    <p><?php echo $afterword;?></p>
                    <div class="post-data">
                        <span class="length"><?php echo $length; ?>文字</span>
                        <span class="readtime"><?php echo $readtime; ?></span>
                        <span class="post-day"><?php echo $postday; ?></span>
                        <span class="update-day"><?php echo $updateday; ?></span>
                    </div>
                </div>
            </section>
        </article>
    </main>

    <?php include_once('../_module/footer.php'); ?>

</body>

</html>