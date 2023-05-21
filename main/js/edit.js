$(function () {

    $(".add-page").click(function () {
        let pageNum = CountPages(false,true);
        let addNum = pageNum + 1;
        let placeholder = `本文${addNum}`;
        let elem = 
        `<div id="page-${addNum}">
            <label>${addNum}ページ目</label>
            <textarea name="${addNum}" placeholder="${placeholder}"></textarea>
            <label class="length length-${addNum}">文字数</label>
        </div>`;

        $("#novel-body").append(elem);
        CountPages(true,false);
    })

    // $(document).on("input", "#novel-body textarea", function () {
    //     const length = $(this).val().replace(/\n/g, "").length;
    //     $(this).next("label").text(`${length}文字`);

    //     CountLength();
    // })

    // $("#remove-page").click(function () {
    //     let $value = $("#pages").val();
    //     let result = window.confirm(`本文${$value}を削除しますか？`);

    //     if (result) {
    //         const textarea = $(`textarea[name="${$value}"]`);
    //         textarea.prev("label").remove();
    //         textarea.remove();
    //         $(`.length-${$value}`).remove();
    //         $("#pages").attr("value", $value - 1);

    //         CountLength();
    //     }
    // })

    function CountPages(set = true,get = true){
        let $pageCount = $("#novel-body > div").length;
        if(set) $("#pages").attr("value",$pageCount);
        if(get) return $pageCount;
    }

    function CountAllLength() {
        let all_length = 0;
        $("dev[id*='page-'] textarea").each(function(){
            all_length += $(this).val().replace(/\n/g, "").length;
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
})