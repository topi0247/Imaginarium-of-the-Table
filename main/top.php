<?php 
$title = "top";
$is_top = true;
include_once("parts/head.php");
?>
<body>
    <?php include_once("parts/header.php"); ?>
    <main>
        <article>
            <h2><span>infomation</span></h2>
            <section>
                <div class="border">
                    <dl class="inline">
                        <dt>2023/05/23</dt>
                        <dd>小説投稿にて装飾ツール（ルビ・文字大・文字小・文字中央・文字右端）を追加しました。<br>
                        投稿済みの小説を編集できるようになりました。</dd>

                        <dt>2023/05/21</dt>
                        <dd>小説投稿の不具合を修正しました。<br>要望・不具合報告のフォームを用意しました。</dd>

                        <dt>2023/05/12</dt>
                        <dd>アップデート！詳細は<a href="log">こちら</a>　開発状況は<a href="develop">こちら</a></dd>
                    </dl>
                </div>
                <span class="block right"><a class="log" href="log">log</a></span>
            </section>

            <h2><span>要望 <br class="br-sp">不具合報告</span></h2>
            <div id="requestResult"></div>
            <section id="request">
                <p>現在開発中につき挙動が不安定です。<br>
                なんか動きへん！変な文字が表示される！ということがありましたら下記からメッセージ送ってください！<br>
                あるいは、「こういうふうにして欲しい！」「こういう機能が欲しい！」などありましたら検討しますので送ってくだされ
                </p>
                <dl class="inline">
                    <dt>ユーザー名（任意）</dt>
                    <dd><input type="text" placeholder="ユーザー名" id="username"></dd>

                    <dt>環境（任意）</dt>
                    <dd>PC、スマホ　/　Chrome、Firefoxなど　詳しいほどありがたい
                        <input type="text" id="environment"></dd>
                    
                    <dt class="required">内容</dt>
                    <dd><textarea id="content"></textarea></dd>
                </dl>
                <button type="button" id="send_discord" class="block" disabled>送信</button>
            </section>
        </article>

        <!--<article>
            <h2><span>セッション情報</span></h2>
            <ul style="list-style: none; padding : 0;">
                <?php //include_once("session/toc.php"); ?>
            </ul>
        </article>-->

        <article>
            <h2><span>小説</span></h2>
            <section>
                <?php include_once("novel/toc.php"); ?>
                <a href="novel" class="btn block">もっと見る</a>
            </section>
        </article>

        <!--<article>
            <h2><span>イラスト</span></h2>
            <ul style="list-style: none; padding : 0;">
                <?php //include_once("illust/toc.php"); ?>
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

    <?php include_once('parts/footer.php'); ?>
    
</body>
</html>