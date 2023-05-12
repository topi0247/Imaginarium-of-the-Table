<header>
    <?php
    if(!isset($is_preview)){
        echo '<h1><a href="' . $dir . 'top">Imaginarium of the Table</a></h1>';
    }
    else{
        echo '<h1><a>Imaginarium of the Table</a></h1>';
    }
    ?>
    <nav id="mainMenu" class="menu">
        <ul>
            <?php 
            if(isset($is_top)){
                echo '<li><a href="#ABOUT">about</a></li>
                    <!--<li><a href="' . $dir . 'session/index">セッション</a></li>-->
                    <li><a href="' . $dir . 'novel/index">小説</a></li>
                    <!--<li><a href="' . $dir . 'illust/index">イラスト</a></li>-->
                    <li><a href="' . $dir . 'post/index">投稿</a></li>
                    <li><a href="' . $dir . 'users">設定</a></li>';
            }

            if(isset($is_setting)){
                echo '<li><a href="' . $dir . 'top">トップ</a></li>
                    <!--<li><a href="' . $dir . 'session/index">セッション</a></li>-->
                    <li><a href="' . $dir . 'novel/index">小説</a></li>
                    <!--<li><a href="' . $dir . 'illust/index">イラスト</a></li>-->
                    <li><a href="' . $dir . 'post/index">投稿</a></li>
                    <li><a href="' . $dir . 'users">設定</a></li>';
            }

            if(isset($is_log)){
                echo '<li><a href="' . $dir . 'top">トップ</a></li>
                    <!--<li><a href="' . $dir . 'session/index">セッション</a></li>-->
                    <li><a href="' . $dir . 'novel/index">小説</a></li>
                    <!--<li><a href="' . $dir . 'illust/index">イラスト</a></li>-->
                    <li><a href="' . $dir . 'post/index">投稿</a></li>
                    <li><a href="' . $dir . 'users">設定</a></li>';
            }

            if(isset($is_develop)){
                echo '<li><a href="' . $dir . 'top">トップ</a></li>
                    <!--<li><a href="' . $dir . 'session/index">セッション</a></li>-->
                    <li><a href="' . $dir . 'novel/index">小説</a></li>
                    <!--<li><a href="' . $dir . 'illust/index">イラスト</a></li>-->
                    <li><a href="' . $dir . 'post/index">投稿</a></li>
                    <li><a href="' . $dir . 'users">設定</a></li>';
            }

            if(isset($is_index_session)){
                echo '<li><a href="' . $dir . 'top">トップ</a></li>
                    <!--<li><a href="' . $dir . 'session/index">セッション</a></li>-->
                    <li><a href="' . $dir . 'novel/index">小説</a></li>
                    <!--<li><a href="' . $dir . 'illust/index">イラスト</a></li>-->
                    <li><a href="' . $dir . 'post/index">投稿</a></li>
                    <li><a href="' . $dir . 'users">設定</a></li>';
            }

            if(isset($is_index_novel)){
                echo '<li><a href="' . $dir . 'top">トップ</a></li>
                    <!--<li><a href="' . $dir . 'session/index">セッション</a></li>-->
                    <li><a href="' . $dir . 'novel/index">小説</a></li>
                    <!--<li><a href="' . $dir . 'illust/index">イラスト</a></li>-->
                    <li><a href="' . $dir . 'post/index">投稿</a></li>
                    <li><a href="' . $dir . 'users">設定</a></li>';
            }

            if(isset($is_index_illust)){
                echo '<li><a href="' . $dir . 'top">トップ</a></li>
                    <!--<li><a href="' . $dir . 'session/index">セッション</a></li>-->
                    <li><a href="' . $dir . 'novel/index">小説</a></li>
                    <!--<li><a href="' . $dir . 'illust/index">イラスト</a></li>-->
                    <li><a href="' . $dir . 'post/index">投稿</a></li>
                    <li><a href="' . $dir . 'users">設定</a></li>';
            }

            if(isset($is_index_post)){
                echo '<li><a href="' . $dir . 'top">トップ</a></li>
                    <!--<li><a href="' . $dir . 'session/index">セッション</a></li>-->
                    <li><a href="' . $dir . 'novel/index">小説</a></li>
                    <!--<li><a href="' . $dir . 'illust/index">イラスト</a></li>-->
                    <li><a href="' . $dir . 'post/index">投稿</a></li>
                    <li><a href="' . $dir . 'users">設定</a></li>';
            }

            if(isset($is_preview)){
                echo '<li>トップ</li>
                    <!--<li>セッション</li>
                    <li>イラスト</li>-->
                    <li>小説目次</li>
                    <li>投稿</li>
                    <li>設定</li>';
            }
            
            if(isset($is_session)){
                
            }

            if(isset($is_novel)){
                echo '<li><a href="' . $dir . 'top">トップ</a></li>
                    <li><a href="' . $dir . 'novel/index">小説目次</a></li>
                    <!--<li><a href="' . $dir . 'session/index">セッション</a></li>
                    <li><a href="' . $dir . 'illust/index">イラスト</a></li>-->
                    <li><a href="' . $dir . 'post/index">投稿</a></li>
                    <li><a href="' . $dir . 'users">設定</a></li>';
            }


            if(isset($is_illust)){
                
            }
            ?>
        </ul>
    </nav>
</header>
<button type="button" id="toggleMenu"></button>