@extends('layouts.app')

@section('content')
    @include('layouts.banner')

    <!-- Projects box -->
    <div class="con">
        <div class="projects-box">
            <img src="img/icons.png" alt="">
            <p>Система <span>«GNI@ MOBILE BANK24/7»</span> предоставляет клиентам наших партнеров возможность дистанционного банковского обслуживания для осуществления множества операций в онлайн режиме, это доступно в любой момент времени и с любого мобильного устройства, которое имеет доступ в глобальную сеть Internet.</p>
            <p>Для выполнения финансовых операций необходимо установить мобильное приложение «IOS» или «Android» в зависимости от типа операционной системы.</p>
            <p>Мы всегда учитываем индивидуальные особенности бизнеса наших партнеров, их стратегию, видение предоставляемого продукта, корпоративный стиль и пожелания. Как результат, мы совместно с нашим партнерами разрабатываем кастомизированный индивидуальный дизайн в соответствии с современными трендами, текущими пожеланиями рынка и рекомендациями «IOS guideline» и «Android guideline».</p>
        </div>
    </div>

    <!-- Projects -->
    <section class="solutions projects">
        <div class="con">
            <h2>{{ __('app.advantages') }}
                <img src="img/icons.png" alt="">
            </h2>
            <div class="solutions__box">
                @foreach(\App\Models\Newspaper::where('type', 'ADVANTAGE')->get() as $item)
                    <div class="solutions__block">
                        <h5>{{ $item->title }}</h5>
                        <p>{{ $item->mini_desc }}</p>
                        <span><img src="img/icon-1.png" alt=""></span>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Projects tech -->
    <div class="projects-tech">
        <div class="con">
            <div class="projects-tech__box">
                <div class="projects-box wow fadeInUp">
                    <img src="img/icons.png" alt="">
                    <h2>Применяемые технологии</h2>
                    <p>Фронтовая клиентская часть реализована на технологии React, пользовательский бэк интерфейс реализован на технологии Oracle Apex 5.1, сервер приложений Oracle Weblogic 12 и сервер базы данных Oracle 12.</p>
                    <p>Платформа поддерживает 2 технологии интеграций с внешними системами и подсистемами: SOAP и REST.</p>
                    <p>Одним из главных приоритетов нашей компании, является защищенность бизнеса клиентов. По этой причине, осуществляется идентификация клиента в момент входа в систему мобильного банкинга GNI Software через электронную подпись, сертифицируемую государством и/или с помощью сгенерированного электронного ключа (токена).</p>
                    <p>Сессия (канал связи) между клиентом и системой шифруется 256 битным ключом. Обычно используется GlobalSign или его аналоги.</p>
                    <p>Между фронтовыми системами Мобильного банкинга и бэк-офис системой Мобильного банкинга (серверами СУБД) стоит ряд промежуточных серверов - Аппликейшн серверов, которые обрабатывают запросы и передают на исполнение и/или останавливают операцию. Эти промежуточные сервера находятся в DMZ зоне.</p>
                    <p>Согласно многолетнему опыту нашей компании и современным трендам в сфере финансовой безопасности, мы рекомендуем Банкам использовать различные Firewall, IDS и IPS системы для отслеживания подозрительных запросов, DDos атак и т.д.</p>
                </div>
                <div class="projects-tech-right wow fadeInUp" date-wow-delay="0.4s">
                    <h3>Система «GNI@ MOBILE BANK 24/7» состоит из нижеуказанных модулей и подсистем</h3>
                    <div class="accordeon">
                        @foreach(\App\Models\Newspaper::where('type', 'QUESTION')->get() as $item)
                        <div class="accordeon_box">
                            <div class="accordeon__item">
                                <p>{{ $item->title }}</p>
                                <span></span>
                            </div>
                            <div class="accordeon_block">
                                <p>{{ $item->mini_desc }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('_components.tech')
@endsection
