@extends('layouts.app')
@section('content')
    @include('layouts.banner')

    <!-- Projects box -->
    <div class="con">
        <div class="projects-box">
            <div class="t-col t-col_10 t-prefix_1"> <div class="t015__title t-title t-title_lg" field="title" style="">
                    <h2  data-customstyle="yes">{{ $data ? $data->title : '' }}</h2>
                </div>
            </div>
            <br>
            <br>
            <div>
                {!! $data ? $data->content : '' !!}
            </div>
        </div>
    </div>
    <!-- Advantage -->
    <div class="con">
        <h2 style="color: white;">{{ __('app.advantages', ['solution' => $data->img]) }}
            <img src="img/icons.png" alt="">
        </h2>
        <div class="solutions__box wow fadeInUp" date-wow-delay="0.2s">
            @foreach(\App\Models\Newspaper::findMany(explode(',', $data->advantages)) as $item)
                <div class="solutions__block wow  wow fadeInUp">
                    <h5>
                     <img height="40" src="{{ $item->img }}" alt="">    {{ $item->title }}</h5>
                    <p>{{ $item->mini_desc }}</p>
                    <span><img src="img/icon-1.png" alt=""></span>
                </div>
            @endforeach
        </div>
    </div>
    <!-- Question tech -->
    <div class="projects-tech">
        <div class="con">
            <div class="projects-tech__box wow  wow fadeInUp" date-wow-delay="0.2s">
                @if ($data->technologies)
                    <div class="projects-box">
                        <img src="img/icons.png" alt="">
                        <h2>{{ __('app.technologies') }}</h2>
                        <p>{!! $data->technologies !!}</p>
                    </div>
                @endif
                <div class="projects-tech-right wow  wow fadeInUp" date-wow-delay="0.2s" style="width: @php echo $data->technologies ? "47%;" : "100%;" @endphp">
                    <h3>{{ __('app.advantage_block', ['solution' => $data->img]) }}</h3>
                    <div class="accordeon">
                        @php
                            $selectedQuestions = explode(',', $data->questions);
                        @endphp
                        @foreach($selectedQuestions as $question)
                            @php
                                $item = $question ? \App\Models\Newspaper::find($question) : false;
                            @endphp
                            @if ($item)
                            <div class="accordeon_box">
                                <div class="accordeon__item">
                                    <p>{{ $item->title }}</p>
                                    <span></span>
                                </div>
                                <div class="accordeon_block">
                                    <p>{!! $item->content !!}</p>
                                </div>
                            </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection