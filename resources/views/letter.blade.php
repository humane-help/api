@extends('layouts.app')
@section('content')
    @include('layouts.banner')

    <!-- Projects -->
    <section class="solutions projects">
        <div class="con">
            <h2>{{ __('app.letters') }}
                <img src="img/icons.png" alt="">
            </h2>
            <div class="solutions__box">
                @foreach(\App\Models\Newspaper::where('type', 'LETTER')->get() as $item)
                    @php
                     if ($item->img) {
                    @endphp
                    <div class="solutions__block" style="border: 0px;">
                        <img style="width: 350px;" src="{{ $item->img }}" alt=""/>
                    </div>
                    @php 
                        }
                    @endphp
                @endforeach
            </div>
        </div>
    </section>

@endsection