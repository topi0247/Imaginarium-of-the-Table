<h4>小説</h4>
<form id="form-novel" method="post" action="preview-novel.php" target="_blank">
    <dl>
        <dt>投稿者</dt>
        <dd>
            <select name="username">
                <option value="quen（かわず）">quen（かわず）</option>
                <option value="はたはた">はたはた</option>
                <option value="あるす">あるす</option>
            </select>
        </dd>

        <dt class="required">タイトル</dt>
        <dd><input type="text" name="title" placeholder="タイトル" required></dd>

        <dt>ハッシュタグ</dt>
        <dd>
            空白でタグ区切り、#記号は不要
            <input type="text" name="hash-tag" placeholder="タグ　タグ">
        </dd>

        <dt>前書き</dt>
        <dd><textarea id="caption" name="caption" placeholder="前書き"></textarea></dd>

        <dt class="required">本文</dt>
        <dd id="novel-body">
            <textarea name="1" placeholder="本文 1" required></textarea>
            <button type="button" id="add-page">ページを追加</button>
            <button type="button" id="remove-page">ページを削除</button>
            <input type="hidden" id="pages" name="pages" value="1">
        </dd>

        <dt>後書き</dt>
        <dd><textarea id="afterword" name="afterword" placeholder="後書き"></textarea></dd>
    </dl>
</form>