<?php 
$title = 'illust top | Imaginarium of the Table';
$meta_title = 'illust top';
$dir = '../';
include($dir . 'module/head.php');
?>
<body>
    <?php 
    $header_about = false;
    $header_top = true;
    $header_session = true;
    $header_novel = true;
    $header_illust = false;
    $header_post = true;
    $header_setting = true;
    include($dir . 'module/header.php');
    ?>

    <main class="passcheck">
        <article>
            <section>
                <p>サムネイルデザインはできてるけど実装はまだです。<br>
                現在はとりあえず投稿された作品だけを列挙してます。</p>
            </section>
            <section>
                <h3><span>イラスト</span></h3>
                <ul style="list-style: none; padding : 0;">
                <?php
                //$toc_illust = true;
                $data_path = './';
                include($dir .'module/toc.php');
                ?>
                </ul>
            </section>
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
                <a href="../index.php">indexへ</a>
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
    <script src="../js/3rd/sha256.js"></script>
    <!-- script -->
    <script src="../js/script.js"></script>
</body>
</html>