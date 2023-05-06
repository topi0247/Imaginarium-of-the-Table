<!DOCTYPE html>
<html lang="ja">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Cache-Control" content="no-cache">
    <meta name="robots" content="noindex,noarchive,noimageindex">
    <meta name="title" content="投稿画面">
    <title>投稿画面 | Imaginarium of the Table</title>
    <!-- css -->
    <link rel="stylesheet" href="../css/style.css" type="text/css" id="style">
    <link rel="stylesheet" href="../css/post.css" type="text/css" id="style">
    <!-- font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@500&family=Klee+One:wght@400;600&family=Shippori+Mincho:wght@400;700&family=Zen+Kaku+Gothic+New:wght@400;700&family=Zen+Old+Mincho:wght@400;700&display=swap" rel="stylesheet">
    <!-- icon -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
    <!-- fabicon -->
    <link rel="apple-touch-icon" type="image/png" href="../img/icon.png">
    <link rel="icon" type="image/png" href="../img/icon.png">
    <!-- darkmode -->
    <script src="../js/darkmode.js"></script>
</head>
<body id="POST">
    <?php 
    $header_about = false;
    $header_top = true;
    $header_session = true;
    $header_novel = true;
    $header_illust = true;
    $header_post = false;
    $header_setting = true;
    $dir = '../';
    include($dir . 'module/header.php');
    ?>

    <main class="passcheck">
        <article>
            <h2><span>投稿画面</span></h2>
            <div id="postResult">
            </div>

            <section id="post-type">
                <h4>投稿設定</h4>
                <label>セッション<input type="radio" id="type-session" name="type"></label>
                <label>小説<input type="radio" id="type-novel" name="type" checked></label>
                <label>イラスト<input type="radio" id="type-illust" name="type"></label>
            </section>

            <section id="post-session">
                <h4>セッション</h4>
                <form id="form-session" method="post" action="post-session" target="_blank">
                    <?php include('parts/form-session.php'); ?>
                </form>
            </section>

            <section id="post-novel">
                <h4>小説</h4>
                <form id="form-novel" method="post" action="post-novel">
                    <?php include('parts/form-novel.php'); ?>
                </form>
            </section>

            <section id="post-illust">
                <h4>イラスト</h4>
                <form id="form-illust" method="post" action="post-illust" target="_blank">
                    <?php include('parts/form-illust.php'); ?>
                </form>
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
                <li id="preview"><button></button></li>
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
    <script src="../js/post.js"></script>
</body>

</html>