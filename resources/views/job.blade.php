@extends('layouts.app')

@section('content')
    @include('layouts.banner')

    <!-- Solutions -->
    <section class="solutions">
        <div class="con">
            <h2>{{ __('app.job') }}
                <img src="img/icons.png" alt="">
            </h2>
            <div class="solutions__box">
		<h4 style="color:white;">В данный момент в GNI Software нет открытых вакансий
</h4>
                @foreach(\App\Models\Newspaper::where('type', 'JOB')->get() as $item)
                    <div class="solutions__block wow fadeInUp" style="text-align: center;">
                        <img style="vertical-align: middle;
                          width: 160px;
                          height: 160px;
                          border-radius: 50%;" src="{{ $item->img }}">
                        <h5>{{ $item->title }}</h5>
                        <p>{{ $item->mini_desc }}</p>
                        <p>{!! $item->content !!}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

@endsection
