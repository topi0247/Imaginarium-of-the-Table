$(function () {
    
    const param = location.search;
    const postReslt = $('#postResult');
    
    if(param){
        let addclass = '';
        let postid = '';
        if(param.includes('post')){
            if(param.includes('success')){
                addclass = 'post-success';
                postid = getParam('postid',param);
            }
            else if(param.includes('error')){
                addclass = 'post-error';
            }
        }
        else if(param.includes('draft')){
            if(param.includes('success')) addclass = 'draft-success';
            else if(param.includes('error')) addclass = 'draft-error';
        }

        postReslt.addClass(addclass);

        if(postid){
            let addLink = '<a href="../novel/'+postid+'.html">投稿された作品を見る</a>';
            postReslt.append(addLink);
        }
    }

    $('#preview button').click(function(){
        const preview = $('input[name="preview"]');
        preview.attr('value','true');
        if($('#type-session').prop('checked')){
            $('#form-session').submit();
        }
        else if($('#type-novel').prop('checked')){
            $('#form-novel').attr('target','_blank');
            $('#form-novel').submit();
            $('#form-novel').attr('target','');
        }
        else if($('#type-illust').prop('checked')){
            $('#form-illust').submit();
        }
        preview.attr('value','false');
    })

    $('#add-page').click(function(){
        let prevNum = $(this).prev().attr('name');
        let addNum = Number(prevNum) + 1;
        let placeholder = '本文 '+ addNum;
        $(this).before('<textarea name="' + addNum + '" placeholder="' + placeholder + '"></textarea>');
        $('#pages').attr('value',addNum);
    })

    $('#remove-page').click(function(){
        let last = $('#novel-body textarea:last');
        let result = window.confirm(last.attr('placeholder') + ' を削除しますか？');

        if(result){
            last.remove();
            let pages = $('#pages').attr('value');
            pages = pages - 1;
            $('#pages').attr('value',pages);
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
})

function test(){
    console.log('test!!!');
}