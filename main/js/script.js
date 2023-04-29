$(function(){
        const SCROLL_TOP = 100;
        const HTML_OBJ=$('html');

        mode();
    
        $('#changeMode').click(function(){
            let currentMode = HTML_OBJ.attr('theme');
            if(currentMode === 'light'){
                HTML_OBJ.attr('theme','dark');
                window.sessionStorage.setItem("user", "dark");
                $(this).attr('class','darkmode');
            }else if(currentMode === 'dark'){
                HTML_OBJ.attr('theme','light');
                window.sessionStorage.setItem("user", "light");
                $(this).attr('class','lightmode');
            }
        })

        $('a[href^="#"]').click(function () {
            var href = $(this).attr("href"),
                target = $(href == "#" || href == "" ? "html" : href),
                position = target.offset().top - SCROLL_TOP;
    
            $("body,html").animate({ scrollTop: position }, animateTime, "swing");
            return false;
        });

        function mode(){
            // ダークモード切り替え
            let userMod = window.matchMedia("(prefers-color-scheme: dark)").matches;
            let sMode = window.sessionStorage.getItem("user");
            let el = HTML_OBJ;
            
            if (sMode) {
              el.attr("theme", sMode);
            } else {
              if (userMod == true) {
                el.attr("theme", "dark");
              } else {
                el.attr("theme", "light");
              }
            }
        }
})