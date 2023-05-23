<?php
$userid = $_COOKIE["loginuserid"];
$member = parse_ini_file("../data/member.cgi", true);
$title = $member[$userid]["name"];
$is_setting = true;
include_once("../parts/head.php");

// 小説個人リスト
$novel_path = $userid !== "develop" ? "../data/{$userid}/novel/lists.xml" : "../data/0000/novel/lists.xml";
$novel_is_create = false;
if(file_exists($novel_path)){
    $novel_lists = simplexml_load_file($novel_path);
    $novel_is_create = $novel_lists->count() > 0;
}
if ($novel_is_create) {
    $novels = $novel_lists->novel;
    // 小説公開リスト
    $novel_xml = simplexml_load_file("../data/novel_lists.xml");
    // 公開リストを先に取得
    foreach ($novel_xml->novel as $i) {
        if ((string)$i->userid === $userid) {
            $pub_novel_list[] = $i->postid;
        }
        else if($userid  === "develop" && (string)$i->userid === "0000"){
            $pub_novel_list[] = $i->postid;
        }
    }
}

?>

<body id="USER_SETTING">
    <?php include_once("../parts/header.php"); ?>
    <main>
        <article>
            <h2><span>設定</span></h2>
            <section>
                <dl class="inline">
                    <dt>ユーザー名</dt>
                    <dd><?php echo $member[$userid]["name"] ?></dd>

                    <dt>ダークモード設定</dt>
                    <dd>
                        <label><input type="radio" id="mode-default" name="darkmode">端末依存</label>
                        <label><input type="radio" id="mode-light" name="darkmode">ライト</label>
                        <label><input type="radio" id="mode-dark" name="darkmode">ダーク</label>
                    </dd>

                <?php // ゲストモード
                if ($userid === "guest") { ?>
                </dl>
            </section>
        </article>
                    
        <p>ゲストモードでログインしています<br>
        ユーザーでログインし直す場合は<a href="/" class="btn">こちら</a></p>
                    
    </main>
    <?php include_once("../parts/footer.php"); ?>
    </body>
</html>
                    
                <?php exit; } ?>

                    <dt>パスワード</dt>
                    <dd>
                        <label id="pswd">現在のパスワード：<?php echo $_COOKIE['loginpass']; ?></label>
                        <div id="pswd-status" <?php echo $_COOKIE["loginhash"] === "d74ff0ee8da3b9806b18c877dbf29bbde50b5bd8e4dad7a3a725000feb82e8f1" ? "class='init'":""; ?>></div>
                        <form>
                            <input type="text" id="newpswd">
                            <button type="button" id="pswdChange" disabled>変更</button>
                        </form>
                    </dd>
                </dl>
            </section>
        </article>

        <article>
            <h2 id="novel-list"><span>小説</span></h2>
            <div id="novel-status"></div>
            <section>
                <?php
                if ($novel_is_create) { 
                    $count = count($novels);
                ?>
                
                <div class="novel-thumbnail">
                    <?php
                    for ($i = $count - 1; $i >= 0; $i--) {
                        $novel = $novels[$i];
                        $postid = (string)$novel->postid;
                        $username = $novels[$i]["anonymous"] === "false" ? $member[(string)$novels[$i]->userid]["name"] : "匿名";
                        $url = "../novel/novel?userid={$novels[$i]->userid}&postid={$postid}";
                        $imgurl = "{$dir}../img/novel-cover/{$novel->img}";
                        $title = $novel->title;
                        // ルビ対策
                        $ruby = "/<ruby><rb>(.*?)<\/rb><rp>（<\/rp><rt>(.*?)<\/rt><rp>）<\/rp><\/ruby>/";
                        $title_rmruby = preg_replace($ruby, "$1", $title);
                        $is_private = !isset($pub_novel_list) || !in_array($postid, $pub_novel_list);
                    ?>
                    <div class="novel <?php echo $is_private ? "private":""; ?>">
                        <div>
                            <div class="novel-cover">
                                <a href="<?php echo $url; ?>"><img src="<?php echo $imgurl; ?>">
                                <span><?php echo $title; ?></span></a>
                            </div>
                            <div class="caption">
                                <h4><a href="<?php echo $url; ?>"><?php echo $title; ?></a></h4>
                                <div class="user"><a><?php echo $username; ?></a></div>
                                <?php if (!empty($novel->tags)) {?>
                                    <ul class="hashtag">
                                        <?php foreach ($novel->tags->tag as $tag) {?>
                                        <li><a><?php echo $tag; ?></a></li>
                                        <?php } // foreach?>
                                    </ul>
                                <?php } // if (!empty ?>
                                <p><?php echo $novel->caption; ?></p>
                                <div class="post-data">
                                    <span class="length"><?php echo $novel->length; ?>文字</span>
                                    <span class="readtime"><?php echo $novel->readtime; ?></span>
                                </div>
                            </div>
                        </div>
                        <form type="novel" title="<?php echo $title_rmruby; ?>" postid="<?php echo $postid; ?>">
                            <button type="button" class="showToggle"><?php echo $is_private ? "公開" : "非公開"; ?></button>
                            <button type="button" class="edit">編集</button>
                            <button type="button" class="delete">削除</button>
                            <?php // ↓これは編集時のPOST用 ?>
                            <input type="hidden" name="type" value="novel">
                            <input type="hidden" name="postid" value="<?php echo $postid; ?>">
                        </form>
                    </div>
                    <?php } // for
                } // $novel_is_create ?>
                </div>
                <?php if (!$novel_is_create) {?>
                <p class="center">まだ執筆していないようです</p>
                <?php }?>
            </section>
        </article>
    </main>

    <?php include_once("../parts/footer.php"); ?>
    <script src="/js/usersetting.js"></script>
</body>

</html>