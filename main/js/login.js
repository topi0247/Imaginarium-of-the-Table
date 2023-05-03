$(function(){
    const PASS_HASH = 'ed5923da2296079d526cf1acb599fca50bfddc605888b4ced925ddf11947477a';

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
            }else{
                window.location.href = $(this).attr('href');
            }
        }else{
            $('#loginResult').attr('class','error');
        }
    });
})