<?php

/* ============================================================== */
/*                 自サイト以外からの受け入れ拒否                 */
/* ============================================================== */
$referrer = $_SERVER["HTTP_REFERER"];
$domain = parse_url($referrer);
if (!stristr($domain["host"], "localhost-iott") && !stristr($domain["host"], "imaginarium-of-the-table.wew.jp")) {
    $error_text = ["result" => "error"];
    $text = "不正なアクセスを検知しました：" . $referrer;
    $error_text = $error_text + array("error_text" => $text);
    send_message_exit($error_text);
}


/* ==================================== */
/*                 関数                 */
/* ==================================== */
function put_back_notation($text){
    $result = $text;
    // ルビ
    $ruby = "/<ruby><rb>(.*?)<\/rb><rp>（<\/rp><rt>(.*?)<\/rt><rp>）<\/rp><\/ruby>/";
    $replace = "[RB:$1>$2]";
    $result = preg_replace($ruby, $replace, $result);
    // 文字小
    $small ="/<span class='small'>(.*?)<\/span>/";
    $replace ="[S:$1]";
    $result = preg_replace($small, $replace, $result);
    // 文字大
    $large ="/<span class='large'>(.*?)<\/span>/";
    $replace ="[L:$1]";
    $result = preg_replace($large, $replace, $result);
    // 文字中央
    $center ="/<span class='block center'>(.*?)<\/span>/";
    $replace ="[C:$1]";
    $result = preg_replace($center, $replace, $result);
    // 文字右
    $right ="/<span class='block right'>(.*?)<\/span>/";
    $replace ="[R:$1]";
    $result = preg_replace($right, $replace, $result);
    // 改行
    $result = str_replace('<br>', "\n", $result);
    return $result;
}

/* ============================================== */
/*                 データ読み込み                 */
/* ============================================== */
$postid = $_POST["postid"];
$type = $_POST["type"];
$userid = $_COOKIE["loginuserid"] !== "develop" ? $_COOKIE["loginuserid"]: "0000";
$data_path = "../data/";
$post_data = "{$data_path}{$userid}/{$type}/{$postid}.xml";

if ($type === "novel") {
    $is_novel_edit = true;
    $novel_root = simplexml_load_file($post_data);
    $anonymous = $novel_root["anonymous"];
    $novel_info = $novel_root->info;
    $novel_title = put_back_notation($novel_info->title);
    $img = $novel_info->img;
    $category = $novel_info->category;
    $tags = $novel_info->tags;
    if ($tags->count() > 0) {
        $taglist="";
        foreach($tags->tag as $tag){
            $taglist .= "{$tag}　";
        }
    }
    $caption = put_back_notation($novel_info->caption);
    $length = $novel_info->length;
    $postday = $novel_info->postday;
    $createday = $novel_info->createday;
    $afterword = put_back_notation($novel_info->afterword);
    foreach ($novel_root->body->page as $page) {
        $pages[] = put_back_notation($page);
    }
} else {
}
$member = parse_ini_file("../data/member.cgi", true);
$title = "編集 {$novel_title}";
$is_edit = true;
include_once("../parts/head.php");
?>

<body>
    <?php include_once("../parts/header.php"); ?>
    <main>
        <h2><span>編集</span></h2>
        <article>
            <h3><span>準備中です。編集してもデータが保存されないので気をつけてください。</span></h3>
            <form>
                <section>
                <h4>本文</h4>
                    <!--<div>
                        <button type="button" class="add-page">ページを追加</button>
                        <button type="button" class="remove-page">ページを削除</button>
                    </div>-->

                    <div id="novel-body">
                        <?php 
                        for($i = 0 ; $i < count($pages); $i++){
                            $id = $i + 1;
                        ?>
                        <div id="page-<?php echo $id; ?>">
                            <label><?php echo $id; ?>ページ目</label>
                            <textarea name="<?php echo $id; ?>"><?php echo $pages[$i]; ?></textarea>
                            <label class="length length-<?php echo $id; ?>">文字数</label>
                        </div>
                        <?php } // for ?>
                    </div>

                    <button type="button" class="add-page">ページを追加</button>
                    <button type="button" class="remove-page">ページを削除</button>
                    <input type="hidden" id="pages" name="pages" value="<?php echo count($pages)?>">
                    <input type="hidden" id="length" name="length" value="<?php echo $length;?>">
                </section>

                <section>
                    <h4>情報</h4>
                    <dl>
                        <dt>匿名投稿</dt>
                        <dd>
                            <label><input type="checkbox" name="anonymous" <?php echo  $anonymous === "true" ? "checked" :"";?>>匿名投稿</label>
                            <label>名前を隠して投稿したい場合はこちらを選択してください</label>
                        </dd>

                        <dt>タイトル</dt>
                        <dd><input type="text" name="title" value="<?php echo $novel_title ?>"></dd>

                        <dt>表紙</dt>
                        <dd id="novel-cover">
                            <?php
                            $novel_cover = glob("../img/novel-cover/*");
                            foreach ($novel_cover as $cover) {
                                $cover_name = basename($cover); ?>
                                <label>
                                    <img src="<?php echo $cover; ?>">
                                    <input type="radio" name="novel-cover" value="<?php echo $cover_name; ?>" <?php echo $cover_name === (string)$img ? "checked" :""; ?>>
                                </label>
                            <?php } ?>
                        </dd>

                        <dt>カテゴリ</dt>
                        <dd>
                            <label>小説<input type="radio" name="category" value="novel" <?php echo $category === "novel" ? "checked": ""; ?>></label>
                            <label>ひとコマ<input type="radio" name="category" value="one-scene" <?php echo $category === "one-scene" ? "checked": ""; ?>></label>
                        </dd>

                        <dt>ハッシュタグ</dt>
                        <dd><label>#記号不要　空白区切り</label><br>
                            <input type="text" name="hash-tag" value="<?php echo $taglist; ?>">
                        </dd>

                        <dt>キャプション</dt>
                        <dd><textarea id="caption" name="caption"><?php echo $caption ?></textarea></dd>

                        <dt>後書き</dt>
                        <dd><textarea id="afterword" name="afterword"><?php echo $afterword ?></textarea></dd>
                    </dl>
                </section>
                <div class="center margin-3">
                    <button type="button" class="send">保存</button>
                </div>
                <input type="hidden" name="postday" value="<?php echo $postday; ?>">
                <input type="hidden" name="updateday" value="now">
            </form>
        </article>
    </main>

    <?php include_once("../parts/footer.php"); ?>
    <script src="/js/edit.js"></script>
</body>
</html>