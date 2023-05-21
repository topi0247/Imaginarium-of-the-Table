<footer>
    <p class="small">© 2023 Imaginarium of the Table - by TRPG部</p>
    <nav id="pageBottonNav" class="fixed-menu">
        <ul>
            <?php if(!isset($is_index)) { ?>
            <li id="pageTop" class="pagetop"><button></button></li>
            <?php } // !is_index ?>

            <?php if(isset($is_index_post) || isset($is_edit)) { ?>
            <li id="preview"><button></button></li>
            <?php } // is_index_post ?>

            <?php if($develop_mode) { ?>
            <li id="changeMode" class="mode"><button></button></li>
            <li id="debugMode"><button>D</button></li>
            <?php } // develop_mode ?>
        </ul>
    </nav>
</footer>
<?php include_once($dir . 'parts/script.php');?>
