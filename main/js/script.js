$(function () {
    const SCROLL_OFFSET = 100;
    const SCROLL_VIEW_TOP = 500;
    const HEADER_POINT = 300;
    const ANIM_TIME = 300;
    const HTML_OBJ = $("html");
    var scrollPoint = $(window).scrollTop();

    // スクロール
    $(window).scroll(function () {
        if (window.matchMedia("(max-width: 1024px)").matches) return false;

        let current = $(this).scrollTop();
        if (current >= scrollPoint) {
            /* 下スクロール */
            if(current >= HEADER_POINT){
                $("#mainMenu").addClass("scroll");
            }
            if (current >= SCROLL_VIEW_TOP) {
                $("#mainMenu").addClass("view");
            }
        } else {
            /* 上スクロール */
            if(current < SCROLL_VIEW_TOP){
                $("#mainMenu").removeClass("view");
            }
            if(current < HEADER_POINT){
                $("#mainMenu").removeClass("scroll");
            }
        }
        scrollPoint = current;
    });

    // スマホ用メインメニュー
    $("#toggleMenu").click(function(){
        $(this).toggleClass("close");
        $("#mainMenu").toggleClass("open");
    })

    // ダークモード切替
    $("#changeMode").click(function () {
        let currentMode = HTML_OBJ.attr("theme");
        if (currentMode === "light") {
            HTML_OBJ.attr("theme", "dark");
            window.sessionStorage.setItem("user", "dark");
        } 
        else if (currentMode === "dark") {
            HTML_OBJ.attr("theme", "light");
            window.sessionStorage.setItem("user", "light");
        }
    })

    // リンクスクロールアニメーション
    $("a[href^='#']").click(function () {
        /* スマホ時メニューから飛んだら閉じるようにする */
        if($("#mainMenu").hasClass("open")){
            $("#toggleMenu").toggleClass("close");
            $("#mainMenu").toggleClass("open");
        }

        var href = $(this).attr("href"),
            target = $(href == "#" || href == "" ? "html" : href),
            position = target.offset().top - SCROLL_OFFSET;

        scroll(position);
    });

    // ページトップ
    $("#pageTop").click(function(){
        scroll(0);
    })

    // スクロールアニメーション
    function scroll(pos){
        $("body,html").animate({ scrollTop: pos }, ANIM_TIME, "swing");
    }

    $("#content").on("input",function(){
        let is_disabled = $(this).val().length === 0;
        $("#send_discord").prop("disabled", is_disabled);
    })

    $("#send_discord").click(function() {
        let $username = $("#username").val().length > 0 ? $("#username").val():"匿名";
        let $env =   $("#environment").val().length > 0 ? $("#environment").val():"不明";
        let $content = $("#content").val();

        let text = `投稿者：${$username}\n環境：${$env}\n本文：${$content}`;
        //let sendData = {msg:text};

        $("#requestResult").removeClass();1

        $.ajax({
            url: "/_module/sendDiscord",
            type: "POST",
            data: {msg:text},
            dataType: "json",
            timespan: 1000,
        })
            .done(function () {
                $("#requestResult").attr("class","success");
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                $("#requestResult").attr("class","fail");
            })
    })
})