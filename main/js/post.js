$(function () {
    
    const param = location.search;
    
    if(param){
        const postReslt = $('#postResult');
        let addclass = '';
        let userid = '';
        let postid = '';
        if(param.includes('post')){
            if(param.includes('success')){
                addclass = 'post-success';
                userid = getParam('userid',param);
                postid = getParam('postid',param);
                let addLink ='<a href="../';
                switch(getParam('posttype',param)){
                    case 'novel':
                        addLink += 'novel/novel';
                        break;
                    case 'illust':
                        addLink += 'illust/illust';
                        break;
                    case 'session':
                        addLink += 'session/session';
                        break;
                }
                addLink += '?userid='+userid+'&postid='+postid+'">投稿されたページを見る</a>';
                postReslt.append(addLink);
            }
            else if(param.includes('error')){
                addclass = 'post-error';
            }
        }
        // else if(param.includes('draft')){
        //     if(param.includes('success')) addclass = 'draft-success';
        //     else if(param.includes('error')) addclass = 'draft-error';
        // }

        postReslt.addClass(addclass);
    }

    $('input[name="type"]').click(function() {
        let type = $("input[name='type']:checked").val();
        const session_submit = $('form#form-session button[type="submit"]');
        const novel_submit =  $('form#form-novel button[type="submit"]');
        const illust_submit =  $('form#form-illust button[type="submit"]');
        switch(type){
            case 'type-session':
                session_submit.prop('disabled', false);
                novel_submit.prop('disabled', true);
                illust_submit.prop('disabled', true);
                break;
            case 'type-novel':
                session_submit.prop('disabled', true);
                novel_submit.prop('disabled', false);
                illust_submit.prop('disabled', true);
                break;
            case 'type-illust':
                session_submit.prop('disabled', true);
                novel_submit.prop('disabled', true);
                illust_submit.prop('disabled', false);
                break;
        }
    });

    $(document).on('input','#novel-body textarea', function(){
        const length = $(this).val().replace(/\n/g, "").length;
        $(this).next('label').text(length + '文字');

        let all_length = 0;
        $('#novel-body textarea').each(function(){
            all_length += $(this).val().replace(/\n/g, "").length;
        })
        
        $('#length').attr('value',all_length);
    })
    
    $('#add-page').click(function(){
        let prevNum = $('#pages').attr('value');
        let addNum = Number(prevNum) + 1;
        let placeholder = '本文 '+ addNum;
        $(this).before('<label>'+addNum+'ページ目</label><textarea name="' + addNum + '" placeholder="' + placeholder + '"></textarea><label class="length length-'+addNum+'">文字数</label>');
        $('#pages').attr('value',addNum);
    })

    $('#remove-page').click(function(){
        let value = $('#pages').val();
        let result = window.confirm('本文 '+ value + ' を削除しますか？');
        
        if(result){
            const textarea = $('textarea[name="' + value + '"]');
            textarea.prev('label').remove();
            textarea.remove();
            $('.length-' + value).remove();
            $('#pages').attr('value', value - 1);

            CountLength();
        }
    })

    $('#preview button').click(function(){
        if($('input[value="type-session"]').prop('checked')){
            preview($('#form-session'));
        }
        else if($('input[value="type-novel"]').prop('checked')){
            preview($('#form-novel'));
        }
        else if($('input[value="type-illust"]').prop('checked')){
            preview($('#form-illust'));
        }

        function preview($form){
            const action = $form.attr('action');
            $form.attr('action','preview');
            $form.attr('target','_blank');
            $form.submit();
            $form.attr('target','');
            $form.attr('action',action);
        }
    })

    $(window).on('beforeunload', function(e) {
        // 作業痛は鬱陶しいので表示しない
        //e.preventDefault();
    });
    
    $(window).on('popstate', function(e) {
        //delete_param();
        // 作業痛は鬱陶しいので表示しない
        //e.preventDefault();
    });

    function getParam(name, url) {
        if (!url) url = window.location.href;
        name = name.replace(/[\[\]]/g, "\\$&");
        var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
            results = regex.exec(url);
        if (!results) return null;
        if (!results[2]) return '';
        return decodeURIComponent(results[2].replace(/\+/g, " "));
    }

    function CountLength() {
        let all_length = 0;
        $('#novel-body textarea').each(function () {
            all_length += $(this).val().replace(/\n/g, "").length;
        })

        $('#length').attr('value', all_length);
    }
})

function test(){
    console.log('test!!!');
}