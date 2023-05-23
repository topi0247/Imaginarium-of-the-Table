$(function () {
    var toolbox = `
    <div class="toolbox">
        <ul>
            <li><a class="addRuby">ルビを挿入</a></li>
            <li><a class="addSmall">文字を小さく</a></li>
            <li><a class="addLarge">文字を大きく</a></li>
            <li><a class="addCenter">中央に文字</a></li>
            <li><a class="addRight">右側に文字</a></li>
        </ul>
    </div>`;
    var $addTarget;

    $(document).on("click",".tools a",function(){
        $("body").append(toolbox);
        let $toppos = $(this).offset().top;
        let $leftpos = $(this).offset().left -80;
        $(".toolbox").offset({ top: $toppos, left: $leftpos });
        $addTarget = $(this).prev();
    })

    $(document).click(function(e){
        if($(".toolbox").length && !$(e.target).closest(".tools a").length && !$(e.target).closest(".toolbox").length){
            $(".toolbox").remove();
            return false;
        }
    })

    $(document).on("click",".toolbox a",function(){
        let $tagClass = $(this).attr("class");
        let add;
        switch($tagClass){
            case "addRuby":
                add = "[RB:漢字>かんじ]";
                break;
            case "addSmall":
                add = "[S:文字小]";
                break;
            case "addLarge":
                add = "[L:文字大]";
                break;
            case "addCenter":
                add = "[C:文字中央]";
                break;
            case "addRight":
                add = "[R:文字右端]";
                break;
        }
        let selectPos = $addTarget.get(0).selectionStart;
        let preText = $addTarget.val().substr(0,selectPos);
        let nextText = $addTarget.val().substr(selectPos);
        $addTarget.val(preText + add + nextText);
        CountLength();
    })

    $("#add-page").click(function () {
        let $prevNum = $("#pages").attr("value");
        let addNum = Number($prevNum) + 1;
        let placeholder = `本文${addNum}`;
        $(this).before(`
            <div id="page-${addNum}">
            <label>${addNum}ページ目</label>
            <div class="tools">
            <textarea name="${addNum}" placeholder="${placeholder}"></textarea>
            <a></a></div>
            <label class="length length-${addNum}">文字数</label>
            </div>`);
        $("#pages").attr("value", addNum);
    })

    $(document).on("input", "#novel-body textarea", function () {
        const length = $(this).val()
                            .replace(/\n/g, "")
                            .replace(/\[[a-zA-Z]*:/g, "")
                            .replace(/>/g, "")
                            .replace(/\]/g, "").length;
        $(this).parents("[id*='page-']").find("label.length").text(`${length}文字`);

        CountLength();
    })

    $("#remove-page").click(function () {
        let $value = $("#pages").val();
        let result = window.confirm(`本文${$value}を削除しますか？`);

        if (result) {
            $(`#page-${$value}`).remove();
            $("#pages").attr("value", $value - 1);

            CountLength();
        }
    })

    function CountLength() {
        let all_length = 0;
        $("#novel-body textarea").each(function () {
            all_length += $(this).val()
                        .replace(/\n/g, "")
                        .replace(/\[[a-zA-Z]*:/g, "")
                        .replace(/>/g, "")
                        .replace(/\]/g, "").length;
        })

        $("#length").attr("value", all_length);
    }

    $("#preview button").click(function () {
        if ($("input[value='type-session']").prop("checked")) {
            preview($("#form-session"));
        }
        else if ($("input[value='type-novel']").prop("checked")) {
            preview($("#form-novel"));
        }
        else if ($("input[value='type-illust']").prop("checked")) {
            preview($("#form-illust"));
        }

        function preview($form) {
            $form.attr("action", "preview");
            $form.attr("target", "_blank");
            $form.attr("method", "POST");
            $form.submit();
            $form.attr("action", "");
            $form.attr("target", "");
            $form.attr("method", "");
        }
    })

    $("button.send").click(function () {
        let $form = $(this).parents("form");
        if(!$form[0].reportValidity()){
            return false;
        }

        if ($(this).attr("name") === "post-private") {
            $("input[name='is_private']").val("true");
        }
        let url;
        switch ($form.attr("id")) {
            case "form-session":
                url = "/post/_module/post-session";
                break;
            case "form-novel":
                url = "/post/_module/post-novel";
                break;
            case "form-illust":
                url = "/post/_module/post-illust";
                break;
        }
        if (url === undefined) return;

        $.ajax({
            url: url,
            type: "POST",
            data: { form_data: JSON.stringify($form.serialize()) },
            dataType: "json",
            timespan: 1000,
        })
            .done(function (data) {
                post_result(true, data);
                $form
                    .find('input,textarea')
                    .not('input[type=\"radio\"],input[type=\"checkbox\"],:hidden, :button, :submit,:reset')
                    .val('');
                $form
                    .find('input[type=\"radio\"], input[type=\"checkbox\"],select')
                    .removeAttr('checked')
                    .removeAttr('selected');
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                post_result(false, null, errorThrown.message);
            })
    })

    function post_result(success, jsonData, error_text = null) {
        $("body,html").animate({ scrollTop: 0 }, 0);
        const $result = $("#postResult");
        // クラスを全削除
        $result.removeClass();
        if (success === false) {
            $result.addClass("post-error");
            return false;
        }

        if (jsonData.result === "error") {
            $result.addClass("post-error");
            return false;
        }

        let type = jsonData.type;
        let userid = jsonData.userid;
        let postid = jsonData.postid;
        let url;

        switch (type) {
            case "session":
                url = "/session/session";
                break;
            case "novel":
                url = "/novel/novel";
                break;
            case "illust":
                url = "/illust/illust";
                break;
        }

        if (url === undefined) {
            $result.addClass("post-error");
            $result.append("<p>投稿がされているか<a href='/user'>設定</a>からご確認ください</p>");
            return false;
        }

        url += `?userid=${userid}&postid=${postid}`;
        $result.addClass("post-success");
        let link = `<a href="${url}">投稿されたページを見る</a>`;
        $result.append(link);
    }

    $(window).on("beforeunload", function (e) {
        // 作業痛は鬱陶しいので表示しない
        //e.preventDefault();
    });

    $(window).on("popstate", function (e) {
        //delete_param();
        // 作業痛は鬱陶しいので表示しない
        //e.preventDefault();
    });

    $("#debugMode button").click(function(){
        $("input[name='title']").val("テストタイトル");
        $("input[name='novel-cover']:first-child").prop("checked",true);
        $("input[name='hash-tag']").val("タグ１　タグ２");
        $("textarea#caption").val("キャプション　キャプション\nキャプション");
        $("textarea[name='1']").val("サンプルテキスト\nサンプルテキストサンプルテキスト");
        CountLength();
        $("textarea#afterword").val("後書き　後書き\n後書き");
    })
})