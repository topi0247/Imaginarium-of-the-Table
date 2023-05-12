<?php 
$title = 'top';
include('_module/head.php');

$member = parse_ini_file('data/member.ini', true);
?>
<body>
    <?php
    $is_top = true;
    include('_module/header.php');
    ?>
    <main>
        <article>
            <h2><span>infomation</span></h2>
            <section>
                <div class="border">
                    <dl class="inline">
                        <dt>2023/05/12</dt>
                        <dd>アップデート！詳細は<a href="log">こちら</a>　開発状況は<a href="develop">こちら</a></dd>

                        <dt>2023/05/06</dt>
                        <dd>β版公開　開発状況は<a href="develop">こちら</a></dd>
                    </dl>
                </div>
                <span class="block right"><a class="log" href="log">log</a></span>
            </section>
        </article>

        <!--<article>
            <h2><span>セッション情報</span></h2>
            <ul style="list-style: none; padding : 0;">
                <?php
                $data_path = 'session/';
                //include('_module/toc.php');
                ?>
            </ul>
        </article>-->

        <article>
            <h2><span>小説</span></h2>
            <section>
                <?php include_once('novel/toc.php');?>
                <a href="novel/index" class="btn block">もっと見る</a>
            </section>
        </article>

        <!--<article>
            <h2><span>イラスト</span></h2>
            <ul style="list-style: none; padding : 0;">
                <?php
                $data_path = 'illust/';
                //include('_module/toc.php');
                ?>
            </ul>
        </article>-->

        <hr>

        <article id="ABOUT">
            <h2><span>about</span></h2>
            <section>
                <h3><span>about this site</span></h3>
                <div>
                    <p>TRPG部活動記録と創作投稿サイト<br>
                    メインはCoC、時々マダミス、たまに違うシステムも</p>
                    <dl class="inline">
                        <dt>site name</dt>
                        <dd>Imaginarium of the Table</dd>

                        <dt>url</dt>
                        <dd>https://imaginarium-of-the-table.wew.jp</dd>
                    </dl>
                </div>
            </section>
        </article>
        <article>
            <h2><span>Thanks!</span></h2>
            <dl class="inline">
                <dt>魔法陣</dt>
                <dd><a href="https://ayaemo.skr.jp/" target="_blank">あやえも研究所</a>様</dd>

                <dt>小説表紙 イラスト</dt>
                <dd><a href="https://www.pixiv.net/users/12836474" target="_blank">きみヱ</a>様</dd>

                <dt>小説表紙 写真</dt>
                <dd><a href="https://unsplash.com/" target="_blank">Unsplash</a></dd>
            </dl>
        </article>
    </main>

    <?php include_once('_module/footer.php'); ?>
    
</body>
</html>