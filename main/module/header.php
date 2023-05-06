<header class="passcheck">
    <h1><a href="<?php echo $dir; ?>top.php">Imaginarium of the Table</a></h1>
    <nav id="mainMenu" class="menu">
        <ul>
            <?php 
            if($header_about){
                echo '<li><a href="#ABOUT">about</a></li>';
            }

            if($header_top){
                echo '<li><a href="' . $dir . 'top.php">トップ</a></li>';
            }

            if($header_session){
                echo '<li><a href="' . $dir . 'session/index.php">セッション</a></li>';
            }

            if($header_novel){
                echo '<li><a href="' . $dir . 'novel/index.php">小説</a></li>';
            }

            if($header_illust){
                echo '<li><a href="' . $dir . 'illust/index.php">イラスト</a></li>';
            }

            if($header_post){
                echo '<li><a href="' . $dir . 'post/index.php">投稿</a></li>';
            }

            if($header_setting){
                echo '<li>設定</li>';
                // echo '<li><a href="' . $dir . '">セッション</a></li>';
            }

            ?>
        </ul>
    </nav>
</header>
<button type="button" id="toggleMenu"></button>
<!--
$header_about = true;
$header_top = true;
$header_session = true;
$header_novel = true;
$header_illust = true;
$header_post = true;
$header_setting = true;
-->
