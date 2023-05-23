$(function () {
    const $form = $("form");

    $("#preview button").click(function () {
        $form.attr("action", "/post/preview");
        $form.attr("target", "_blank");
        $form.attr("method", "POST");
        $form.submit();
        $form.attr("action", "");
        $form.attr("target", "");
        $form.attr("method", "");
    })

    $("button.overwrite").click(function(){
        if(!$form[0].reportValidity()){
            return false;
        }
        
        $.ajax({
            url: "/user/_module/overwrite",
            type: "POST",
            data: { form_data: JSON.stringify($form.serialize()) },
            dataType: "json",
            timespan: 1000,
        })
            .done(function(data){
                edit_result(true, data);
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                edit_result(false, null, errorThrown.message);
            })
    })

    function edit_result(success,jsonData,error_text=null){
        $("body,html").animate({ scrollTop: 0 }, 0);
        const $result = $("#editResult");
        // クラスを全削除
        $result.removeClass();
        if (success === false) {
            $result.addClass("error");
            return false;
        }
        if (jsonData.result === "error") {
            $result.addClass("error");
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
            $result.addClass("error");
            $result.append("<p>投稿がされているか<a href='/user'>設定</a>からご確認ください</p>");
            return false;
        }

        url += `?userid=${userid}&postid=${postid}`;
        $result.addClass("success");
        let link = `<a href="${url}">編集結果を確認する</a>`;
        $result.append(link);
    }
})