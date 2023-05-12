<dl>
    <?php include('parts/header.php'); ?>

    <dt class="required">タイトル</dt>
    <dd><input type="text" name="title" placeholder="タイトル" required></dd>

    <dt class="required">表紙</dt>
    <dd id="novel-cover">
        <?php
        $novel_cover = glob('../img/novel-cover/*');
        $c = 0;
        foreach ($novel_cover as $cover) {
            $cover_name = basename($cover);
            switch($cover_name){
                case 'notnovelcover.jpg':
                    break;
                case $cover === end($novel_cover):
                    echo '<label><img src="'.$cover.'"><input type="radio" name="novel-cover" value = "'.$cover_name.'" required></label>';
                    break;
                default:
                echo '<label><img src="'.$cover.'"><input type="radio" name="novel-cover" value = "'.$cover_name.'"></label>';
                break;
            }
        }
        ?>
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
    <dd>
        <textarea id="caption" name="caption" placeholder="キャプション"></textarea>
    </dd>

    <dt class="required">本文</dt>
    <dd id="novel-body">
        <label>1ページ目</label>
        <textarea name="1" placeholder="本文 1" required></textarea>
        <label class="length length-1">文字数</label>
        <button type="button" id="add-page">ページを追加</button>
        <button type="button" id="remove-page">ページを削除</button>
        <input type="hidden" id="pages" name="pages" value="1">
        <input type="hidden" id="length" name="length">
    </dd>

    <dt>後書き</dt>
    <dd>
        <textarea id="afterword" name="afterword" placeholder="後書き"></textarea>
    </dd>
</dl>

<?php include('parts/footer.php'); ?>