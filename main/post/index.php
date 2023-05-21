<?php
$title = "投稿";
$is_index_post = true;
include("../parts/head.php");

$member = parse_ini_file("../data/member.cgi", true);
$userid = $_COOKIE["loginuserid"];
$username = $member[$userid]["name"];
include_once("../parts/script.php");
?>

<body id="POST">
    <?php include("../parts/header.php"); ?>

    <main>
        <article>
            <h2><span>投稿画面</span></h2>
            <?php
            if($guest_mode){
                exit("ゲストユーザーは投稿できません"); ?>
        </article>
    </main>
    
    <?php include_once("../parts/footer.php"); } // if($guest_mode ?>

            <div id="postResult"></div>

            <section id="post-type">
                <h4>投稿種類</h4>
                <!-- <label>セッション<input type="radio" value="type-session" name="type"></label> -->
                <label>小説<input type="radio" value="type-novel" name="type" checked></label>
                <!-- <label>イラスト<input type="radio" value="type-illust" name="type"></label> -->
                <p>ページ下部にある目のアイコンを押すとプレビューが見れます</p>
                <p>開発中につき<em>投稿データの担保ができません</em>。<br>
                あらかじめ手元に保存しておくことを強くおすすめします。
                </p>
            </section>

            <!-- <section id="post-session">
                <h4>セッション</h4>
                <form id="form-session">
                    <?php //include("parts/form-session.php"); ?>
                </form>
            </section> -->

            <section id="post-novel">
                <h4>小説</h4>
                <form id="form-novel">
                    <?php include("parts/form-novel.php"); ?>
                </form>
            </section>

            <!-- <section id="post-illust">
                <h4>イラスト</h4>
                <form id="form-illust">
                    <?php //include("parts/form-illust.php"); ?>
                </form>
            </section> -->
        </article>
    </main>

    <?php include_once("../parts/footer.php") ?>
    <script src="/js/post.js"></script>
</body>

</html>