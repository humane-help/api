@extends('layouts.app')

@section('content')
    @include('layouts.banner')

    <!-- Solutions -->
    <section class="solutions">
        <div class="con">
            <h2>{{ __('app.services') }}
                <img src="img/icons.png" alt="">
            </h2>
            <div class="solutions__box">
                @foreach(\App\Models\Newspaper::where('type', 'SERVICE')->get() as $item)
                    <a href="/{{ app()->getLocale() }}/services/{{$item->id}}" class="solutions__block wow fadeInUp" date-wow-delay="0.3s">
                        <h5>{{ $item->title }}</h5>
                        <p>{{ $item->mini_desc }}</p>
                    </a>
                @endforeach
            </div>
            <br/>
            <br/>
        </div>
    </section>

@endsection