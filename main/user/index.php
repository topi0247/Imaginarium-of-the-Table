<?php
$userid = $_COOKIE['loginuserid'];
$member = parse_ini_file('../data/member.ini', true);
$title = $member[$userid]['name'];
include('../_module/head.php');

// 小説個人リスト
$path = !$develop_mode ? '../data/' . $userid . '/novel/lists.xml' : '../data/0000/novel/lists.xml';
$is_create = false;
if(file_exists($path)){
    $novel_lists = simplexml_load_file($path);
    $is_create = $novel_lists->count() > 0;
}
if ($is_create) {
    $novels = $novel_lists->novel;
}

// 小説公開リスト
$novel_xml = simplexml_load_file('../data/novel_lists.xml');
// 公開リストを先に取得
foreach ($novel_xml->novel as $i) {
    if ($i->userid == $userid || ($develop_mode && $i->userid=='0000')) {
        $op_novel_list[] = (string)$i->postid;
    }
}
?>

<body id="USER_SETTING">
    <?php
    $is_setting = true;
    include('../_module/header.php');
    ?>
    <main>
        <article>
            <h2><span>設定</span></h2>
            <section>
                <dl class="inline">
                    <dt>ユーザー名</dt>
                    <dd><?php echo $member[$userid]['name'] ?></dd>

                    <dt>ダークモード設定</dt>
                    <dd>
                        <label><input type="radio" id="mode-default" name="darkmode">端末依存</label>
                        <label><input type="radio" id="mode-light" name="darkmode">ライト</label>
                        <label><input type="radio" id="mode-dark" name="darkmode">ダーク</label>
                    </dd>


                    <?php
                    if ($guest_mode) {
                        echo '</dl></section></article>
                        <p>ゲストモードでログインしています<br>
                        ユーザーでログインし直す場合は<a href="index" class="btn">こちら</a></p>
                        
                        </main>';
                        include_once('../_module/footer.php');
                        exit;
                    }
                    ?>
                    <dt>パスワード</dt>
                    <dd>
                        <label>現在のパスワード：<?php echo $_COOKIE['loginpass']; ?></label>
                        <div id="pswd-status" <?php echo $_COOKIE['loginhash'] == 'd74ff0ee8da3b9806b18c877dbf29bbde50b5bd8e4dad7a3a725000feb82e8f1' ? 'class="init"':'';?>></div>
                        <form action="edit" method="post">
                            <input type="text" id="pswd-text" name="passchange"> <button id="pswdchange-submit" name="passsubmit" value="パスワード" disabled>変更</button>
                        </form>
                    </dd>
                </dl>
            </section>
        </article>

        <article>
            <h2 id="novel-list"><span>小説</span></h2>
            <div id="novel-status" 
            <?php 
            $status = '';
            if(isset($_GET['type']) && $_GET['type']=='novel'){
                if($_GET['result'] != 'error'){
                    $status = $_GET['result'];
                }
                else{
                    $status = 'error';
                }
            }
            echo 'class="' . $status . '"';
            ?>></div>
            <section>
                <?php
                echo '<div class="novel-thumbnail">';
                if ($is_create) {
                    $count = count($novels);
                    for ($i = $count - 1; $i >= 0; $i--) {
                        $novel = $novels[$i];
                        $user = $novels[$i]['anonymous'] == 'false' ? $member[(string)$novels[$i]->userid]['name'] : '匿名';
                        $url = '../novel/novel?userid=' . $novels[$i]->userid . '&postid=' . $novel->postid;
                        $imgurl = $dir . '../img/novel-cover/';
                        $title = (string)$novel->title;
                        $is_public = true;
                        if (isset($op_novel_list) && in_array((string)$novel->postid, $op_novel_list)) {
                            echo '<div class="novel">';
                        } else {
                            echo '<div class="novel private">';
                            $is_public = false;
                        }
                        echo '<div><div class="novel-cover">
                                <a href="' . $url . '"><img src="' . $imgurl . (string)$novel->img . '"><span>' . $title . '</span></a>
                                </div>
                                <div class="caption">
                                    <h4><a href="' . $url . '">' . $title . '</a></h4>
                                    <div class="user"><a>' . $user . '</a></div>';
                        if (isset($novel->tags)) {
                            echo '<ul class="hashtag">';
                            foreach ($novel->tags->tag as $tag) {
                                echo '<li><a>' . (string)$tag . '</a></li>';
                            }
                            echo '</ul>';
                        }
                        echo '<p>' . (string)$novel->caption . '</p>
                            <div class="post-data">
                                <span class="length">' . $novel->length . '文字</span>
                                <span class="readtime">' . $novel->readtime . '</span>
                            </div></div></div>
                            <form action="edit" method="post">
                            <button type="submit" name="toggle" value="' . $title . '">' . ($is_public ? '非公開' : '公開') . '</button>
                            <button type="submit" name="novel-edit" disabled>編集</button>
                            <button type="submit" name="novel-remove" value="' . $title . '">削除</button>
                            <input type="hidden" name="post-info" value="novel-' . $novel->postid . '">
                            <input type="hidden" name="is_public" value="' . $is_public . '">
                        </form>';
                        echo '</div>';
                    }
                    echo '</div>';
                }
                if (!$is_create) {
                    echo '<p class="center">まだ執筆していないようです</p>';
                }
                ?>
            </section>
        </article>
    </main>

    <?php include_once('../_module/footer.php'); ?>
</body>

</html>