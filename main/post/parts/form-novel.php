<dl>
    <?php include("parts/header.php"); ?>
    <dt class="required">タイトル</dt>
    <dd><div class="tools"><input type="text" name="title" placeholder="タイトル" required><a></a></div></dd>

    <dt class="required">表紙</dt>
    <dd id="novel-cover">
        <?php
        $novel_cover = glob("../img/novel-cover/*");
        $count = 0;
        foreach ($novel_cover as $cover) { 
            $cover_name = basename($cover);?>
            <label><img src="<?php echo $cover; ?>"><input type="radio" name="novel-cover" value = "<?php echo $cover_name; ?>" <?php echo $count === 0 ? "required":""?>></label>
        <?php $count++;
        } ?>
    </dd>

    <dt>カテゴリ</dt>
    <dd>
        <label>小説<input type="radio" name="category" value="novel" checked></label>
        <label>ひとコマ<input type="radio" name="category" value="one-scene"></label>
    </dd>

    <dt>ハッシュタグ</dt>
    <dd><label>#記号不要　空白区切り</label><br>
        <input type="text" name="hash-tag" placeholder="タグ　タグ">
    </dd>

    <dt>キャプション</dt>
    <dd><div class="tools"><textarea id="caption" name="caption" placeholder="キャプション"></textarea><a></a></div></dd>

    <dt class="required">本文</dt>
    <dd id="novel-body">
        <div id="page-1">
            <label>1ページ目</label>
            <div class="tools"><textarea name="1" placeholder="本文 1" required></textarea><a></a></div>
            <label class="length length-1">文字数</label>
        </div>
        
        <button type="button" id="add-page">ページを追加</button>
        <button type="button" id="remove-page">ページを削除</button>
        <input type="hidden" id="pages" name="pages" value="1">
        <input type="hidden" id="length" name="length">
    </dd>

    <dt>後書き</dt>
    <dd>
    <div class="tools"><textarea id="afterword" name="afterword" placeholder="後書き"></textarea><a></a></div>
    </dd>
</dl>

<?php include("footer.php"); ?>