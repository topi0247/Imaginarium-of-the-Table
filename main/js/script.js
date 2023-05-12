$(function () {
    const SCROLL_OFFSET = 100;
    const SCROLL_VIEW_TOP = 500;
    const HEADER_POINT = 300;
    const ANIM_TIME = 300;
    const HTML_OBJ = $('html');
    var scrollPoint = $(window).scrollTop();

    // スクロール
    $(window).scroll(function () {
        if (window.matchMedia("(max-width: 1024px)").matches) return false;

        let current = $(this).scrollTop();
        if (current >= scrollPoint) {
            /* 下スクロール */
            if(current >= HEADER_POINT){
                $('#mainMenu').addClass('scroll');
            }
            if (current >= SCROLL_VIEW_TOP) {
                $('#mainMenu').addClass('view');
            }
        } else {
            /* 上スクロール */
            if(current < SCROLL_VIEW_TOP){
                $('#mainMenu').removeClass('view');
            }
            if(current < HEADER_POINT){
                $('#mainMenu').removeClass('scroll');
            }
        }
        scrollPoint = current;
    });

    // スマホ用メインメニュー
    $('#toggleMenu').click(function(){
        $(this).toggleClass('close');
        $('#mainMenu').toggleClass('open');
    })

    // ダークモード切替
    $('#changeMode').click(function () {
        let currentMode = HTML_OBJ.attr('theme');
        if (currentMode === 'light') {
            HTML_OBJ.attr('theme', 'dark');
            window.sessionStorage.setItem("user", "dark");
        } 
        else if (currentMode === 'dark') {
            HTML_OBJ.attr('theme', 'light');
            window.sessionStorage.setItem("user", "light");
        }
    })

    // リンクスクロールアニメーション
    $('a[href^="#"]').click(function () {
        /* スマホ時メニューから飛んだら閉じるようにする */
        if($('#mainMenu').hasClass('open')){
            $('#toggleMenu').toggleClass('close');
            $('#mainMenu').toggleClass('open');
        }

        var href = $(this).attr("href"),
            target = $(href == "#" || href == "" ? "html" : href),
            position = target.offset().top - SCROLL_OFFSET;

        scroll(position);
    });

    // ページトップ
    $('#pageTop').click(function(){
        scroll(0);
    })

    // スクロールアニメーション
    function scroll(pos){
        $("body,html").animate({ scrollTop: pos }, ANIM_TIME, "swing");
    }
})