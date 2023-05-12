<?php
$title = '小説目次';
include('../_module/head.php');

$member = parse_ini_file('../data/member.ini', true);
?>

<body>
    <?php
    $is_index_novel = true;
    include('../_module/header.php');
    ?>

    <main>
        <article>
            <h2><span>新着順</span></h2>
            <section>
                <?php include_once('toc.php');?>
            </section>
        </article>
    </main>

    <?php include_once('../_module/footer.php'); ?>
</body>

</html>