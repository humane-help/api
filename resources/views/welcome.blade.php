@extends('layouts.app')

@section('content')
    @include('layouts.banner')

    <!-- Benefits -->
    <section class="benefits">
        <div class="con">
                <span class="benefits__decor">
                    
                </span>
            <div class="benefits__box">
                <h2>{{ __('app.title_advantage') }}
                    <img src="{{ asset('img/icons.png') }}" alt="">
                </h2>
                <div class="benefits__block wow fadeInUp"  data-wow-delay="0.5s">
                    <div class="img">
                        <img src="{{ asset('img/box.svg') }}" alt="">
                    </div>
                    <div class="benefits__content">
                        <h4>{{ __('app.complexity') }}</h4>
                        
                        <p>{{ __('app.complexity_info') }}</p>
                    </div>
                </div>
                <div class="benefits__block block-right wow fadeInUp"  data-wow-delay="0.6s">
                    <div class="img">
                        <img src="{{ asset('img/energy.svg') }}" alt="">
                    </div>
                    <div class="benefits__content">
                        <h4>{{ __('app.customizability') }}</h4>
                        
                        <p>{{ __('app.customizability_info') }}</p>
                    </div>
                </div>
                <div class="benefits__block wow fadeInUp"  data-wow-delay="0.7s">
                    <div class="img">
                        <img src="{{ asset('img/complex.svg') }}" alt="">
                    </div>
                    <div class="benefits__content">
                        <h4>{{ __('app.minimize_risk') }}</h4>
                        
                        <p>{{ __('app.minimize_risk_info') }}</p>
                    </div>
                </div>
                <div class="benefits__block block-right wow fadeInUp"  data-wow-delay="0.8s">
                    <div class="img">
                        <img src="{{ asset('img/search.svg') }}" alt="">
                    </div>
                    <div class="benefits__content">
                        <h4>{{ __('app.transparency') }}</h4>
                        
                        <p>{{ __('app.transparency_info') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Carousel -->
    @include('_components.tech')

    <!-- Pride -->
    <section class="pride">
        <div class="con">
            <div class="pride__box">
                <div class="pride__decor">
                    
                    <img src="{{ asset('img/icons.png') }}" alt="">
                </div>
                <h2>{{ __('app.our_projects') }}</h2>
                <div class="pride__block">
                    @foreach(\App\Models\Newspaper::where('type', 'PROJECT')->limit(3)->get() as $item)
                        <div class="pride__card wow fadeInUp" >
                            <img src="{{ $item->img }}" alt="">
                            <p>{{ $item->title }} </p>
                            <h6>{{ $item->mini_desc }}</h6>
                        </div>
                    @endforeach
                </div>
                <a href="/{{ \Illuminate\Support\Facades\App::getLocale() }}/projects" class="main-btn pride-btn">{{ __('app.all_projects') }}</a>
            </div>
        </div>
    </section>

    <!-- Reviews -->
    <section class="reviews">
        <div class="con">
            <div class="reviews__top">
                <div class="reviews__decor">
                    
                    <img src="{{ asset('img/icons.png') }}" alt="">
                </div>
                <h2>{{ __('app.reviews') }}</h2>
                <a href="/{{ app()->getLocale() }}/letters" class="main-btn">{{ __('app.all_reviews') }}</a>
            </div>
            <div class="reviews__box">
                @foreach(\App\Models\Newspaper::where('type', 'REVIEWS')->get() as $item)
                <div class="reviews-track">
                    <p class="reviews__text">{{  $item->content }}</p>
                    <div style=""><img height="100" src="{{ $item->img }}"></div>
                    <p>{{ $item->title }}</p>
                    <p>{{ $item->mini_desc }}</p>
                </div>
               @endforeach
            </div>
        </div>
    </section>

    <!-- News -->
    <section class="news">
        <div class="con">
            <div class="news__decor">
                
            </div>
            <h2>{{ __('app.news') }}
                <img src="{{ asset('img/icons.png') }}" alt="">
            </h2>
            <div class="news__box">
                @foreach(\App\Models\Article::all() as $item)
                    <a href="/{{ app()->getLocale() }}/news/{{ $item->id }}" class="news-track">
                        <img src="{{ $item->img }}" alt="">
                        <div class="">
                            <h5>{{ \Carbon\Carbon::parse(new \Carbon\Carbon($item->published_at, 'UTC'))->format('Y-m-d') }}</h5>
                            <p>{{ $item->title }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
@endsection