$(function () {
    current_page_view();

    // 小説ページ切り替え
    $('.page-tab button').click(function () {
        let currentPage = location.hash.slice(1);
        let page = currentPage;

        if ($(this).hasClass('prev')) {
            page = Number(currentPage) - 1;
        }
        else if ($(this).hasClass('next')) {
            page = Number(currentPage) + 1;
        }
        else {
            page = $(this).text();
        }

        let current = 'current';
        let pageTab = $('.page-tab button');
        pageTab.removeClass(current);
        pageTab.each(function () {
            if ($(this).text() == page) {
                $(this).addClass(current);
                return false;
            }
        })

        let bodyDiv = $('#novel-body div');
        bodyDiv.removeClass(current);
        bodyDiv.each(function () {
            if ($(this).attr('id') == page) {
                $(this).addClass(current);
                return false;
            }
        })

        location.hash = page;
    })

    /* 現在ページ */
    function current_page_view() {
        if (!location.hash) return;
        let currentPage = location.hash.slice(1);

        let current = 'current';
        let pageTab = $('.page-tab button');
        pageTab.removeClass(current);
        pageTab.each(function () {
            if ($(this).text() == currentPage) {
                $(this).addClass(current);
                return false;
            }
        })

        let bodyDiv = $('#novel-body div');
        bodyDiv.removeClass(current);
        bodyDiv.each(function () {
            if ($(this).attr('id') == currentPage) {
                $(this).addClass(current);
                return false;
            }
        })
    }
})