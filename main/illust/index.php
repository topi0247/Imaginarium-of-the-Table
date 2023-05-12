<?php 
$title = 'イラスト';
include('../_module/head.php');
?>
<body>
    <?php
    $is_index_illust = true;
    include('../_module/header.php');
    ?>

    <main>
        <article>
            <section>
                <p>サムネイルデザインはできてるけど実装はまだです。<br>
                現在はとりあえず投稿された作品だけを列挙してます。</p>
            </section>
            <section>
                <h3><span>イラスト</span></h3>
                <ul style="list-style: none; padding : 0;">
                <?php
                $data_path = './';
                include('../_module/toc.php');
                ?>
                </ul>
            </section>
        </article>
    </main>
    
    <?php include_once('../_module/footer.php'); ?>
</body>
</html>