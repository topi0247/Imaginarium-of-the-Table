$(function () {

    $('#preview button').click(function(){
        if($('#type-session').prop('checked')){
            $('#form-session').submit();
        }
        else if($('#type-novel').prop('checked')){
            $('#form-novel').submit();
        }
        else if($('#type-illust').prop('checked')){
            $('#form-illust').submit();
        }
    })

    $(document).on('click','#add-page',function(){
        let prevNum = $(this).prev().attr('name');
        let addNum = Number(prevNum) + 1;
        let placeholder = '本文 '+ addNum;
        $(this).before('<textarea name="' + addNum + '" placeholder="' + placeholder + '"></textarea>');
        $('#pages').attr('value',addNum);
    })

    $(document).on('click','#remove-page',function(){
        let last = $('#novel-body textarea:last');
        let result = window.confirm(last.attr('placeholder') + ' を削除しますか？');

        if(result){
            last.remove();
            let pages = $('#pages').attr('value');
            pages = pages - 1;
            $('#pages').attr('value',pages);
        }
    })

    作業中は鬱陶しいので確認しない
    $(window).on('beforeunload', function(e) {
        e.preventDefault();
    });
    
    $(window).on('popstate', function(e) {
        e.preventDefault();
    });
})

function test(){
    console.log('test!!!');
}