$(function () {
    const PASS_HASH = 'ed5923da2296079d526cf1acb599fca50bfddc605888b4ced925ddf11947477a';
    const SCROLL_OFFSET = 100;
    const SCROLL_VIEW_TOP = 500;
    const HEADER_POINT = 300;
    const ANIM_TIME = 300;
    const HTML_OBJ = $('html');
    var scrollPoint = 0;

    mode();
    login();

    $(window).scroll(function () {
        if (window.matchMedia("(max-width: 1024px)").matches) return false;

        if ($(this).scrollTop() > scrollPoint) {
            /* 下スクロール */
            if ($(this).scrollTop() > SCROLL_VIEW_TOP) {
                $('#mainMenu').addClass('view');
            } else if($(this).scrollTop() > HEADER_POINT){
                $('#mainMenu').addClass('scroll');
            }
        } else {
            /* 上スクロール */
            if ($(this).scrollTop() < HEADER_POINT) {
                $('#mainMenu').removeClass('scroll');
            } else if($(this).scrollTop() < SCROLL_VIEW_TOP){
                $('#mainMenu').removeClass('view');
            }
        }
        scrollPoint = $(this).scrollTop();
    });

    $('#toggleMenu').click(function(){
        $(this).toggleClass('close');
        $('#mainMenu').toggleClass('open');
    })

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

    $('a[href^="#"]').click(function () {
        if($('#mainMenu').hasClass('open')){
            $('#toggleMenu').toggleClass('close');
            $('#mainMenu').toggleClass('open');
        }

        var href = $(this).attr("href"),
            target = $(href == "#" || href == "" ? "html" : href),
            position = target.offset().top - SCROLL_OFFSET;

        scroll(position);
    });

    $('#pageTop').click(function(){
        scroll(0);
    })

    // スクロールアニメーション
    function scroll(pos){
        $("body,html").animate({ scrollTop: pos }, ANIM_TIME, "swing");
    }

    // ダークモード切り替え
    function mode() {
        let userMod = window.matchMedia("(prefers-color-scheme: dark)").matches;
        let sMode = window.sessionStorage.getItem("user");
        let el = HTML_OBJ;

        if (sMode) {
            el.attr("theme", sMode);
        } 
        else {
            if (userMod == true) {
                el.attr("theme", "dark");
            } else {
                el.attr("theme", "light");
            }
        }
    }

    /* ログイン */
    function login(){
        if($('article').hasClass('overlay') && $.cookie('loginhash') != PASS_HASH){
            $('.passcheck').addClass('blur');
            $('.overlay').show();
        }
    
        $('#debug').click(function(){
            $.removeCookie('loginpass');
            $.removeCookie('loginhash');
        })
        
        $('#loginPass').val($.cookie('loginpass'));
    
        $('#login').click(function() {
            const pass = $('#loginPass').val();
            const shaObj = new jsSHA('SHA-256','TEXT');
            shaObj.update(pass);
            const hash = shaObj.getHash("HEX");
            if (PASS_HASH === hash) {
                $.cookie('loginpass',pass);
                $.cookie('loginhash',hash);
                if($('article').hasClass('overlay')){
                    $('.passcheck').removeClass('blur');
                    $('.overlay').hide();
                }
                else{
                    window.location.href = $(this).attr('href');
                }
            }
            else{
                $('#loginResult').attr('class','error');
            }
        });
    }

})