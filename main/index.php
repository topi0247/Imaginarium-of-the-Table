<?php 
$title = 'Imaginarium of the Table';
$meta_title = 'index';
$dir = './';
include($dir . 'module/head.php');
?>
<body id="INDEX">
    <main>
        <article>
            <h1><a href="index.php">Imaginarium of the Table</a></h1>
            <div class="center">
                <p>TRPG部 活動記録</p>
                <div id="loginResult"></div>
                <form>
                    <input type="text" placeholder="password" id="loginPass">
                    <input type="button" value="send" id="login" href="top.php">
                </form>
            </div>
        </article>
    </main>

    <footer>
        <p class="small">© 2023 Imaginarium of the Table - by TRPG部</p>
        <nav id="pageBottonNav" class="fixed-menu">
            <ul>
                <li id="changeMode" class="mode"><button></button></li>
            </ul>
        </nav>
    </footer>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    <!-- 3rd -->
    <script src="js/3rd/sha256.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.js"></script>
    <!-- script -->
    <script src="js/script.js"></script>
</body>
</html>