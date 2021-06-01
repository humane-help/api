@extends('layouts.app')
<style>

    .t-col_10 {
        max-width: 960px;
    }
    .t-col {
        display: inline;
        float: left;
        width: 100%;
    }
    .t-title {
        font-weight: 500;
        color: #fff;
    }
</style>
@section('content')
    @include('layouts.banner')

    <!-- Projects box -->
    <div class="con">
        <div class="projects-box wow fadeIn" data-wow-delay="0.2s">
            <div class="t-col t-col_10 t-prefix_1"> <div class="t015__title t-title t-title_lg" field="title" style=""><h2 style="font-size:36px;" data-customstyle="yes">
               {{ __('app.about') }}
                    </h2></div> </div>
            <br>
            <br>
             <p>
                 {!! $data ? $data->content : '' !!}
             </p>
        </div>
    </div>

@endsection