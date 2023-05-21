$(function () {
    // ダークモード
    let userMod = window.matchMedia("(prefers-color-scheme: dark)").matches;
    let sMode = window.sessionStorage.getItem("user");
    const mode_default = $("#mode-default");
    const mode_light = $("#mode-light");
    const mode_dark = $("#mode-dark");
    const HTML_OBJ = $("html");
    
    if (sMode) {
        if(sMode == "dark"){
            mode_dark.prop("checked",true);
        }else{
            mode_light.prop("checked",true);
        }
    }else {
        mode_default.prop("checked",true);
    }

    mode_default.click(function(){
        $(this).prop("checked",true);
        if(userMod){
            ChangeMode("dark",false);
        }else{
            ChangeMode("light",false);
        }
    })

    mode_light.click(function(){
        $(this).prop("checked",true);
        ChangeMode("light",true);
    })

    mode_dark.click(function(){
        $(this).prop("checked",true);
        ChangeMode("dark",true);
    })

    function ChangeMode(mode,isSet){
        HTML_OBJ.attr("theme", mode);
        if(isSet){
            window.sessionStorage.setItem("user", mode);
        }else{
            window.sessionStorage.removeItem("user");
        }
    }

    // パスワード変更
    $("#newpswd").on("input",function(){
        let is_disabled = $(this).val().length === 0;
        $("#pswdChange").prop("disabled", is_disabled);
    })

    $("#pswdChange").click(function(){
        let $pswd = $("#newpswd").val();
        $.ajax({
            url: "/user/_module/mod",
            type: "POST",
            data: { pswd: $pswd },
            dataType: "json",
            timespan: 1000,
        })
            .done(function(data){
                $("#pswd-status").addClass("success");
                $("#pswd").text(`現在のパスワード：${$.cookie("loginpass")}`);
                $("#newpswd").val("");
            })
            .fail(function () {
                $("#pswd-status").addClass("error");
            })
    })

    $("button").click(function(){
        if($(this).attr("id") === "pswdChange") return;
        let $resultDiv;
        let $parent;
        let $button = $(this);
        let $type = $button.parent().attr("type");
        if($type === "novel"){
            $resultDiv = $("#novel-status");
            $parent = $button.parents(".novel");
        }
        else if($type === "illust"){
            $resultDiv = $("#illust-status");
            $parent = $button.parents(".illust");
        }

        if($resultDiv === undefined || $parent === undefined){
            alert("予期せぬエラーが発生しました");
            //send_disord(`設定画面でタグが見つからないエラーが発生しました\ntype : ${$type}`);
            return;
        }

        let $title = $button.parent().attr("title");
        let $text = $button.text();
        let result = window.confirm(`${$title} を${$text}しますか？`);
        if (result) {
            let $modeValue = $button.attr("class");
            let url = $modeValue === "edit" ? "/user/edit" : "/user/_module/mod";
            let $postid = $button.parent().attr("postid");
            if($modeValue === "edit"){
                let $form = $(this).parent();
                $form.attr("action",url);
                $form.attr("method", "POST");
                $form.submit();
                return false;
            }
            if($modeValue === "showToggle"){
                $modeValue = $text === "非公開" ? "private" : "public";
            }

            $.ajax({
                url: url,
                type: "POST",
                data: {
                    type: $type,
                    mod: $modeValue,
                    postid: $postid,
                },
                dataType: "json",
                timespan: 1000,
            })
                .done(function (data) {
                    let status = data["status"];
                    if(status === "error"){
                        //let error_text = data["error_text"];
                        //send_disord(`エラーが発生しました：${error_text}`);
                    }
                    $resultDiv.attr("class",status);
                    switch(status){
                        case "private":
                            $parent.addClass("private");
                            $button.text("公開");
                            break;
                        case "public":
                            $parent.removeClass("private");
                            $button.text("非公開");
                            break;
                        case "delete":
                            $parent.remove();
                            break;
                    }
                })
                .fail(function () {
                    $resultDiv.addClass("error");
                })
                .always(function(){
                    let pos = $resultDiv.offset().top - 100;
                    $("body,html").animate({ scrollTop: pos }, 0);
                })
        }
    })

    function send_disord(text) {
        const message = {
            content: text,
            tts: false
        }

        const param = {
            method: "POST",
            headers: { "Content-type": "application/json" },
            body: JSON.stringify(message)
        }

        const webhook = "";
        fetch(webhook, param).then((res) => { }).then((json) => { });
    }
})