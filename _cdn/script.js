$(function () {
    //MENU SIDEBAR
    $('.menu_toggle').click(function () {
        $('.menu_toggle').toggleClass('active');
    });

    $('.menu_toggle').click(function () {
        $('.sidebar').toggleClass('active');
    });

    //BUTÃO DE ROLAGEM & MENU SUSPENSO
    $(window).scroll(function () {
        if ($(this).scrollTop() > $('.main_header').outerHeight() + 100) {
            $('.main_header').addClass('dropdown');
            $('.j_back').fadeIn(500);
        } else {
            $('.main_header').removeClass('dropdown');
            $('.j_back').fadeOut(500);
        }
    });

    $('.j_back').click(function () {
        $('html, body').animate({scrollTop: 0}, 1000);
    });

    //BOTÃO DE CONTATO
    $('.toggle').click(function () {
        $('.aba_contato').toggleClass('active');
        $('.toggle').toggleClass('active');
    });

    //BARRAGEM DO SEARCH DO BLOG
    $('.search_btn').click(function () {
        $('.search').toggleClass('active');
        $('.search_btn').toggleClass('active');
    });

    //TEXTO DO HERO
    var type = new Typed('.type', {
        strings: [
            "Suporte Técnico em Notebooks",
            "Suporte Técnico em Desktops",
            "Desenvolvedor de WebSites"
        ],
        typeSpeed: 250,
        cursorChar: '_',
        backDelay: 200,
        loop: true
    });

    //ROLAGEM DA PÁGINA - SERVICOS
    $('.j_hero').click(function () {
        var goto = $('.' + $(this).attr('href').replace('#', '')).position().top;
        $('html, body').animate({scrollTop: goto - $('.main_header').outerHeight()}, 1000);
        return false;
    });

    //SLIDE DE ANÚNCIOS
    var textItems = $('.slide li').length;
    var textPosition = 1;

    for (i = 1; i <= textItems; i++) {
        $('.pagination').append('<li><span class="icon-circle"></span></li>');
    }

    $('.slide li').hide();
    $('.slide li:first').show();
    $('.pagination li:first').css('color', '#fff');

    $('.button_left span').click(prevSlider);
    $('.button_right span').click(nextSlider);

    setInterval(function () {
        nextSlider();
    }, 4000);

    function pagination() {
        var paginationPosition = $(this).index() + 1;

        $('.slide li').hide();
        $('.slide li:nth-child(' + paginationPosition + ')').fadeIn();

        $('.pagination li').css('color', 'rgba(255,255,255,0.5)');
        $(this).css('color', '#fff');

        textPosition = paginationPosition;
    }

    function nextSlider() {
        if (textPosition >= textItems) {
            textPosition = 1;
        } else {
            textPosition++;
        }

        $('.pagination li').css('color', 'rgba(255,255,255,0.5)');
        $('.pagination li:nth-child(' + textPosition + ')').css('color', '#fff');

        $('.slide li').hide();
        $('.slide li:nth-child(' + textPosition + ')').fadeIn();
    }

    function prevSlider() {
        if (textPosition <= 1) {
            textPosition = textItems;
        } else {
            textPosition--;
        }

        $('.pagination li').css('color', 'rgba(255,255,255,0.5)');
        $('.pagination li:nth-child(' + textPosition + ')').css('color', '#fff');

        $('.slide li').hide();
        $('.slide li:nth-child(' + textPosition + ')').fadeIn();
    }
});