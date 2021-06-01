@extends('layouts.app')

@section('content')
    @include('layouts.banner')

    <!-- Solutions -->
    <section class="solutions">
        <div class="con">
            <h2 style="text-align: center;">{{ __('app.management') }}
                <img src="img/icons.png" alt="">
            </h2>
            <div class="solutions__box">
                @foreach(\App\Models\Newspaper::where('type', 'MANAGEMENT')->get() as $item)
                    <div class="solutions__block wow fadeInUp" date-wow-delay="0.2s" style="text-align: center;">
                        <div class="kom">
                            <img style="vertical-align: middle;
                            " src="{{ $item->img }}">
                        </div>
                        <h5>{{ $item->title }}</h5>
                        <p>{{ $item->mini_desc }}</p>
                        <p>{!! $item->content !!}</p>
                    </div>
                @endforeach
            </div>
            <br>
            <br>
            <h2 style="text-align: center;">{{ __('app.team') }}
                <img src="img/icons.png" alt="">
            </h2>
            <div class="solutions__box">
                @foreach(\App\Models\Newspaper::where('type', 'TEAM')->get() as $item)
                    <div class="solutions__block wow fadeInUp" date-wow-delay="0.2s" style="text-align: center;">
                        <div class="kom">
                            <img style="vertical-align: middle;
                            " src="{{ $item->img }}">
                        </div>
                        <h5>{{ $item->title }}</h5>
                        <p>{{ $item->mini_desc }}</p>
                        <p>{!! $item->content !!}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

@endsection