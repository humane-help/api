<!DOCTYPE html>
<html lang="ru">
<head>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/normalize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('font-awesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('slick-1.8.1/slick/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('slick-1.8.1/slick/slick-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/media.css') }}">
    <link rel="stylesheet" href="{{ asset('css/animate.css') }}">
    <script src="{{ asset('js/wow.min.js') }}"></script>  
    <script>
      new WOW().init();
    </script>
    <title></title>
</head>
<body>
<!-- Header -->
<header class="header">
    <!-- Nav -->
    <nav class="nav wow fadeInDown">
        <div class="con">
            <div class="nav__box">
                <div class="nav__logo">
                    <a href="/">
                        <img src="{{ asset('img/logo.svg') }}" alt="Главная">
                    </a>
                </div>
                <div class="menu-open" id="menu-open">
                    <span class=""></span>
                </div>
                <ul class="nav__navbar">
                    <li class="nav__item">
                        <a href="/{{ \Illuminate\Support\Facades\App::getLocale() }}/solutions">{{ __('app.solutions') }}</a>
                    </li>
                    <li class="nav__item">
                        <a href="/{{ \Illuminate\Support\Facades\App::getLocale() }}/projects">{{ __('app.projects') }}</a>
                    </li>
                    <li class="nav__item">
                        <a href="/{{ \Illuminate\Support\Facades\App::getLocale() }}/services">{{ __('app.services') }}</a>
                    </li>
                    <li class="nav__item">
                        <a href="/{{ \Illuminate\Support\Facades\App::getLocale() }}/about">{{ __('app.about') }}</a>
                    </li>
                    <li class="nav__item">
                        <a href="/{{ \Illuminate\Support\Facades\App::getLocale() }}/team">{{ __('app.team') }}</a>
                    </li>
                    <li class="nav__item">
                        <a href="/{{  \Illuminate\Support\Facades\App::getLocale() == 'ru' ? 'en' : 'ru' }}">{{ \Illuminate\Support\Facades\App::getLocale() == 'ru' ? 'EN' : 'RU' }}</a>
                    </li>
                        
                </ul>
            </div>
        </div>
    </nav>
</header>


<!-- Main -->
<main class="main">
            @yield('content')

</main>

<!-- Footer -->
<footer class="footer">
    <div class="con">
        <div class="footer__box">
            <div class="footer__block wow fadeIn" date-wow-delay="0.2s">
                <h3>{{ __('app.contacts') }}</h3>
                <p>{{ __('app.address') }}</p>
                <p>{{ __('app.phone') }}</p>
                <p>©2020 GNI Software.</p>
            </div>
            <div class="footer__block wow fadeIn" date-wow-delay="0.4s">
                <h3>{{ __('app.solutions') }}</h3>
                <ul class="footer__nav">
                    @foreach(\App\Models\Newspaper::where('type', 'SOLUTION')->get() as $item)
                        <li>
                            <a href="/{{ \Illuminate\Support\Facades\App::getLocale() }}/solutions/{{ $item->id }}">{{ $item->title }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="footer__block wow fadeIn" date-wow-delay="0.6s">
                <h3>{{ __('app.services') }}</h3>
                <ul class="footer__nav">
                    @foreach(\App\Models\Newspaper::where('type', 'SERVICE')->get() as $item)
                        <li>
                            <a href="/{{ \Illuminate\Support\Facades\App::getLocale() }}/services/{{ $item->id }}">{{ $item->title }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="footer__block wow fadeIn" date-wow-delay="0.8s">
                <h3>{{ __('app.company') }}</h3>
                <ul class="footer__nav">
                    <li>
                        <a href="/{{ \Illuminate\Support\Facades\App::getLocale() }}/projects">{{ __('app.projects') }}</a>
                    </li>
                    <li>
                        <a href="/{{ \Illuminate\Support\Facades\App::getLocale() }}/about">{{ __('app.about') }}</a>
                    </li>
                    <li>
                        <a href="/{{ \Illuminate\Support\Facades\App::getLocale() }}/team">{{ __('app.team') }}</a>
                    </li>
                    <li>
                        <a href="/{{ \Illuminate\Support\Facades\App::getLocale() }}/job">{{ __('app.vacancy') }}</a>
                    </li>
                    <li>
                        <a href="/{{ \Illuminate\Support\Facades\App::getLocale() }}/news">{{ __('app.news') }}</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</footer>
    
<!-- ONTPCHAT -->
    <aside class="aside-feedback" inpage="0" style="/*display:none;*/">
      <div class="aside-feedback_overlay"></div>
      <nav class="nav-points nav-points__hide">
        <span class="nav-points__item nav-points__item--phone">
          <span class="nav-points__tooltip">Заказать презентацию решения</span>
          <img src="/gnisoft_chat/img/feed/phone.svg" alt="" class="nav-points__icon">
        </span>
        <span class="nav-points__item nav-points__item--message">
          <span class="nav-points__tooltip">Написать сообщение</span>
          <img src="/gnisoft_chat/img/feed/sms.svg" alt="" class="nav-points__icon">
        </span>
        <span class="nav-points__item nav-points__item--close">
          <span class="nav-points__anim-circle nav-points__anim-circle1"></span>
          <span class="nav-points__anim-circle nav-points__anim-circle2"></span>
          <span class="nav-points__tooltip">
            <span class="close">Скрыть окно</span>
            <span class="open">Обратная связь</span>
          </span>
          <img src="/gnisoft_chat/img/feed/close.svg" alt="" class="nav-points__icon close">
          <img src="/gnisoft_chat/img/feed/sms.svg" alt="" class="nav-points__icon open">
        </span>
      </nav>

      <form action="#" class="inpage-aside feed-inpage" id="feed-form" onsubmit="return false;">
        <header class="inpage-aside__header feed-inpage__header">
          <div class="inpage-aside__close feed-inpage__close">
            <img src="/gnisoft_chat/img/icons/close-gray.svg" alt="">
          </div>
          Заказать<br>презентацию решения<br>GNI Software
        </header>
        <section class="feed-inpage__body">
          <!--<h2 class="feed-inpage__heading">Заказать презентацию решения <br>GNI Software</h2>-->

          <label class="feed-inpage__item">

            <input autocomplete="off" type="text" name="name" class="inputfield feed-inpage__input" placeholder="Ваше имя">
          </label>

          <label class="feed-inpage__item">

            <input autocomplete="off" type="text" name="companyname" class="inputfield feed-inpage__input" placeholder="Название компании">
          </label>

          <label class="feed-inpage__item">

            <input autocomplete="off" type="phone" name="phone" class="inputfield feed-inpage__input" placeholder="Ваш номер">
          </label>

          <label class="feed-inpage__item">
            <input autocomplete="off" type="email" name="email" class="inputfield feed-inpage__input" placeholder="Ваша почта">
          </label>

          <label class="feed-inpage__item">
            <textarea type="email" name="message" class="inputfield feed-inpage__input feed-inpage__input--textarea" placeholder="Текст сообщения (не обязательно)"></textarea>
          </label>

          <label class="terms-label feed-inpage__terms grid__row">
            <span class="terms-label__input check-mark">
              <input type="checkbox" name="mark" class="check-mark__input">
              <img src="/gnisoft_chat/img/icons/accept.png" alt="" class="check-mark__checker">
            </span>
            <span class="terms-label__text">
              Продолжая, я принимаю
              <a href="#" class="terms-label__link">политику конфиденциальности</a> и
              <a href="#" class="terms-label__link">условия пользования</a>
            </span>
          </label>

          <button class="feed-inpage__button button green grid__row a-c">
            <span class="icon-border">
              <img src="/gnisoft_chat/img/icons/arrow-right-white.svg" alt="">
            </span>
            Отправить запрос
          </button>

        </section>
      </form>

      <section action="#" class="inpage-aside chat-inpage">
        <header class="inpage-aside__header chat-inpage__header">
          <div class="inpage-aside__close chat-inpage__close">
            <img src="/gnisoft_chat/img/icons/close-gray.svg" alt="">
          </div>
          Чат поддержки
        </header>
        <section class="chat-inpage__body">

          <div class="chat-empty">
            <h2 class="chat-empty__heading">Мы онлайн</h2>
            <small class="chat-empty__small">и с радостью готовы вам помочь прямо сейчас</small>
            <div class="chat-empty__list grid__row j-c">
              <div class="chat-empty__item avatar">
                <img src="/gnisoft_chat/img/avatar/avatar-1.jpg" alt="" class="avatar__icon">
                <div class="avatar__title">Василий Пупкин</div>
              </div>
              <div class="chat-empty__item avatar">
                <img src="/gnisoft_chat/img/avatar/avatar-1.jpg" alt="" class="avatar__icon">
                <div class="avatar__title">Виталий Пупкин</div>
              </div>
              <div class="chat-empty__item avatar">
                <img src="/gnisoft_chat/img/avatar/avatar-1.jpg" alt="" class="avatar__icon">
                <div class="avatar__title">Владимир Пупкин</div>
              </div>
            </div>
          </div>
          <div class="chat-message__templates" hidden="">
            <div class="chat-message__my">
              <div class="chat-message__text">
                <div class="chat-message__text__content">hi</div>
              </div>
            </div>
            <div class="chat-message__notmy">
               <!-- <img src="gnisoft_chat/img/avatar/gni.png" alt="" class="avatar__icon"> -->
              <div class="chat-message__text">
                <div class="chat-message__text__header">GNI Software</div>
                <div class="chat-message__text__content">hi</div>
              </div>
            </div>
          </div>
        </section>

        <footer class="chat-inpage__footer chat-form">
          <input autocomplete="off" type="text" placeholder="Введите сообщение..." class="chat-form__input">
          <button class="chat-form__button chat-form__sendfile">
            <img src="/gnisoft_chat/img/icons/file-dark.svg" alt="">
          </button>
          <button class="chat-form__button">
            <img src="/gnisoft_chat/img/icons/smile-dark.svg" alt="">
          </button>
        </footer>

      </section>
    </aside>
    <link rel="stylesheet" href="/gnisoft_chat/css/main.css">
    <script src="/gnisoft_chat/js/ontpchat.js"></script>
    <!-- ONTPCHAT -->

<script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('slick-1.8.1/slick/slick.min.js') }}"></script>
<script src="{{ asset('js/main.js') }}" defer></script>
</body>
</html>

