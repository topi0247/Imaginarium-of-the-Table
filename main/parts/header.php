<header>
    <h1><a <?php echo !isset($is_preview) ? "href='/top'" : "" ; ?>>Imaginarium of the Table</a></h1>
    <nav id="mainMenu" class="menu">
        <ul>
            <?php if(!isset($is_preview)){?>
            <li><a href="<?php echo isset($is_top) ? "#ABOUT" : "/top" ;?>"><?php echo isset($is_top) ? "about" : "トップ" ?></a></li>
            <!--<li><a <?php ?>href="/session">セッション<?php echo isset($is_session) ? "目次":""; ?></a></li>-->
            <li><a href="/novel">小説<?php echo isset($is_novel) ? "目次":""; ?></a></li>
            <!--<li><a href="/illust">イラスト<?php echo isset($is_illust) ? "目次":""; ?></a></li>-->
            <li><a href="/post">投稿</a></li>
            <li><a href="/user">設定</a></li>
            <?php } // if(!isset($is_preview)) ?>
            
            <?php if(isset($is_preview)){?>
            <li>トップ</li>
            <li>セッション</li>
            <li>小説</li>
            <li>イラスト</li>
            <li>投稿</li>
            <li>設定</li>
            <?php } // if(!isset($is_preview)) ?>
        </ul>
    </nav>
</header>
<button type="button" id="toggleMenu"></button>