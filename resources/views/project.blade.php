@extends('layouts.app')

@section('content')
    @include('layouts.banner')

    <section class="pride">
        <div class="con">
            <div class="pride__box">
                <div class="pride__decor">
                    
                    <img src="img/icons.png" alt="">
                </div>
                <h2>{{ __('app.projects') }}</h2>
                <div class="pride__block">
                    @foreach(\App\Models\Newspaper::where('type', 'PROJECT')->get() as $item)
                        <a href="/{{ \Illuminate\Support\Facades\App::getLocale() }}/projects/{{$item->id}}" class="pride__card wow fadeInUp" date-wow-delay="0.3s" style="margin-top: 10px;">
                            <img src="{{ $item->img }}" alt="">
                            <p>{{ $item->title }} </p>
                            <h6>{{ $item->mini_desc }}</h6>
                        </a>
                    @endforeach
                </div>

            </div>
        </div>
    </section>
    <br>
    <br>

    @include('_components.tech')
@endsection
