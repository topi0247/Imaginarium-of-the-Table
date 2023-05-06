<?php
$title = 'top | Imaginarium of the Table';
$meta_title = 'top';
$dir = './';
include($dir . 'module/head.php');
?>

<body>
    <?php 
    $header_about = true;
    $header_top=false;
    $header_session = true;
    $header_novel = true;
    $header_illust = true;
    $header_post = true;
    $header_setting = true;
    include($dir . 'module/header.php');
    ?>

    <main class="passcheck">
        <article>
            <h2><span>infomation</span></h2>
            <section>
                <div class="border">
                    <dl class="inline">
                        <dt>2023/05/06</dt>
                        <dd>β版公開　開発状況は<a href="develop.php">こちら</a></dd>
                    </dl>
                </div>
                <span class="block right"><a class="log" href="log.php">log</a></span>
            </section>
        </article>

        <article>
            <h2><span>セッション情報</span></h2>
            <ul style="list-style: none; padding : 0;">
                <?php
                // $toc_novel = false;
                // $toc_illust = false;
                // $toc_session = true;
                $data_path = 'session/';
                include('module/toc.php');
                ?>
            </ul>
        </article>

        <article>
            <h2><span>小説</span></h2>
            <ul style="list-style: none; padding : 0;">
                <?php
                // $toc_illust = false;
                // $toc_session = false;
                // $toc_novel = true;
                $data_path = 'novel/';
                include('module/toc.php');
                ?>
            </ul>
        </article>

        <article>
            <h2><span>イラスト</span></h2>
            <ul style="list-style: none; padding : 0;">
                <?php
                // $toc_illust = true;
                // $toc_session = false;
                // $toc_novel = false;
                $data_path = 'illust/';
                include('module/toc.php');
                ?>
            </ul>
        </article>

        <article id="ABOUT">
            <h2><span>about</span></h2>
            <section>
                <h3><span>about this site</span></h3>
                <div>
                    <p>TRPG部活動記録と創作投稿サイト<br>
                    メインはCoC、時々マダミス、たまにシステムも</p>
                    <dl class="inline">
                        <dt>site name</dt>
                        <dd>Imaginarium of the Table</dd>

                        <dt>administer</dt>
                        <dd>あるす</dd>

                        <dt>url</dt>
                        <dd>https://imaginarium-of-the-table.wew.jp</dd>
                    </dl>
                </div>
            </section>
        </article>

        <article>
            <h2><span>Thanks!</span></h2>
            <a href="https://ayaemo.skr.jp/" target="_blank">あやえも研究所</a>
        </article>
    </main>

    <article class="overlay">
        <div class="popup-window">
            <h3><span>Login</span></h3>
            <div class="center">
                <div id="loginResult"></div>
                <form>
                    <input type="text" placeholder="password" id="loginPass">
                    <input type="button" value="send" id="login">
                </form>
                <a href="index.php">indexへ</a>
            </div>
        </div>
    </article>

    <footer class="passcheck">
        <p class="small">© 2023 Imaginarium of the Table - by TRPG部</p>
        <nav id="pageBottonNav" class="fixed-menu">
            <ul>
                <li id="pageTop" class="pagetop"><button></button></li>
                <li id="changeMode" class="mode"><button></button></li>
            </ul>
        </nav>
    </footer>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    <!-- 3rd -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.js"></script>
    <script src="js/3rd/sha256.js"></script>
    <!-- script -->
    <script src="js/script.js"></script>
</body>

</html>