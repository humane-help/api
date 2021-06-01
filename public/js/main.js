$('.carousel__box').slick({
    slidesToShow: 4,
    slidesToScroll: 1,
    autoplay: true,
    autoplaySpeed: 2000,
    responsive: [
        {
            breakpoint: 1000,
            settings: {
                slidesToShow: 2,
            }
        },
        {
            breakpoint: 600,
            settings: {
                slidesToShow: 1,
            }
        }
    ]
});

$('.reviews__box').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    autoplay: true,
    autoplaySpeed: 3000,
    dots: true,
});

$('.news__box').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    autoplay: true,
    autoplaySpeed: 4000,
    dots: true,
});

const accordeon = document.querySelectorAll('.accordeon__item');

accordeon.forEach(elements => {

    elements.classList.remove('active');

    elements.addEventListener('click', function() {

        if(!elements.classList.contains('active')) {
            accordeon.forEach (elements => {
                elements.classList.remove('active');
            });
        }

        elements.classList.toggle('active');

    });
});

document.querySelector('#menu-open span').addEventListener('click', function() {
    this.classList.toggle('active');
    document.querySelector('.nav__navbar').classList.toggle('active');
    if(this.classList.contains('active')) {
        document.querySelector('body').style.overflow = "hidden";
    }else{
        document.querySelector('body').style.overflow = "scroll";
    }
});