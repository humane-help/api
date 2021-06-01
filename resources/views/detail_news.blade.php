@extends('layouts.app')
@section('content')
    @include('layouts.banner')

    <!-- Projects box -->
    <div class="con">
        <div class="projects-box">
            <h5>{{ $data && $data->published_at ? \Carbon\Carbon::parse(new \Carbon\Carbon($data->published_at, 'UTC'))->format('Y-m-d') : '' }}</h5><br>
            <div class="t-col t-col_10 t-prefix_1"> <div class="t015__title t-title t-title_lg wow fadeInUp" field="title" style="">
                    <div style="font-size:36px;" data-customstyle="yes">{{ $data ? $data->title : '' }}</div>
                </div>
            </div>
            <br>
            <br>
            <div>
                {!! $data ? $data->content : '' !!}
            </div>
        </div>
    </div>

@endsection