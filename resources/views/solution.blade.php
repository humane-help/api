@extends('layouts.app')

@section('content')
    @include('layouts.banner')

    <!-- Solutions -->
    <section class="solutions">
        <div class="con">
            <h2>{{ __('app.solutions') }}
                <img src="img/icons.png" alt="">
            </h2>
            <div class="solutions__box">
                @php $i = 1 @endphp
                @foreach(\App\Models\Newspaper::where('type', 'SOLUTION')->get() as $item)
                <a href="/{{ \Illuminate\Support\Facades\App::getLocale() }}/solutions/{{$item->id}}" class="solutions__block wow fadeInUp" date-wow-delay="0.2s">
                        <h5>{{ $item->title }}</h5>
                        <p>{{ $item->mini_desc }}</p>
                </a>
                @php $i++ @endphp
                @endforeach
            </div>
        </div>
    </section>

    @include('_components.tech')
@endsection
