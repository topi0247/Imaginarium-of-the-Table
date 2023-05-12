<?php
$title = '投稿';
$is_index_post = true;
include('../_module/head.php');

$member = parse_ini_file('../data/member.ini', true);
$userid = $_COOKIE['loginuserid'];
$username = $member[$userid]['name'];
include_once('../_module/script.php');
?>

<body id="POST">
    <?php include('../_module/header.php'); ?>

    <main>
        <article>
            <h2><span>投稿画面</span></h2>
            <?php
            if($guest_mode){
                exit('ゲストユーザーは投稿できません');
                echo '</article>
                </main>';
                include_once('../_module/footer.php');
            }
            ?>

            <div id="postResult">
            </div>

            <section id="post-type">
                <h4>投稿種類</h4>
                <label>セッション<input type="radio" value="type-session" name="type"></label>
                <label>小説<input type="radio" value="type-novel" name="type" checked></label>
                <label>イラスト<input type="radio" value="type-illust" name="type"></label>
                <p>ページ下部にある目のアイコンを押すとプレビューが見れます</p>
            </section>

            <section id="post-session">
                <h4>セッション</h4>
                <form id="form-session" name="form-session" method="post" action="_module/post-session">
                    <?php include('parts/form-session.php'); ?>
                </form>
            </section>

            <section id="post-novel">
                <h4>小説</h4>
                <form id="form-novel" name="form-novel" method="post" action="_module/post-novel" disabled>
                    <?php include('parts/form-novel.php'); ?>
                </form>
            </section>

            <section id="post-illust">
                <h4>イラスト</h4>
                <form id="form-illust" name="form-illust" method="post" action="_module/post-illust">
                    <?php include('parts/form-illust.php'); ?>
                </form>
            </section>
        </article>
    </main>

    <?php include_once('../_module/footer.php') ?>

</body>

</html>