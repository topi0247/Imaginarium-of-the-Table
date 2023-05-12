$(function () {
    // パスワードの状態
    const param = location.search;
    const pswd_status = $('#pswd-status');

    if (param.includes('pswd') && param.includes('success')) {
        pswd_status.addClass('change');
    }

    // ダークモード
    let userMod = window.matchMedia("(prefers-color-scheme: dark)").matches;
    let sMode = window.sessionStorage.getItem("user");
    const mode_default = $('#mode-default');
    const mode_light = $('#mode-light');
    const mode_dark = $('#mode-dark');
    const HTML_OBJ = $('html');
    
    if (sMode) {
        if(sMode == 'dark'){
            mode_dark.prop('checked',true);
        }else{
            mode_light.prop('checked',true);
        }
    }else {
        mode_default.prop('checked',true);
    }

    mode_default.click(function(){
        $(this).prop('checked',true);
        if(userMod){
            ChangeMode('dark',false);
        }else{
            ChangeMode('light',false);
        }
    })

    mode_light.click(function(){
        $(this).prop('checked',true);
        ChangeMode('light',true);
    })

    mode_dark.click(function(){
        $(this).prop('checked',true);
        ChangeMode('dark',true);
    })

    function ChangeMode(mode,isSet){
        HTML_OBJ.attr('theme', mode);
        if(isSet){
            window.sessionStorage.setItem('user', mode);
        }else{
            window.sessionStorage.removeItem('user');
        }
    }

    // パスワード変更
    $('#pswd-text').on('input',function(){
        let is_disabled = true;
        if ($(this).val().length > 0) {
            is_disabled = false;
        }
        $('#pswdchange-submit').prop('disabled', is_disabled);
    })

    // 公開非公開
    $('form button').click(function(){
        let text = $(this).text();
        if(text=='編集') return false;
        let result = window.confirm(''+$(this).val() + ' を'+text+'しますか？');
        if(result){
            const is_public = $(this).nextAll('input[name="is_public"]')
            switch(text){
                case '公開':
                    is_public.val('true');
                    break;
                case '非公開':
                    is_public.val('false');
                break;
            }
            $(this).parent().submit();
        }
    })
})