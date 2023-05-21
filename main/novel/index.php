<?php
$title = "小説目次";
$is_index_novel = true;
include("../parts/head.php");
?>

<body>
    <?php include_once("../parts/header.php"); ?>

    <main>
        <article>
            <h2><span>新着順</span></h2>
            <section>
                <?php include_once("toc.php");?>
            </section>
        </article>
    </main>

    <?php include_once("../parts/footer.php"); ?>
</body>

</html>