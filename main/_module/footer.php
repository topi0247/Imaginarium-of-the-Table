<footer>
    <p class="small">© 2023 Imaginarium of the Table - by TRPG部</p>
    <nav id="pageBottonNav" class="fixed-menu">
        <ul>
            <?php
            echo isset($is_index) ? '' : '<li id="pageTop" class="pagetop"><button></button></li>';
            echo isset($is_index_post) ? '<li id="preview"><button></button></li>' : '';
            echo $develop_mode ? '
            <li id="changeMode" class="mode"><button></button></li>
            <li><button>D</button></li>':'';
            ?>
        </ul>
    </nav>
</footer>
<?php include_once($dir . '_module/script.php');?>
