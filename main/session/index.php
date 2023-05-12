<?php 
$title = 'セッション';
include('../_module/head.php');
?>
<body>
    <?php 
    $is_index_session = true;
    include('../_module/header.php');
    ?>

    <main>
        <article>
            <section>
                <p>サムネイルデザインはできてるけど実装はまだです。<br>
                現在はとりあえず投稿済みだけを列挙してます。</p>
            </section>
            <section>
                <h3><span>セッション</span></h3>
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