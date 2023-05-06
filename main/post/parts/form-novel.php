<dl>
    <?php include('common-header.php'); ?>
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

<?php include('parts/common-footer.php'); ?>