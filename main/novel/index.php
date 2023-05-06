<!DOCTYPE html>
<html lang="ja">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="robots" content="noindex,noarchive,noimageindex">
    <title>novel top - Imaginarium of the Table</title>
    <!-- css -->
    <link rel="stylesheet" href="../css/style.css" type="text/css" id="style">
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
<body>
    <header class="passcheck">
        <h1><a href="top.html">Imaginarium of the Table</a></h1>
        <nav id="mainMenu" class="menu">
            <ul>
                <li><a href="../top.html">top</a></li>
                <li><a href="../post/postform.php">投稿画面</a></li>
                <li><a href="../session.html">セッションサンプル</a></li>
                <li><a href="../document.html">ドキュメント</a></li>
            </ul>
        </nav>
    </header>
    <button type="button" id="toggleMenu"></button>

    <main class="passcheck">
        <article>
            <h2><span>投稿された小説</span></h2>
            <section>
                <p>サムネイルデザインはできてるけど実装はまだです。<br>
                現在はとりあえず投稿された作品だけを列挙してます。</p>
            </section>
            <section>
                <h3><span>小説</span></h3>
                <ul style="list-style: none; padding : 0;">
                    <?php 
                        //$path = 'index.php';
                        // $result = glob(dirname($path));
                        $novels = glob('./*.html');
                        foreach($novels as $value){
                            $metatags =  get_meta_tags($value);
                            echo '<li><a href="'. $value . '"</a>' . $metatags['title'] . '</li>';
                        }
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
                <a href="index.html">indexへ</a>
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